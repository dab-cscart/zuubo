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
use Tygh\Mailer;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_get_most_recent_posts($object_id, $object_type)
{
    static $cache = array();
    
    $_cache_key = $object_id . '_' . $object_type;

    $params = array();
    $params['limit'] = 3;
    $params['thread_id'] = db_get_field("SELECT thread_id FROM ?:discussion WHERE object_id = ?i AND object_type = ?s ?p", $object_id, $object_type);
    $params['avail_only'] = (AREA == 'C');
    
    list($cache[$_cache_key], ) = fn_get_discussion_posts($params);

    return !empty($cache[$_cache_key]) ? $cache[$_cache_key] : false;
}

function fn_spec_dev_change_order_status($status_to, $status_from, $order_info, $force_notification, $order_statuses, $place_order)
{
    if ($status_to == 'C') {
	$product_ids = array();
	foreach ($order_info['products'] as $i => $product) {
	    $product_ids[] = $product['product_id'];
	}
	$product_ids = array_unique($product_ids);
	Mailer::sendMail(array(
	    'to' => $order_info['email'],
	    'from' => 'company_orders_department',
	    'data' => array(
		'order_products' => $product_ids,
		'order_info' => $order_info,
	    ),
	    'tpl' => 'addons/spec_dev/rate_vendor.tpl',
	    'company_id' => $order_info['company_id'],
	), 'C', $order_info['lang_code']);
    }
}

function fn_spec_dev_get_orders($params, &$fields, $sortings, $condition, $join, $group)
{
    $fields[] = '?:orders.discount + ?:orders.subtotal_discount AS savings';
}

function fn_spec_dev_get_discussion($object_id, $object_type, &$cache)
{
    if (!empty($cache) && AREA == 'C' && $object_type == 'M' && Registry::ifGet('addons.discussion.company_only_buyers', 'Y') == 'Y') {
	if (empty($_SESSION['auth']['user_id'])) {
	    $cache['disable_adding'] = true;
	} else {
	    $customer_companies = db_get_hash_single_array(
		"SELECT company_id FROM ?:orders WHERE user_id = ?i AND status = 'C'",
		array('company_id', 'company_id'), $_SESSION['auth']['user_id']
	    );
	    if (empty($customer_companies[$object_id])) {
		$cache['disable_adding'] = true;
	    }
	}
	$cache['customer_products'] = db_get_fields("SELECT ?:order_details.product_id FROM ?:order_details LEFT JOIN ?:orders ON ?:orders.order_id = ?:order_details.order_id WHERE ?:orders.user_id = ?i AND ?:orders.status = 'C' AND ?:orders.company_id = ?i", $_SESSION['auth']['user_id'], $object_id);
    }
}

function fn_get_post_votes_stat($post_id)
{
    $result = array();
    $result['positive'] = db_get_field("SELECT COUNT(vote_id) FROM ?:discussion_post_votes WHERE post_id = ?i AND value = 'Y'", $post_id);
    $result['all'] = db_get_field("SELECT COUNT(vote_id) FROM ?:discussion_post_votes WHERE post_id = ?i", $post_id);
    $result['negative'] = $result['all'] - $result['positive'];
    if (!empty($result['all'])) {
	$result['prc'] = round($result['positive'] / $result['all'] * 100, 1);
    }
    return $result;
}

function fn_get_product_reward_expiration_date($product_id)
{
    $expiration_period = db_get_field("SELECT points_expiration_period FROM ?:products WHERE product_id = ?i", $product_id);
    if (empty($expiration_period)) {
	$ids = explode('/', db_get_field("SELECT id_path FROM ?:categories LEFT JOIN ?:products_categories ON ?:products_categories.category_id = ?:categories.category_id WHERE ?:products_categories.product_id = ?i AND ?:products_categories.link_type = 'M'", $product_id));
	$obj_ids = array();
	if (!empty($ids)) {
	    $exp_periods = db_get_hash_single_array("SELECT category_id, points_expiration_period FROM ?:categories WHERE category_id IN (?n)", array('category_id', 'points_expiration_period'), $ids);
	    foreach (array_reverse($exp_periods) as $period) {
		if ($period > 0) {
		    $expiration_period = $period;
		    break;
		}
	    }
	}
    }
    if (empty($expiration_period)) {
	$expiration_period = Registry::get('addons.reward_points.expiration_period');
    }
    $today = getdate(TIME);
    $result = gmmktime(0, 0, 0, $today['mon'], $today['mday'] + $expiration_period, $today['year']);
    
    return $result;
}

function fn_spec_dev_get_filters_products_count_query_params($values_fields, &$join, $sliders_join, $feature_ids, &$where, $sliders_where, $filter_vq, $filter_rq)
{
    if (AREA == 'C' && defined('METRO_CITY_ID')) {
	$join .= db_quote(" LEFT JOIN ?:product_metro_cities ON ?:product_metro_cities.product_id = ?:products.product_id ");
	$where .= db_quote(" AND ?:product_metro_cities.metro_city_id = ?i", METRO_CITY_ID);
    }
}

function fn_spec_dev_get_products_before_select(&$params, $join, $condition, $u_condition, $inventory_condition, $sortings, $total, $items_per_page, $lang_code, $having)
{
    if (!empty($params['filter_params']['city_id'])) {
	$params['city_ids'] = array_fill_keys($params['filter_params']['city_id'], 'Y');
	unset($params['filter_params']['city_id']);
    }
}

function fn_spec_dev_get_product_filter_fields(&$filters)
{
    $filters['C'] = array (
	'db_field' => 'city_id',
	'table' => 'product_cities',
	'description' => 'city',
	'condition_type' => 'F',
	'range_name' => 'city',
	'foreign_table' => 'cities',
	'foreign_index' => 'city_id',
    );
}

function fn_spec_dev_get_category_data($category_id, $field_list, &$join, $lang_code, &$conditions)
{
    if (AREA == 'C' && defined('METRO_CITY_ID')) {
	$join .= db_quote(" LEFT JOIN ?:category_metro_cities ON ?:category_metro_cities.category_id = ?:categories.category_id ");
	$conditions .= db_quote(" AND ?:category_metro_cities.metro_city_id = ?i", METRO_CITY_ID);
    }
}

function fn_spec_dev_get_product_data($product_id, $field_list, &$join, $auth, $lang_code, &$condition)
{
    if (AREA == 'C' && defined('METRO_CITY_ID')) {
	$join .= db_quote(" LEFT JOIN ?:product_metro_cities ON ?:product_metro_cities.product_id = ?:products.product_id ");
	$condition .= db_quote(" AND ?:product_metro_cities.metro_city_id = ?i", METRO_CITY_ID);
    }
}

function fn_spec_dev_get_products($params, $fields, $sortings, $condition, $join, $sorting, $group_by, $lang_code, $having)
{
    if (AREA == 'C' && defined('METRO_CITY_ID')) {
	$join .= db_quote(" LEFT JOIN ?:product_metro_cities ON ?:product_metro_cities.product_id = products.product_id ");
	$condition .= db_quote(" AND ?:product_metro_cities.metro_city_id = ?i", METRO_CITY_ID);
	
	$city_ids = array();
	if (!empty($params['cities'])) {
	    $city_ids += $params['cities'];
	}
	if (!empty($params['city_ids'])) {
	    $city_ids += $params['city_ids'];
	}
	if (!empty($city_ids)) {
	    $join .= db_quote(" LEFT JOIN ?:product_cities ON ?:product_cities.product_id = products.product_id ");
	    $condition .= db_quote(" AND ?:product_cities.city_id IN (?n)", array_keys($city_ids));
	}
    }
}

function fn_spec_dev_get_categories($params, &$join, &$condition, $fields, $group_by, $sortings, $lang_code)
{
    $categories = Registry::get('view')->gettemplatevars('company_categories');
    if (!empty($categories)) {
	$c_ids = array();
	foreach ($categories as $i => $c_data) {
	    $c_ids[] = $c_data['category_id'];
	}
	$condition .= db_quote(" AND ?:categories.category_id IN (?n)", $c_ids);
    }
    if (AREA == 'C' && defined('METRO_CITY_ID')) {
	$join .= db_quote(" LEFT JOIN ?:category_metro_cities ON ?:category_metro_cities.category_id = ?:categories.category_id ");
	$condition .= db_quote(" AND ?:category_metro_cities.metro_city_id = ?i", METRO_CITY_ID);
    }
}

function fn_set_location($location)
{
    $_ip = fn_get_ip(true);
    $ln = array(
	'metro_city_id' => $location['mc_id'],
	'city_id' => !empty($location['c_id']) ? $location['c_id'] : 0
    );
    $ln['ip_address'] = $_ip['host'];
    db_query("REPLACE INTO ?:ip_locations ?e", $ln);
}

function fn_spec_dev_get_rewrite_rules(&$rewrite_rules, &$prefix, $extension, $current_path)
{
    $mc = fn_get_session_data('location');
//    $prefix .= (!empty($mc)) ? '\/([^\/]+)' : '()';
    $prefix .= '\/([^\/]+)';
}

function fn_spec_dev_seo_empty_object_name($object_id, $object_type, $lang_code, &$object_name)
{
    switch ($object_type) {
	case 't':
	    $object_name = db_get_field('SELECT metro_city FROM ?:metro_cities WHERE metro_city_id = ?i', $object_id);
	    break;
    }
  
}

function fn_spec_dev_get_seo_vars(&$seo)
{
    $seo['t'] = array(
	'table' => '?:metro_cities',
	'description' => 'metro_city',
	'dispatch' => '',
	'item' => 'metro_city_id',
	'condition' => '',
	'not_shared' => '',
	'skip_lang_condition' => true
    );
}

function fn_get_metro_city_data($metro_city_id)
{
    $metro_city = db_get_row("SELECT a.*, b.country_code, b.code FROM ?:metro_cities AS a LEFT JOIN ?:states AS b ON b.state_id = a.state_id WHERE metro_city_id = ?i", $metro_city_id);
    
    if (empty($metro_city['seo_name']) && !empty($metro_city['metro_city_id'])) {
        $metro_city['seo_name'] = fn_seo_get_name('t', $metro_city['metro_city_id'], '', null, CART_LANGUAGE);
    }
    
    return $metro_city;
}

function fn_init_ip_location(&$params)
{
    list($avail_mc, ) = fn_get_metro_cities();
    if (!empty($params['mc']) && !empty($avail_mc[$params['mc']])) {
        fn_define('METRO_CITY_ID', $params['mc']);
        fn_set_location(array('mc_id' => $params['mc']));
    } elseif (($_mc = fn_get_session_data('location')) && !empty($avail_mc[$_mc])) {
        fn_define('METRO_CITY_ID', $_mc);
        fn_set_location(array('mc_id' => $_mc));
    } else {
	$_ip = fn_get_ip(true);
	$location = db_get_row("SELECT metro_city_id, city_id FROM ?:ip_locations WHERE ip_address = ?s", $_ip['host']);
	if (!empty($avail_mc[$location['metro_city_id']])) {
	    fn_define('METRO_CITY_ID', $location['metro_city_id']);
	}
    }

    if (defined('METRO_CITY_ID')) {
    	fn_set_session_data('location', METRO_CITY_ID, COOKIE_ALIVE_TIME);
    } else {
    	fn_set_session_data('location', null, COOKIE_ALIVE_TIME);
    }
}

function fn_spec_dev_get_product_data_post($product_data, $auth, $preview, $lang_code)
{
    if (!empty($product_data)) {
	$product_data['all_metro_cities'] = fn_get_all_category_metro_cities($product_data['main_category'], false);
	$product_data['metro_city_ids'] = fn_get_product_metro_cities($product_data['product_id']);
	if (!empty($product_data['metro_city_ids'])) {
	    list($product_data['all_cities'],) = fn_get_cities(array('metro_city_ids' => implode(',', $product_data['metro_city_ids'])));
	}
	$product_data['city_ids'] = fn_get_product_cities($product_data['product_id']);
    }
}

function fn_get_product_cities($product_id)
{
    $ids = db_get_fields("SELECT city_id FROM ?:product_cities WHERE product_id = ?i", $product_id);
    return (!empty($ids)) ? $ids : array();
}

function fn_spec_dev_update_product_post($product_data, $product_id, $lang_code, $create)
{
	$m_city_ids = fn_get_product_metro_cities($product_id);
	$product_data['metro_city_ids'] = (!empty($product_data['metro_city_ids'])) ? $product_data['metro_city_ids'] : array();
	$to_delete = array_diff($m_city_ids, $product_data['metro_city_ids']);
	if (!empty($to_delete)) {
		db_query("DELETE FROM ?:product_metro_cities WHERE metro_city_id IN (?n) AND product_id = ?i", $to_delete, $product_id);
		$city_ids = db_get_fields("SELECT city_id FROM ?:cities WHERE metro_city_id IN (?n)", $to_delete);
		db_query("DELETE FROM ?:product_cities WHERE city_id IN (?n) AND product_id = ?i", $city_ids, $product_id);
	}
	$to_add = array_diff($product_data['metro_city_ids'], $m_city_ids);
	if (!empty($to_add)) {
		foreach ($to_add as $b_id) {
			$_data = array(
				'product_id' => $product_id,
				'metro_city_id' => $b_id
			);
			db_query("REPLACE INTO ?:product_metro_cities ?e", $_data);
		}
	}
	
	$city_ids = fn_get_product_cities($product_id);
	$product_data['city_ids'] = (!empty($product_data['city_ids'])) ? $product_data['city_ids'] : array();
	$to_delete = array_diff($city_ids, $product_data['city_ids']);
	if (!empty($to_delete)) {
		db_query("DELETE FROM ?:product_cities WHERE city_id IN (?n) AND product_id = ?i", $to_delete, $product_id);
	}
	$to_add = array_diff($product_data['city_ids'], $city_ids);
	if (!empty($to_add)) {
		foreach ($to_add as $b_id) {
			$_data = array(
				'product_id' => $product_id,
				'city_id' => $b_id
			);
			db_query("REPLACE INTO ?:product_cities ?e", $_data);
		}
	}
}

function fn_format_categories_tree_metro_cities($subcategories, $parent_metro_cities = array())
{
    if (!empty($subcategories)) {
	foreach ($subcategories as $i => $subcat) {
	    $m_city_ids = fn_get_category_metro_cities($subcat['category_id']);
	    if (empty($m_city_ids)) {
		$m_city_ids = $parent_metro_cities;
		foreach ($m_city_ids as $b_id) {
			$_data = array(
				'category_id' => $subcat['category_id'],
				'metro_city_id' => $b_id
			);
			db_query("REPLACE INTO ?:category_metro_cities ?e", $_data);
		}
	    }
	    if (!empty($subcat['subcategories'])) {
		fn_format_categories_tree_metro_cities($subcat['subcategories'], $m_city_ids);
	    }
	}
    }
}

function fn_spec_dev_update_category_post($category_data, $category_id, $lang_code)
{
	$m_city_ids = fn_get_category_metro_cities($category_id);
	$category_data['metro_city_ids'] = (!empty($category_data['metro_city_ids'])) ? $category_data['metro_city_ids'] : array();
	$to_delete = array_diff($m_city_ids, $category_data['metro_city_ids']);
	$to_add = array_diff($category_data['metro_city_ids'], $m_city_ids);
	if (!empty($to_delete)) {
		db_query("DELETE FROM ?:category_metro_cities WHERE metro_city_id IN (?n) AND category_id = ?i", $to_delete, $category_id);
	}
	if (!empty($to_add)) {
		foreach ($to_add as $b_id) {
			$_data = array(
				'category_id' => $category_id,
				'metro_city_id' => $b_id
			);
			db_query("REPLACE INTO ?:category_metro_cities ?e", $_data);
		}
	}
	$subcategories = fn_get_categories_tree($category_id);
	fn_format_categories_tree_metro_cities($subcategories, $category_data['metro_city_ids']);
}

function fn_get_category_metro_cities($category_id)
{
    $ids = db_get_fields("SELECT metro_city_id FROM ?:category_metro_cities WHERE category_id = ?i", $category_id);
    return (!empty($ids)) ? $ids : array();
}

function fn_get_product_metro_cities($product_id)
{
	return db_get_fields("SELECT metro_city_id FROM ?:product_metro_cities WHERE product_id = ?i", $product_id);
}

function fn_get_all_category_metro_cities($category_id, $skip_current = true)
{
	$ids = explode('/', db_get_field("SELECT id_path FROM ?:categories WHERE category_id = ?i", $category_id));
	if ($skip_current) {
		array_pop($ids);
	}
	$obj_ids = array();
	if (!empty($ids)) {
		foreach (array_reverse($ids) as $c_id) {
			$mc_ids = fn_get_category_metro_cities($c_id);
			if (!empty($mc_ids)) {
				$obj_ids = $mc_ids;
				break;
			}
		}
	}
	
	list($result, ) = fn_get_metro_cities(array('item_ids' => implode(',', $obj_ids)));

	return $result;
}

function fn_spec_dev_get_category_data_post($category_id, $field_list, $get_main_pair, $skip_company_condition, $lang_code, &$category_data)
{
    if (!empty($category_data)) {
	$category_data['all_metro_cities'] = fn_get_all_category_metro_cities($category_id);
	$category_data['metro_city_ids'] = fn_get_category_metro_cities($category_id);
    }
}

function fn_spec_dev_update_company($company_data, $company_id, $lang_code, $action)
{
    if (AREA == 'A') {
	$badge_ids = fn_get_vendor_badges($company_id);
	$to_delete = array_diff($badge_ids, $company_data['badge_ids']);
	if (!empty($to_delete)) {
		db_query("DELETE FROM ?:vendor_badges WHERE badge_id IN (?n) AND vendor_id = ?i", $to_delete, $company_id);
	}
	$to_add = array_diff($company_data['badge_ids'], $badge_ids);
	if (!empty($to_add)) {
		foreach ($to_add as $b_id) {
			$_data = array(
				'vendor_id' => $company_id,
				'badge_id' => $b_id
			);
			db_query("REPLACE INTO ?:vendor_badges ?e", $_data);
		}
	}
	
	// Update additional images
	fn_attach_image_pairs('company_additional', 'company', $company_id, $lang_code);
	// Adding new additional images
	fn_attach_image_pairs('company_add_additional', 'company', $company_id, $lang_code);
    }
}

function fn_get_vendor_badges($company_id)
{
	return db_get_fields("SELECT badge_id FROM ?:vendor_badges WHERE vendor_id = ?i", $company_id);
}

function fn_spec_dev_get_company_data_post($company_id, $lang_code, $extra, &$company_data)
{
    if (AREA == 'A') {
	list($company_data['all_badges'],) = fn_get_badges();
	$company_data['badge_ids'] = fn_get_vendor_badges($company_id);
    } else {
	list($company_data['badges'], ) = fn_get_badges(array('vendor_id' => $company_id));
	if (!empty($company_data['badges'])) {
	    foreach ($company_data['badges'] as $i => $badge) {
		$company_data['badges'][$i]['icon'] = fn_get_image_pairs($badge['badge_id'], 'badge', 'M', true, true);
		if ($badge['badge_id'] == TOP_RATED_BADGE_ID) {
		    $company_data['top_rated'] = $company_data['badges'][$i];
		    unset($company_data['badges'][$i]);
		}
	    }
	}
    }
    $company_data['image_pairs'] = fn_get_image_pairs($company_id, 'company', 'A', true, true, $lang_code);
    $company_data['total_services_sold'] = db_get_field("SELECT SUM(a.amount) FROM ?:order_details AS a LEFT JOIN ?:orders AS b ON b.order_id = a.order_id WHERE b.company_id = ?i", $company_id);
}

function fn_get_badge_data($badge_id)
{
	$badge = db_get_row("SELECT * FROM ?:badges WHERE badge_id = ?i", $badge_id);
	$badge['icon'] = fn_get_image_pairs($badge['badge_id'], 'badge', 'M', true, true);

	return $badge;
}

function fn_get_badges($params = array(), $items_per_page = 0)
{
    // Set default values to input params
    $default_params = array (
        'page' => 1,
        'items_per_page' => $items_per_page
    );

    $params = array_merge($default_params, $params);

    $fields = array(
        'a.*'

    );

    $condition = '1';
    $join = '';
    if (!empty($params['vendor_id'])) {
	$join .= db_quote(" LEFT JOIN ?:vendor_badges ON ?:vendor_badges.badge_id = a.badge_id ", $params['vendor_id']);
        $condition .= db_quote(" AND ?:vendor_badges.vendor_id = ?i", $params['vendor_id']);
    }

    if (!empty($params['only_avail'])) {
        $condition .= db_quote(" AND a.status = ?s", 'A');
    }

    if (!empty($params['q'])) {
        $condition .= db_quote(" AND a.badge LIKE ?l", '%' . $params['q'] . '%');
    }

    $limit = '';
    if (!empty($params['items_per_page'])) {
        $params['total_items'] = db_get_field("SELECT count(*) FROM ?:badges as a $join WHERE ?p", $condition);
        $limit = db_paginate($params['page'], $params['items_per_page']);
    }

    $badges = db_get_hash_array("SELECT " . implode(', ', $fields) . " FROM ?:badges as a $join WHERE ?p ORDER BY a.badge $limit", 'badge_id', $condition);

    return array($badges, $params);
}

function fn_update_badge($badge_data, $badge_id = 0)
{
    if (empty($badge_id)) {
        if (!empty($badge_data['badge'])) {
            $badge_data['badge_id'] = $badge_id = db_query("REPLACE INTO ?:badges ?e", $badge_data);
        }
    } else {
        db_query("UPDATE ?:badges SET ?u WHERE badge_id = ?i", $badge_data, $badge_id);
    }
    fn_attach_image_pairs('badge_image', 'badge', $badge_id);

    return $badge_id;

}

function fn_get_metro_city_name($metro_city_id)
{
	return db_get_field("SELECT metro_city FROM ?:metro_cities WHERE metro_city_id = ?i", $metro_city_id);
}

function fn_get_metro_cities($params = array(), $items_per_page = 0)
{
    // Set default values to input params
    $default_params = array (
        'page' => 1,
        'tree' => false,
        'items_per_page' => $items_per_page
    );

    $params = array_merge($default_params, $params);

    $fields = array(
        'a.*',
        'b.country_code',
        'b.code'
    );

    $condition = '1';
    $join = '';
    if (AREA == 'C') {
	$params['only_avail'] = true;
    }
    
    if (!empty($params['only_avail'])) {
        $condition .= db_quote(" AND a.status = ?s", 'A');
    }

    if (!empty($params['q'])) {
        $condition .= db_quote(" AND a.metro_city LIKE ?l", '%' . $params['q'] . '%');
    }

    if (!empty($params['country_code'])) {
        $condition .= db_quote(" AND b.country_code = ?s", $params['country_code']);
    }

    if (!empty($params['state_code'])) {
        $condition .= db_quote(" AND b.code = ?s", $params['state_code']);
    }

    if (!empty($params['item_ids'])) {
        $condition .= db_quote(" AND a.metro_city_id IN (?n)", explode(',', $params['item_ids']));
    }

    $join = db_quote(" LEFT JOIN ?:states as b ON b.state_id = a.state_id ");
    $limit = '';
    if (!empty($params['items_per_page'])) {
        $params['total_items'] = db_get_field("SELECT count(*) FROM ?:metro_cities as a $join WHERE ?p", $condition);
        $limit = db_paginate($params['page'], $params['items_per_page']);
    }

    $metro_cities = db_get_hash_array("SELECT " . implode(', ', $fields) . " FROM ?:metro_cities as a $join WHERE ?p ORDER BY a.metro_city $limit", 'metro_city_id', $condition);

	if ($params['tree']) {
		if (!empty($metro_cities)) {
			foreach ($metro_cities as $i => $m_city) {
				$result[$m_city['country_code']][$m_city['code']][] = $m_city;
			}
		}
	} else {
		$result = $metro_cities;
	}

    return array($result, $params);
}

function fn_update_metro_city($metro_city_data, $metro_city_id = 0)
{
    if (empty($metro_city_id)) {
		$metro_city_data['state_id'] = db_get_field("SELECT state_id FROM ?:states WHERE country_code = ?s AND code = ?s", $metro_city_data['country_code'], $metro_city_data['state_code']);
        if (!empty($metro_city_data['metro_city']) && !empty($metro_city_data['state_id'])) {
            $metro_city_data['metro_city_id'] = $metro_city_id = db_query("REPLACE INTO ?:metro_cities ?e", $metro_city_data);
        }
    } else {
        db_query("UPDATE ?:metro_cities SET ?u WHERE metro_city_id = ?i", $metro_city_data, $metro_city_id);
    }

    if (Registry::get('runtime.company_id')) {
        $metro_city_data['company_id'] = Registry::get('runtime.company_id');
    }

    fn_seo_update_object($metro_city_data, $metro_city_id, 't', CART_LANGUAGE);
    
    return $metro_city_id;
}

function fn_get_cities($params = array(), $items_per_page = 0)
{
    // Set default values to input params
    $default_params = array (
        'page' => 1,
        'items_per_page' => $items_per_page
    );

    $params = array_merge($default_params, $params);

    $fields = array(
        'a.*'
    );

    $condition = '1';
    $join = '';
    if (AREA == 'C') {
	$params['only_avail'] = true;
    }
    
    if (!empty($params['only_avail'])) {
        $condition .= db_quote(" AND a.status = ?s", 'A');
    }

    if (!empty($params['q'])) {
        $condition .= db_quote(" AND a.city LIKE ?l", '%' . $params['q'] . '%');
    }

    if (!empty($params['country_code'])) {
        $condition .= db_quote(" AND c.country_code = ?s", $params['country_code']);
    }

    if (!empty($params['state_code'])) {
        $condition .= db_quote(" AND c.code = ?s", $params['state_code']);
    }

    if (!empty($params['metro_city_id'])) {
        $condition .= db_quote(" AND a.metro_city_id = ?s", $params['metro_city_id']);
    }

    if (!empty($params['metro_city_ids'])) {
        $condition .= db_quote(" AND b.metro_city_id IN (?n)", explode(',', $params['metro_city_ids']));
    }

    if (!empty($params['item_ids'])) {
        $condition .= db_quote(" AND a.metro_city_id IN (?n)", explode(',', $params['item_ids']));
    }

    $join = db_quote(" LEFT JOIN ?:metro_cities as b ON b.metro_city_id = a.metro_city_id LEFT JOIN ?:states as c ON c.state_id = b.state_id ");
    $limit = '';
    if (!empty($params['items_per_page'])) {
        $params['total_items'] = db_get_field("SELECT count(*) FROM ?:cities as a $join WHERE ?p", $condition);
        $limit = db_paginate($params['page'], $params['items_per_page']);
    }

    $cities = db_get_array("SELECT " . implode(', ', $fields) . " FROM ?:cities as a $join WHERE ?p ORDER BY a.city $limit", $condition);

    return array($cities, $params);
}

function fn_update_city($city_data, $city_id = 0)
{
    if (empty($city_id)) {
		$city_data['state_id'] = db_get_field("SELECT state_id FROM ?:states WHERE country_code = ?s AND code = ?s", $city_data['country_code'], $city_data['state_code']);
        if (!empty($city_data['city']) && !empty($city_data['state_id'])) {
            $city_data['city_id'] = $city_id = db_query("REPLACE INTO ?:cities ?e", $city_data);
        }
    } else {
        db_query("UPDATE ?:cities SET ?u WHERE city_id = ?i", $city_data, $city_id);
    }

    return $city_id;

}

function fn_delete_metro_city($metro_city_id)
{
	db_query("DELETE FROM ?:metro_cities WHERE metro_city_id = ?i", $metro_city_id);
	db_query("DELETE FROM ?:product_metro_cities WHERE metro_city_id = ?i", $metro_city_id);
	db_query("DELETE FROM ?:category_metro_cities WHERE metro_city_id = ?i", $metro_city_id);
	$city_ids = db_get_fields("SELECT city_id FROM ?:cities WHERE metro_city_id = ?i", $metro_city_id);
	db_query("DELETE FROM ?:cities WHERE metro_city_id = ?i", $metro_city_id);
	db_query("DELETE FROM ?:product_cities WHERE city_id IN (?n)", $city_ids);
}
