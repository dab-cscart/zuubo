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

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

/** Body **/

if (empty($_REQUEST['country_code'])) {
    $_REQUEST['country_code'] = Registry::get('settings.General.default_country');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //
    // Create/update metro_city
    //
    //
    if ($mode == 'update') {
        fn_update_metro_city($_REQUEST['metro_city_data'], $_REQUEST['metro_city_id'], DESCR_SL);
    }

    // Updating existing metro_cities
    //
    if ($mode == 'm_update') {
        foreach ($_REQUEST['metro_cities'] as $key => $_data) {
            if (!empty($_data)) {
                fn_update_metro_city($_data, $key, DESCR_SL);
            }
        }
    }

    //
    // Delete selected metro_cities
    //
    if ($mode == 'm_delete') {

        if (!empty($_REQUEST['metro_city_ids'])) {
            foreach ($_REQUEST['metro_city_ids'] as $v) {
                db_query("DELETE FROM ?:metro_cities WHERE metro_city_id = ?i", $v);
                db_query("DELETE FROM ?:metro_city_descriptions WHERE metro_city_id = ?i", $v);
            }
        }
    }

    return array(CONTROLLER_STATUS_OK, "metro_cities.manage?country_code=$_REQUEST[country_code]");
}

if ($mode == 'manage') {

    $params = $_REQUEST;
    if (empty($params['country_code'])) {
        $params['country_code'] = Registry::get('settings.General.default_country');
    }

    list($metro_cities, $search) = fn_get_metro_cities($params, Registry::get('settings.Appearance.admin_elements_per_page'), DESCR_SL);

    Registry::get('view')->assign('metro_cities', $metro_cities);
    Registry::get('view')->assign('search', $search);

    Registry::get('view')->assign('countries', fn_get_simple_countries(false, DESCR_SL));

} elseif ($mode == 'delete') {

    if (!empty($_REQUEST['metro_city_id'])) {
        db_query("DELETE FROM ?:metro_cities WHERE metro_city_id = ?i", $_REQUEST['metro_city_id']);
        db_query("DELETE FROM ?:metro_city_descriptions WHERE metro_city_id = ?i", $_REQUEST['metro_city_id']);
    }

    return array(CONTROLLER_STATUS_REDIRECT, "metro_cities.manage?country_code=$_REQUEST[country_code]");
}

/** /Body **/
