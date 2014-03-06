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

namespace Twigmo\Upgrade;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

use Tygh\Registry;
use Tygh\BlockManager\Exim;
use Tygh\BlockManager\Location;
use Twigmo\Core\Functions\Lang;
use Twigmo\Core\Functions\UserAgent;
use Twigmo\Core\TwigmoConnector;
use Tygh\Languages\Values as LanguageValues;
use Twigmo\Core\TwigmoSettings;

class TwigmoUpgrade
{
    final public static function checkUpgradePermissions($upgrade_dirs, $is_writable = true)
    {
        foreach ($upgrade_dirs as $upgrade_dir) {
            if (is_array($upgrade_dir)) {
                $is_writable = self::checkUpgradePermissions($upgrade_dir, $is_writable);
            } else {
                if (!is_dir($upgrade_dir) || !fn_uc_is_writable_dest($upgrade_dir)) {
                    return false;
                }
                $check_result = array();
                fn_uc_check_files($upgrade_dir, array(), $check_result, '', '');
                $is_writable = empty($check_result);
            }
            if (!$is_writable) {
                break;
            }
        }
        return $is_writable;
    }

    final public static function getUpgradeDirs($install_src_dir)
    {
        $dirs = array();
        $addon_path = 'twigmo/';
        $full_addon_path = 'addons/twigmo/';
        $repo_path = 'var/themes_repository/basic/';
        $backup_files_path = 'backup_files/';
        $file_areas = array(
            'media' => 'media/images',
            'css' => 'css',
            'templates' => 'templates'
        );

        // Installed dirs
        $dirs['installed'] = array(
            'addon' => Registry::get('config.dir.addons') . $addon_path,
        );
        foreach ($file_areas as $key => $file_area) {
            $dirs['installed'][$key . '_backend'] = fn_get_theme_path(
                '[themes]/[theme]/',
                'A'
            ) . $file_area . '/' . $full_addon_path;
            $dirs['installed'][$key . '_frontend'][0] = fn_get_theme_path(
                '[themes]/[theme]/',
                'C'
            ) . $file_area . '/' . $full_addon_path;
        }

        // Repo dirs
        $dirs['repo'] = array(
            'addon' => Registry::get('config.dir.addons') . $addon_path,
         );
        foreach ($file_areas as $key => $file_area) {
            $dirs['repo'][$key . '_backend'] = fn_get_theme_path(
                '[themes]/',
                'A'
            ) . $file_area . '/' . $full_addon_path;
            $dirs['repo'][$key . '_frontend'] = fn_get_theme_path(
                '[repo]/basic/',
                'C'
            ) . $file_area . '/' . $full_addon_path;
        }

        // Distr dirs
        $dirs['distr'] = array(
            'addon' => $install_src_dir . 'app/' . $full_addon_path,
        );
        foreach ($file_areas as $key => $file_area) {
            $dirs['distr'][$key . '_backend'] = $install_src_dir . 'design/' . 'backend/' . $file_area . '/' . $full_addon_path;
            $dirs['distr'][$key . '_frontend'] = $install_src_dir . $repo_path . $file_area . '/' . $full_addon_path;
        }

        // Backup dirs
        $dirs['backup_root'] = TwigmoUpgradeMethods::getBackupDir();
        $dirs['backup_files'] = array(
            'addon' => $dirs['backup_root']
             . $backup_files_path
             . 'app/'
             . $full_addon_path,
        );
        foreach ($file_areas as $key => $file_area) {
            $dirs['backup_files'][$key . '_backend'] =
                $dirs['backup_root']
                . $backup_files_path
                . fn_get_theme_path(
                   '[relative]/[theme]/',
                   'A'
                )
                . $file_area . '/'
                . $full_addon_path;
            $dirs['backup_files'][$key . '_frontend'][0] =
                $dirs['backup_root']
                . $backup_files_path
                . fn_get_theme_path(
                   '[relative]/[theme]/',
                   'C'
                  )
                . $file_area . '/'
                . $full_addon_path;
        }

        // Settings backup dirs
        $dirs['backup_settings'] = $dirs['backup_root'] . 'backup_settings/';
        $dirs['backup_company_settings'] = array($dirs['backup_settings'] . 'companies/0/');
        if (fn_allowed_for('ULTIMATE')) {
            $company_ids = fn_get_all_companies_ids();
            $dirs['backup_company_settings'] = array();
            foreach ($file_areas as $key => $file_area) {
                $dirs['backup_files'][$key . '_frontend'] =
                $dirs['installed'][$key . '_frontend'] = array();
            }
            foreach ($company_ids as $company_id) {
                $dirs['backup_company_settings'][$company_id] =
                 $dirs['backup_settings'] . 'companies/' . $company_id . '/';

                // Installed frontend
                foreach ($file_areas as $key => $file_area) {
                    $dirs['installed'][$key . '_frontend'][$company_id] = fn_get_theme_path(
                        '[themes]/[theme]/',
                        'C',
                        $company_id
                    ) . $file_area . '/' . $full_addon_path;
                }

                // Backup frontend
                foreach ($file_areas as $key => $file_area) {
                    $dirs['backup_files'][$key . '_frontend'][$company_id] =
                        $dirs['backup_root']
                        . $backup_files_path
                        . fn_get_theme_path(
                           '[relative]/[theme]/',
                           'C',
                           $company_id
                          )
                        . $file_area . '/'
                        . $full_addon_path;
                }
            }
        }

        return $dirs;
    }

    final public static function getNextVersionInfo()
    {
        $version_info = fn_get_contents(TWIGMO_UPGRADE_DIR . TWIGMO_UPGRADE_VERSION_FILE);
        if ($version_info) {
            $version_info = unserialize($version_info);
        } else {
            $version_info = array('next_version' => '', 'description' => '', 'update_url' => '');
        }
        return $version_info;
    }

    final public static function downloadDistr()
    {
        // Get needed version
        $version_info = self::GetNextVersionInfo();
        if (!$version_info['next_version'] || !$version_info['update_url']) {
            return false;
        }
        $download_file_dir = TWIGMO_UPGRADE_DIR . $version_info['next_version'] . '/';
        $download_file_path = $download_file_dir . 'twigmo.tgz';
        $unpack_path = $download_file_path . '_unpacked';
        fn_rm($download_file_dir);
        fn_mkdir($download_file_dir);
        fn_mkdir($unpack_path);

        $data = fn_get_contents($version_info['update_url']);
        if (!fn_is_empty($data)) {
            fn_put_contents($download_file_path, $data);
            $res = fn_decompress_files($download_file_path, $unpack_path);

            if (!$res) {
                fn_set_notification('E', __('error'), __('twgadmin_failed_to_decompress_files'));
                return false;
            }
            return $unpack_path . '/';
        } else {
            fn_set_notification('E', __('error'), __('text_uc_cant_download_package'));
            return false;
        }
    }

    final public static function copyFiles($source, $dest)
    {
        if (is_array($source)) {
            foreach ($source as $key => $src) {
                self::copyFiles($src, $dest[$key]);
            }
        } else {
            fn_uc_copy_files($source, $dest);
        }

        return;
    }

    final public static function execUpgradeFunc($install_src_dir, $file_name)
    {
        $file = $install_src_dir . '/addons/twigmo/' . $file_name . '.php';
        if (file_exists($file)) {
            require_once($file);
        }

        return;
    }

    final public static function backupSettings($upgrade_dirs)
    {
        // Backup addon's settings to the session
        $_SESSION['twigmo_backup_settings'] = TwigmoSettings::get();

        // Backup twigmo blocks
        foreach ($upgrade_dirs['backup_company_settings'] as $company_id => $dir) {
            $location = Location::instance($company_id)->get('twigmo.post');
            if ($location) {
                $exim = Exim::instance($company_id);
                if (version_compare(PRODUCT_VERSION, '4.1.1', '>=')) {
                    $content = $exim->export(fn_twg_get_default_layout_id(), array($location['location_id']));
                } else {
                    $content = $exim->export(array($location['location_id']));
                }
                if ($content) {
                    fn_twg_write_to_file($dir . '/blocks.xml', $content, false);
                }
            }
        }

        // Backup twigmo langvars
        $languages = Lang::getLanguages();
        foreach ($languages as $language) {
            // Prepare langvars for backup
            $langvars = Lang::getAllLangVars($language['lang_code']);
            $langvars_formated = array();
            foreach ($langvars as $name => $value) {
                $langvars_formated[] = array('name' => $name, 'value' => $value);
            }
            fn_twg_write_to_file(
                $upgrade_dirs['backup_settings'] . '/lang_' . $language['lang_code'] . '.bak',
                $langvars_formated
            );
        }
        if (fn_allowed_for('ULTIMATE')) {
            db_export_to_file(
                $upgrade_dirs['backup_settings'] . 'lang_ult.sql',
                array(db_quote('?:ult_language_values')),
                'Y',
                'Y',
                false,
                false,
                false
            );
        }

        return true;
    }

    final public static function restoreSettingsAndCSS($upgrade_dirs)
    {
        // Restore langvars - for all languages except EN and RU
        $languages = Lang::getLanguages();
        $except_langs = array('en', 'ru');
        foreach ($languages as $language) {
            $backup_file =
                $upgrade_dirs['backup_settings']
                . 'lang_' . $language['lang_code'] . '.bak';
            if (
                !in_array(
                    $language['lang_code'],
                    $except_langs
                )
                and file_exists($backup_file)
            ) {
                LanguageValues::updateLangVar(
                    unserialize(
                        fn_get_contents($backup_file)
                    ),
                    $language['lang_code']
                );
            }
        }

        // Restore blocks
        foreach ($upgrade_dirs['backup_company_settings'] as $company_id => $dir) {
            $backup_file = $dir . 'blocks.xml';
            if (file_exists($backup_file)) {
                Exim::instance($company_id)->importFromFile($backup_file);
            }
        }

        // Restore settings if addon was connected
        $restored_settings = array(
            'my_private_key',
            'my_public_key',
            'his_public_key',
            'email',
            'customer_connections',
            'admin_connection'
        );
        $settings = array();
        foreach ($_SESSION['twigmo_backup_settings'] as $setting => $value) {
            if (in_array($setting, $restored_settings)) {
                $settings[$setting] = $value;
            }
        }
        $settings['version'] = TWIGMO_VERSION;
        unset($_SESSION['twigmo_backup_settings']);
        TwigmoSettings::set($settings);
        $connector = new TwigmoConnector();
        if (!$connector->updateConnections(true)) {
            $connector->disconnect(array(), true);
        }
    }

    final public static function updateFiles($upgrade_dirs)
    {
        // Remove all addon's files
        foreach ($upgrade_dirs['repo'] as $dir) {
            TwigmoUpgradeMethods::removeDirectoryContent($dir);
        }
        // Copy files from distr to repo
        self::copyFiles($upgrade_dirs['distr'], $upgrade_dirs['repo']);

        return;
    }

    final public static function checkForUpgrade()
    {
        $is_upgradable = false;
        if (isset($_SESSION['auth']) && $_SESSION['auth']['area'] == 'A' && !empty($_SESSION['auth']['user_id']) && fn_check_user_access($_SESSION['auth']['user_id'], 'upgrade_store')) {
            $is_upgradable = TwigmoConnector::checkUpdates();
            TwigmoConnector::updateUARules();
            if (TwigmoConnector::getAccessID('A')) {
                $connector = new TwigmoConnector();
                $connector->updateConnections();
                $connector->displayServiceNotifications();
            }

            UserAgent::sendUaStat();
        }

        return $is_upgradable;
    }
}
