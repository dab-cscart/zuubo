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

use Tygh\Registry;

class Patterns
{
    /**
     * Gets theme patterns
     * @param  string $style_id style ID
     * @return array  theme patterns
     */
    public static function get($style_id)
    {
        $style_id = fn_basename($style_id);

        $url = Registry::get('config.current_location') . '/' . fn_get_theme_path('[relative]/[theme]/media/images/patterns/' . $style_id . '/');
        $patterns = self::getPath($style_id);

        return fn_get_dir_contents($patterns, false, true, '', $url);
    }

    /**
     * Saves uploaded pattern to theme
     * @param  string $style_id     style ID
     * @param  array  $style        style
     * @param  array  $uploaded_data uploaded data
     * @return array  modified style
     */
    public static function save($style_id, $style, $uploaded_data)
    {
        $style_id = fn_basename($style_id);
        $patterns = self::getPath($style_id);
        if (!is_dir($patterns)) {
            fn_mkdir($patterns);
        }

        foreach ($uploaded_data as $var => $file) {
            $fname = $var . '.' . fn_get_file_ext($file['name']);

            if (fn_copy($file['path'], $patterns . '/' . $fname)) {
                $style['data'][$var] = "url('" . self::getRelPath($style_id) . '/' . $fname . '?' . TIME . "')";
            }
        }

        return $style;
    }

    /**
     * Gets patterns absolute path
     * @param  string $style_id style ID
     * @return string patterns absolute path
     */
    public static function getPath($style_id)
    {
        return fn_get_theme_path('[themes]/[theme]/media/images/patterns/' . fn_basename($style_id));
    }

    /**
     * Gets patterns relative (to css files) path
     * @param  string $style_id style ID
     * @return string patterns relative path
     */
    public static function getRelPath($style_id)
    {
        return '../media/images/patterns/' . fn_basename($style_id);
    }
}
