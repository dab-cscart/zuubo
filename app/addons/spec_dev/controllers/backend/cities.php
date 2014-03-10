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
    // Create/update city
    //
    //
    if ($mode == 'update') {
        fn_update_city($_REQUEST['city_data'], $_REQUEST['city_id'], DESCR_SL);
    }

    // Updating existing cities
    //
    if ($mode == 'm_update') {
        foreach ($_REQUEST['cities'] as $key => $_data) {
            if (!empty($_data)) {
                fn_update_city($_data, $key, DESCR_SL);
            }
        }
    }

    //
    // Delete selected cities
    //
    if ($mode == 'm_delete') {

        if (!empty($_REQUEST['city_ids'])) {
            foreach ($_REQUEST['city_ids'] as $v) {
                db_query("DELETE FROM ?:cities WHERE city_id = ?i", $v);
            }
        }
    }

    return array(CONTROLLER_STATUS_OK, "cities.manage?country_code=$_REQUEST[country_code]&state_code=$_REQUEST[state_code]&metro_city_id=$_REQUEST[metro_city_id]");
}

if ($mode == 'manage') {

    $params = $_REQUEST;
    if (empty($params['country_code'])) {
        $params['country_code'] = Registry::get('settings.General.default_country');
    }

    list($cities, $search) = fn_get_cities($params, Registry::get('settings.Appearance.admin_elements_per_page'));

    Registry::get('view')->assign('cities', $cities);
    Registry::get('view')->assign('search', $search);

    Registry::get('view')->assign('countries', fn_get_simple_countries(false, DESCR_SL));
    Registry::get('view')->assign('states', fn_get_all_states());
    list($metro_cities, ) = fn_get_metro_cities(array('tree' => true));
    Registry::get('view')->assign('metro_cities', $metro_cities);

} elseif ($mode == 'delete') {

    if (!empty($_REQUEST['city_id'])) {
        db_query("DELETE FROM ?:cities WHERE city_id = ?i", $_REQUEST['city_id']);
    }

    return array(CONTROLLER_STATUS_REDIRECT, "cities.manage?country_code=$_REQUEST[country_code]");
}

/** /Body **/
