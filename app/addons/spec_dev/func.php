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

function fn_get_category_metro_cities($category_id)
{
	return db_get_fields("SELECT metro_city_id FROM ?:category_metro_cities WHERE category_id = ?i", $category_id);
}

function fn_get_all_category_metro_cities($category_id, $skip_current = true)
{
	$ids = explode('/', db_get_field("SELECT id_path FROM ?:categories WHERE category_id = ?i", $category_id));
	if ($skip_current) {
		array_pop($ids);
	}
	list($result, ) = fn_get_metro_cities();
	if (!empty($ids)) {
		foreach (array_reverse($ids) as $c_id) {
			$mc_ids = fn_get_category_metro_cities($c_id);
			if (!empty($mc_ids)) {
				$result = $mc_ids;
				break;
			}
		}
	}

	return $result;
}

function fn_spec_dev_get_category_data_post($category_id, $field_list, $get_main_pair, $skip_company_condition, $lang_code, &$category_data)
{
	$category_data['all_metro_cities'] = fn_get_all_category_metro_cities($category_id);
	$category_data['metro_city_ids'] = fn_get_category_metro_cities($category_id);
}

function fn_spec_dev_update_company($company_data, $company_id, $lang_code, $action)
{
	$badge_ids = fn_get_vendor_badges($company_id);
	$to_delete = array_diff($badge_ids, $company_data['badge_ids']);
	if (!empty($to_delete)) {
		db_query("DELETE FROM ?:vendor_badges WHERE badge_id IN (?n)", $to_delete);
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
}

function fn_get_vendor_badges($company_id)
{
	return db_get_fields("SELECT badge_id FROM ?:vendor_badges WHERE vendor_id = ?i", $company_id);
}

function fn_spec_dev_get_company_data_post($company_id, $lang_code, $extra, &$company_data)
{
	list($company_data['all_badges'],) = fn_get_badges();
	$company_data['badge_ids'] = fn_get_vendor_badges($company_id);
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
    if (!empty($params['only_avail'])) {
        $condition .= db_quote(" AND a.status = ?s", 'A');
    }

    if (!empty($params['q'])) {
        $condition .= db_quote(" AND a.badge LIKE ?l", '%' . $params['q'] . '%');
    }

    $join = '';
    $limit = '';
    if (!empty($params['items_per_page'])) {
        $params['total_items'] = db_get_field("SELECT count(*) FROM ?:badges as a $join WHERE ?p", $condition);
        $limit = db_paginate($params['page'], $params['items_per_page']);
    }

    $badges = db_get_array("SELECT " . implode(', ', $fields) . " FROM ?:badges as a $join WHERE ?p ORDER BY a.badge $limit", $condition);

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

    $join = db_quote(" LEFT JOIN ?:states as b ON b.state_id = a.state_id ");
    $limit = '';
    if (!empty($params['items_per_page'])) {
        $params['total_items'] = db_get_field("SELECT count(*) FROM ?:metro_cities as a $join WHERE ?p", $condition);
        $limit = db_paginate($params['page'], $params['items_per_page']);
    }

    $metro_cities = db_get_array("SELECT " . implode(', ', $fields) . " FROM ?:metro_cities as a $join WHERE ?p ORDER BY a.metro_city $limit", $condition);

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
	db_query("DELETE FROM ?:cities WHERE metro_city_id = ?i", $metro_city_id);
}
