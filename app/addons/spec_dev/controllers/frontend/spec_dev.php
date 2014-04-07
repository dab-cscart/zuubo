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
use Tygh\Navigation\LastView;

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
} elseif ($mode == 'rate_post') {
    $_ip = fn_get_ip(true);
    $exists = db_get_field("SELECT value FROM ?:discussion_post_votes WHERE post_id = ?i AND ip = ?s", $_REQUEST['post_id'], $_ip['host']);
    if (empty($exists)) {
	$_data = array(
	    'post_id' => $_REQUEST['post_id'],
	    'ip' => $_ip['host'],
	    'value' => $_REQUEST['v']
	);
	db_query("REPLACE INTO ?:discussion_post_votes ?e", $_data);
    } elseif ($exists != $_REQUEST['v']) {
	db_query("UPDATE ?:discussion_post_votes SET value = ?s WHERE post_id = ?i AND ip = ?s", $_REQUEST['v'], $_REQUEST['post_id'], $_ip['host']);
    }
    Registry::get('view')->assign('value', $_REQUEST['v']);
    Registry::get('view')->assign('post_id', $_REQUEST['post_id']);
    Registry::get('view')->display('addons/spec_dev/components/post_vote.tpl');
    exit;
} elseif ($mode == 'savings') {

    fn_add_breadcrumb(__('savings'));
    $params = $_REQUEST;
    if (!empty($auth['user_id'])) {
        $params['user_id'] = $auth['user_id'];

    } elseif (!empty($auth['order_ids'])) {
        if (empty($params['order_id'])) {
            $params['order_id'] = $auth['order_ids'];
        } else {
            $ord_ids = is_array($params['order_id']) ? $params['order_id'] : explode(',', $params['order_id']);
            $params['order_id'] = array_intersect($ord_ids, $auth['order_ids']);
        }

    } else {
        return array(CONTROLLER_STATUS_REDIRECT, "auth.login_form?return_url=" . urlencode(Registry::get('config.current_url')));
    }

    list($orders, $search, $totals) = fn_get_orders($params, Registry::get('settings.Appearance.orders_per_page'), true);

    Registry::get('view')->assign('orders', $orders);
    Registry::get('view')->assign('search', $search);
    Registry::get('view')->assign('totals', $totals);
} elseif ($mode == 'feedbacks') {

    fn_add_breadcrumb(__('feedbacks_and_ratings'));

//    $discussion_object_types = fn_get_discussion_objects();
    $discussion_object_types = array(
	'M' => 'company'
    );
    
    if (empty($_REQUEST['object_type'])) {
        reset($discussion_object_types);
        $_REQUEST['object_type'] = key($discussion_object_types); // FIXME: bad style
    }

    $_url = fn_query_remove(Registry::get('config.current_url'), 'object_type', 'page');
    foreach ($discussion_object_types as $obj_type => $obj) {
        if ($obj_type == 'E' && Registry::ifGet('addons.discussion.home_page_testimonials', 'D') == 'D') {
            continue;
        }

        $_name = ($obj_type != 'E') ? __($obj) . ' ' . __('discussion_title_' . $obj) : __('discussion_title_' . $obj); // FIXME!!! Bad style

        Registry::set('navigation.tabs.' . $obj, array (
            'title' => $_name,
            'href' => $_url . '&object_type=' . $obj_type,
        ));

    }

    list($posts, $search) = fn_get_discussions($_REQUEST, Registry::get('settings.Appearance.admin_elements_per_page'));

    if (!empty($posts)) {
        foreach ($posts as $k => $v) {
            $posts[$k]['object_data'] = fn_get_discussion_object_data($v['object_id'], $v['object_type'], DESCR_SL);
        }
    }

    Registry::get('view')->assign('posts', $posts);
    Registry::get('view')->assign('search', $search);
    Registry::get('view')->assign('discussion_object_type', $_REQUEST['object_type']);
    Registry::get('view')->assign('discussion_object_types', $discussion_object_types);
}

function fn_get_discussions($params, $items_per_page)
{
    // Init filter
    $params = LastView::instance()->update('discussion', $params);

    // Set default values to input params
    $default_params = array (
        'page' => 1,
        'items_per_page' => $items_per_page
    );

    $params = array_merge($default_params, $params);

    // Define fields that should be retrieved
    $fields = array (
        '?:discussion_posts.*',
        '?:discussion_messages.message',
        '(?:discussion_rating.rating_value + ?:discussion_rating.time + ?:discussion_rating.accuracy + ?:discussion_rating.quality + ?:discussion_rating.communication + ?:discussion_rating.professionalism)/6 AS rating_value',
        '?:discussion.*'
    );

    // Define sort fields
    $sortings = array (
        'object' => "?:discussion.object_type",
        'name' => "?:discussion_posts.name",
        'ip_address' => "?:discussion_posts.ip_address",
        'timestamp' => "?:discussion_posts.timestamp",
        'status' => "?:discussion_posts.status",
        'date' => "?:orders.timestamp",
        'total' => "?:orders.total",
    );

    $sorting = db_sort($params, $sortings, 'timestamp', 'desc');

    $condition = $join = '';

    if (isset($params['name']) && fn_string_not_empty($params['name'])) {
        $condition .= db_quote(" AND ?:discussion_posts.name LIKE ?l", "%".trim($params['name'])."%");
    }

    if (isset($params['message']) && fn_string_not_empty($params['message'])) {
        $condition .= db_quote(" AND ?:discussion_messages.message LIKE ?l", "%".trim($params['message'])."%");
    }

    if (!empty($params['type'])) {
        $condition .= db_quote(" AND ?:discussion.type = ?s", $params['type']);
    }

    if (!empty($params['status'])) {
        $condition .= db_quote(" AND ?:discussion_posts.status = ?s", $params['status']);
    }

    if (!empty($params['post_id'])) {
        $condition .= db_quote(" AND ?:discussion_posts.post_id = ?i", $params['post_id']);
    }

    if (isset($params['ip_address']) && fn_string_not_empty($params['ip_address'])) {
        $condition .= db_quote(" AND ?:discussion_posts.ip_address = ?s", trim($params['ip_address']));
    }

    if (!empty($params['rating_value'])) {
        $condition .= db_quote(" AND (?:discussion_rating.rating_value + ?:discussion_rating.time + ?:discussion_rating.accuracy + ?:discussion_rating.quality + ?:discussion_rating.communication + ?:discussion_rating.professionalism)/6 = ?i", $params['rating_value']);
    }

    if (!empty($params['object_type'])) {
        $condition .= db_quote(" AND ?:discussion.object_type = ?s", $params['object_type']);
    }

    $condition .= fn_get_discussion_company_condition('?:discussion.company_id');

    if (!empty($params['period']) && $params['period'] != 'A') {
        list($params['time_from'], $params['time_to']) = fn_create_periods($params);
        $condition .= db_quote(" AND (?:discussion_posts.timestamp >= ?i AND ?:discussion_posts.timestamp <= ?i)", $params['time_from'], $params['time_to']);
    }

    $join .= " INNER JOIN ?:discussion ON ?:discussion.thread_id = ?:discussion_posts.thread_id";
    $join .= " INNER JOIN ?:discussion_messages ON ?:discussion_messages.post_id = ?:discussion_posts.post_id";
    $join .= " INNER JOIN ?:discussion_rating ON ?:discussion_rating.post_id = ?:discussion_posts.post_id";

    $limit = '';
    if (!empty($params['items_per_page'])) {
        $params['total_items'] = db_get_field("SELECT COUNT(*) FROM ?:discussion_posts $join WHERE 1 $condition");
        $limit = db_paginate($params['page'], $params['items_per_page']);
    }

    $posts = db_get_array("SELECT " . implode(',', $fields) . " FROM ?:discussion_posts $join WHERE 1 $condition $sorting $limit");

    return array($posts, $params);
}
