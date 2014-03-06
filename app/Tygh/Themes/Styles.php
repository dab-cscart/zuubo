<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/

namespace Tygh\Themes;

use Tygh\Less;
use Tygh\Themes\Patterns;
use Tygh\Registry;

class Styles
{
    private static $instances = array();
    private static $manifest = array();

    private $theme_name = '';
    private $schema = array();

    private $gfonts_tag = 'GFONTS';

    public function __construct($theme_name)
    {
        $this->theme_name = $theme_name;

        $path = fn_get_theme_path('[themes]/' . $theme_name . '/styles/', 'C');

        // FIXME: Presets backward compatibility
        if (!is_dir($path)) {
            $path = fn_get_theme_path('[themes]/' . $theme_name . '/presets/', 'C');
        }

        if (file_exists($path . 'schema.json')) {
            $schema = fn_get_contents($path . 'schema.json');
            $this->schema = json_decode($schema, true);
        } else {
            $this->schema = array();
        }
    }

    /**
     * Gets list of styles
     *
     * @return array List of available styles
     */
    public function getList($params = array())
    {
        $styles = array();

        $theme_path = $this->getStylesPath();

        if (is_dir($theme_path)) {
            $style_files = fn_get_dir_contents($theme_path, false, true, 'less');
        }

        if (!empty($style_files)) {
            foreach ($style_files as $id => $style_id) {
                $style_id = fn_basename($style_id, '.less');
                $styles[$style_id] = self::get($style_id, $params);
            }
        }

        return $styles;
    }

    /**
     * Gets full style information
     *
     * @param string $style_id File name of the style schema (like: "satori")
     * @param array  $params   Extra parameters
     *      array(
     *          'parse' parse less to variables if true
     *      )
     * @return array Style information
     */
    public function get($style_id, $params = array())
    {
        if (!empty(self::$manifest[$style_id])) {
            $manifest = self::$manifest[$style_id];
        } else {
            $manifest = self::$manifest[$style_id] = $this->getManifest();
        }

        $style_id = fn_basename($style_id);
        $style = array();
        $data = array();
        $parsed = array();
        $less_content = fn_get_contents($this->getStyleFile($style_id));

        if (!empty($less_content)) {
            if (!empty($params['parse'])) {
                $less = new Less();
                $data = $less->extractVars($less_content);
                $parsed = $this->cssToUrl($data);
            }

            $style = array(
                'style_id' => $style_id,
                // FIXME: Backward presets compatibility
                'preset_id' => $style_id,
                'data' => $data,
                'name' => isset($manifest['names'][$style_id]) ? $manifest['names'][$style_id] : $style_id,
                'parsed' => $parsed,
                'image' => file_exists($this->getStylesPath() . '/' . $style_id . '.png') ? $this->getStylesPath(true) . '/' . $style_id . '.png' : '',
            );

            if (empty($params['short_info'])) {
                $custom_css = $this->getCustomCss($style_id);

                $style['less'] = $less_content;
                $style['custom_css'] = $custom_css;
            }
        }

        return $style;
    }

    /**
     * Saves less data to style file
     *
     * @param string $style_id File name of the style schema (like: "satori")
     * @param array  $style    style
     *
     * @return boolean false on failure, true on success
     */
    public function update($style_id, $style)
    {
        $style_id = fn_basename($style_id);
        $style_path = $this->getStyleFile($style_id);

        $current_style = $this->get($style_id);
        $less = empty($current_style['less']) ? '' : $current_style['less'];

        $style['data'] = $this->processCopy($style_id, $style['data']);

        foreach ($style['data'] as $var_name => $value) {

            $less_var = Less::arrayToLessVars(array($var_name => $value));

            if (preg_match('/@' . $var_name . ':.*?;/m', $less)) {
                $less = preg_replace('/@' . $var_name . ':.*?;$/m', str_replace("\n", '', $less_var), $less);
            } else {
                $less .= $less_var;
            }
        }

        $less = $this->addGoogleFonts($style['data'], $less);

        $this->addCustomCss($style_id, $style['custom_css']);

        return fn_put_contents($style_path, $less);
    }

    /**
     * Deletes style
     * @param  string  $style_id style ID
     * @return boolean true on succes, false otherwise
     */
    public function delete($style_id)
    {
        $style_id = fn_basename($style_id);

        if (fn_rm($this->getStyleFile($style_id))) {
            fn_rm($this->getStyleFile($style_id, true)); // remove custom css
            fn_rm(Patterns::getPath($style_id));

            return true;
        }

        return false;
    }

    /**
     * Gets default style name
     *
     * @return string Style name (like: satori)
     */
    public function getDefault()
    {
        $manifest = self::getManifest();

        return !empty($manifest['default_style']) ? $manifest['default_style'] : '';
    }

    /**
     * Gets manifest information
     *
     * @return array Manifest data
     */
    public function getManifest()
    {
        $manifest = array();
        $manifest_path = fn_get_theme_path('[themes]/' . $this->theme_name . '/styles/manifest.json', 'C');

        if (is_file($manifest_path)) {
            $manifest = json_decode(fn_get_contents($manifest_path), true);
        } else {
            //FIXME: Presets backward compatibility
            $manifest_path = fn_get_theme_path('[themes]/' . $this->theme_name . '/presets/manifest.json', 'C');
            if (is_file($manifest_path)) {
                $manifest = json_decode(fn_get_contents($manifest_path), true);
            }
        }

        return $manifest;
    }

    /**
     * Processes data copy according to schema
     * @param  string $style_id style ID
     * @param  array  $data     style
     * @return return style
     */
    public function processCopy($style_id, $data)
    {
        if (!empty($data['copy'])) {
            foreach ($this->schema['backgrounds']['fields'] as $field_id => $field_data) {
                if (empty($field_data['copies'])) {
                    continue;
                }

                foreach ($field_data['copies'] as $property => $fields) {
                    foreach ($fields as $field) {
                        if (!empty($data['copy'][$property][$field_id])) {
                            if (!empty($field['inverse'])) {
                                $data[$field['match']] = $field['default'];
                            } elseif (isset($data[$field['source']])) {
                                $data[$field['match']] = $data[$field['source']];
                            }
                        } else {
                            if (empty($field['inverse'])) {
                                $data[$field['match']] = $field['default'];
                            }
                        }
                    }
                }
            }
        }

        unset($data['copy']);

        $data = $this->urlToCss($style_id, $data);

        return $data;
    }

    /**
     * Gets style schema
     * @return array style schema
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * Change style id for specified layout
     *
     * @param  int    $layout_id Layout ID
     * @param  string $style_id  Style name (Like: "satori", "ocean", etc)
     * @return true   if updated
     */
    public function setStyle($layout_id, $style_id)
    {
        $result = db_query('UPDATE ?:bm_layouts SET style_id = ?s WHERE layout_id = ?i AND theme_name = ?s', $style_id, $layout_id, $this->theme_name);

        return $result;
    }

    /**
     * Copy style
     * @param  string  $from style ID to copy from
     * @param  string  $to   style ID to copy to
     * @return boolean true on success, false otherwise
     */
    public function copy($from, $to)
    {
        $from = fn_basename($from);
        $to = fn_basename($to);

        $style_file_from = $this->getStyleFile($from);
        $style_file_to = $this->getStyleFile($to);

        if (is_file($style_file_from)) {
            if (fn_copy($style_file_from, $style_file_to)) {

                $style_css_from = $this->getStyleFile($from, true);
                if (file_exists($style_css_from)) {
                    fn_copy($style_css_from, $this->getStyleFile($to, true));
                }

                fn_copy(Patterns::getPath($from), Patterns::getPath($to));
                $content = fn_get_contents($style_file_to);
                $content = str_replace('/patterns/' . $from . '/', '/patterns/' . $to . '/', $content);
                fn_put_contents($style_file_to, $content);

                return true;
            }

        }

        return false;
    }

    /**
     * Gets style LESS code
     * @param  array  $current_style style data to override current style data
     * @return string style LESS code
     */
    public function getLess($current_style = array())
    {
        $custom_less = '';

        $style = $this->get(Registry::get('runtime.layout.style_id'));

        if (!empty($style['less'])) {
            $custom_less = $style['less'];
            $custom_less .= "\n" . $style['custom_css'];
        }

        if (!empty($current_style)) {
            $custom_less .= Less::arrayToLessVars($current_style);
        }

        return $custom_less;
    }

    /**
     * Gets style file path
     * @param  string  $style_id style ID
     * @param  boolean $css      gets custom css file is set to true
     * @return string  style file path
     */
    public function getStyleFile($style_id, $css = false)
    {
        return $this->getStylesPath() . '/' . $style_id . ($css == true ? '.css' : '.less');
    }

    /**
     * Gets styles path
     * @return string styles path
     */
    private function getStylesPath($get_relative = false)
    {
        $_path = $get_relative ? '[relative]' : '[themes]';

        // FIXME: Presets backward compatibility
        $styles_path = fn_get_theme_path($_path . '/' . $this->theme_name . '/presets/data', 'C');
        if (is_dir($styles_path)) {
            return $styles_path;
        } else {
            return fn_get_theme_path($_path . '/' . $this->theme_name . '/styles/data', 'C');
        }

    }

    /**
     * Gets custom CSS code from LESS code
     * @param  string $style_id style ID
     * @return string custom CSS code
     */
    private function getCustomCss($style_id)
    {
        $file = $this->getStyleFile($style_id, true);
        if (file_exists($file)) {
            return fn_get_contents($file);
        }

        return '';
    }

    /**
     * Adds custom css to style LESS
     * @param  string  $style_id   style ID
     * @param  string  $custom_css CSS code
     * @return integer custom CSS length, written to file, boolean false on error
     */
    private function addCustomCss($style_id, $custom_css)
    {
        return fn_put_contents($this->getStyleFile($style_id, true), $custom_css);
    }

    /**
     * Adds Google Font initialization to style LESS
     * @param  array  $style_data style data
     * @param  string $less       style LESS code
     * @return string style LESS code
     */
    private function addGoogleFonts($style_data, $less)
    {
        $content = array();

        $less = preg_replace("#/\*{$this->gfonts_tag}\*/(.*?)/\*/{$this->gfonts_tag}\*/#s", '', $less);

        foreach ($this->schema['fonts']['fields'] as $field => $data) {
            if (empty($this->schema['fonts']['families'][$style_data[$field]])) {
                // Google font!
                if (empty($content[$style_data[$field]])) {
                    $css = fn_get_contents('https://fonts.googleapis.com/css?family=' . $style_data[$field]);
                    if (!empty($css)) {
                        $content[$style_data[$field]] = $css;
                    }
                }
            }
        }

        if (!empty($content)) {
            $less .= "\n/*{$this->gfonts_tag}*/" . "\n" . implode("\n", $content) . "\n/*/{$this->gfonts_tag}*/";
        }

        return $less;
    }

    /**
     * Converts CSS property ( url("../a.png") ) to URL (http://e.com/a.png)
     * @param  array $style_data style data
     * @return array modified parsed style data vars
     */
    private function cssToUrl($style_data)
    {
        $url = Registry::get('config.current_location') . '/' . fn_get_theme_path('[relative]/[theme]/');
        $parsed = array();
        if (!empty($this->schema['backgrounds']['fields'])) {
            foreach ($this->schema['backgrounds']['fields'] as $field) {
                if (!empty($field['properties']['pattern'])) {
                    $var_name = $field['properties']['pattern'];

                    if (!empty($style_data[$var_name]) && strpos($style_data[$var_name], 'url(') !== false) {
                        $parsed[$var_name] = preg_replace('/url\([\'"]?\.\.\/(.*?)[\'"]?\)/', $url . '$1', $style_data[$var_name]);
                    }
                }
            }
        }

        return $parsed;
    }

    /**
     * Converts URL (http://e.com/a.png) to CSS property ( url("../a.png") )
     * @param  string $style_id   style ID
     * @param  array  $style_data style data (fields)
     * @return array  modified style data
     */
    private function urlToCss($style_id, $style_data)
    {
        $patterns_url = Registry::get('config.current_location') . '/' . fn_get_theme_path('[relative]/[theme]');

        if (!empty($this->schema['backgrounds']['fields'])) {
            foreach ($this->schema['backgrounds']['fields'] as $field) {
                if (!empty($field['properties']['pattern'])) {
                    $var_name = $field['properties']['pattern'];

                    if (!empty($style_data[$var_name]) && strpos($style_data[$var_name], '//') !== false) {

                        $url = preg_replace('/url\([\'"]?(.*?)[\'"]?\)/', '$1', $style_data[$var_name]);
                        if (strpos($url, '//') === 0) {
                            $url = 'http:' . $url;
                        }

                        if (strpos($url, $patterns_url) !== false) {
                            $url = str_replace($patterns_url, '..', $url);
                        } elseif ($style_id) { // external url
                            $content = fn_get_contents($url);
                            $filename = basename($url);

                            fn_put_contents(Patterns::getPath($style_id) . '/' . $var_name . '.' . fn_get_file_ext($filename), $content);

                            $url = Patterns::getRelPath($style_id) . '/' . $var_name . '.' . fn_get_file_ext($filename);
                        }

                        $style_data[$var_name] = 'url(' . $url . '?' . TIME . ')';
                    }
                }
            }
        }

        return $style_data;
    }

    public static function factory($theme_name)
    {
        if (empty(self::$instances[$theme_name])) {
            self::$instances[$theme_name] = new self($theme_name);
        }

        return self::$instances[$theme_name];
    }
}
