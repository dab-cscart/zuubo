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
    
} elseif ($mode == 'change_location') {

    $_ip = fn_get_ip(true);
    fn_set_session_data('location', null, COOKIE_ALIVE_TIME);
    db_query("DELETE FROM ?:ip_locations WHERE ip_address = ?s", $_ip['host']);
    
    return array(CONTROLLER_STATUS_REDIRECT, "spec_dev.choose_location");
} elseif ($mode == 'set_location') {

    fn_set_session_data('location', $_REQUEST['mc_id'], COOKIE_ALIVE_TIME);
    fn_set_location($_REQUEST);
    $redirect_url = fn_url($_REQUEST['return_url']);

    return array(CONTROLLER_STATUS_REDIRECT, $redirect_url);
    
} elseif ($mode == 'check_points') {

    $gain_log = db_get_hash_multi_array("SELECT * FROM ?:reward_point_changes WHERE is_spent = 'N' AND amount > 0 AND expiration_date > 0 AND expiration_date <= ?i", array('user_id'), TIME);

    if (!empty($gain_log)) {
	foreach ($gain_log as $u_id => $u_points) {
	    $spends = db_get_hash_multi_array("SELECT timestamp, amount, amount - allocated as points_left, change_id FROM ?:reward_point_changes WHERE amount < 0 AND user_id = ?i AND is_spent = 'N' AND amount - allocated < 0 ORDER BY timestamp asc", array('timestamp'), $u_id);

	    foreach ($u_points as $i => $log) {
		$amount = $log['amount'];
		if (!empty($spends)) {
		    foreach ($spends as $timestamp => $s_points) {
			if ($timestamp >= $log['timestamp'] && $timestamp <= $log['expiration_date']) {
			    foreach($s_points as $i => $s_point) {
				$_tmp = $amount;
				$amount = ($amount + $s_point['points_left'] > 0) ? $amount + $s_point['points_left'] : 0;
				$spends[$timestamp][$i]['points_left'] = ($spends[$timestamp][$i]['points_left'] + $_tmp < 0) ? $spends[$timestamp][$i]['points_left'] + $_tmp : 0;
			    }
			}
		    }
		}
		if ($amount > 0) {
		    $reason = unserialize($log['reason']);
		    if (!empty($reason['order_id'])) {
			$_data = unserialize(db_get_field("SELECT data FROM ?:order_data WHERE order_id = ?i AND type = ?s", $reason['order_id'], POINTS));
			$row = array();
			$row['reward'] = -$amount;
			$row['expired'] = true;
			$_data[] = $row;
			db_query("UPDATE ?:order_data SET data = ?s WHERE order_id = ?i AND type = ?s", serialize($_data), $reason['order_id'], POINTS);
		    }
		    fn_change_user_points( - $amount, $u_id, __('expired'), CHANGE_DUE_EXPIRATION);
		}
		db_query("UPDATE ?:reward_point_changes SET is_spent = 'Y' WHERE change_id = ?i", $log['change_id']);
	    }
	    if (!empty($spends)) {
		foreach ($spends as $timestamp => $s_points) {
		    foreach($s_points as $i => $s_point) {
			db_query("UPDATE ?:reward_point_changes SET allocated = ?i WHERE change_id = ?i", $s_point['amount'] - $s_point['points_left'], $s_point['change_id']);
		    }
		}
	    }	    
	}
    }
    exit;
}
