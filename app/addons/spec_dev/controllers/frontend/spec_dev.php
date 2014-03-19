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

if (!defined('BOOTSTRAP')) { die('Access denied'); }

use Tygh\Registry;

if ($mode == 'choose_location') {

    fn_add_breadcrumb(__('choose_location'));

    $_ip = fn_get_ip(true);
    $_country = fn_get_country_by_ip($_ip['host']);

    if (empty($_country)) {
	$_country = Registry::get("settings.General.default_country");
    }
    list($metro_cities, ) = fn_get_metro_cities(array('country_code' => $_country));
    if (!empty($metro_cities)) {
	foreach ($metro_cities as $i => $dt) {
	    list($metro_cities[$i]['cities'], ) = fn_get_cities(array('metro_city_id' => $dt['metro_city_id']));
	}
    }

    Registry::get('view')->assign('metro_cities', $metro_cities);
    Registry::get('view')->assign('return_url', $_REQUEST['return_url']);
    
} elseif ($mode == 'set_location') {

    fn_set_session_data('location', $_REQUEST['mc_id'], COOKIE_ALIVE_TIME);
    fn_set_location($_REQUEST);
    $redirect_url = !empty($_REQUEST['return_url']) ? $_REQUEST['return_url'] : fn_url('');

    return array(CONTROLLER_STATUS_REDIRECT, $redirect_url);
}