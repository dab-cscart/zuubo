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

function fn_get_metro_cities($params = array(), $items_per_page = 0, $lang_code = CART_LANGUAGE)
{
    // Set default values to input params
    $default_params = array (
        'page' => 1,
        'items_per_page' => $items_per_page
    );

    $params = array_merge($default_params, $params);

    $fields = array(
        'a.metro_city_id',
        'a.country_code',
        'a.code',
        'a.status',
        'b.metro_city',
        'c.country'
    );

    $condition = '1';
    if (!empty($params['only_avail'])) {
        $condition .= db_quote(" AND a.status = ?s", 'A');
    }

    if (!empty($params['q'])) {
        $condition .= db_quote(" AND b.metro_city LIKE ?l", '%' . $params['q'] . '%');
    }

    if (!empty($params['country_code'])) {
        $condition .= db_quote(" AND a.country_code = ?s", $params['country_code']);
    }

    $limit = '';
    if (!empty($params['items_per_page'])) {
        $params['total_items'] = db_get_field("SELECT count(*) FROM ?:metro_cities as a WHERE ?p", $condition);
        $limit = db_paginate($params['page'], $params['items_per_page']);
    }

    $metro_cities = db_get_array(
        "SELECT " . implode(', ', $fields) . " FROM ?:metro_cities as a " .
        "LEFT JOIN ?:metro_city_descriptions as b ON b.metro_city_id = a.metro_city_id AND b.lang_code = ?s " .
        "LEFT JOIN ?:country_descriptions as c ON c.code = a.country_code AND c.lang_code = ?s " .
        "WHERE ?p ORDER BY c.country, b.metro_city $limit",
    $lang_code, $lang_code, $condition);

    return array($metro_cities, $params);
}

function fn_update_metro_city($metro_city_data, $metro_city_id = 0, $lang_code = DESCR_SL)
{
    if (empty($metro_city_id)) {
        if (!empty($metro_city_data['code']) && !empty($metro_city_data['metro_city'])) {
            $metro_city_data['metro_city_id'] = $metro_city_id = db_query("REPLACE INTO ?:metro_cities ?e", $metro_city_data);

            foreach (fn_get_translation_languages() as $metro_city_data['lang_code'] => $_v) {
                db_query('REPLACE INTO ?:metro_city_descriptions ?e', $metro_city_data);
            }
        }
    } else {
        db_query("UPDATE ?:metro_city_descriptions SET ?u WHERE metro_city_id = ?i AND lang_code = ?s", $metro_city_data, $metro_city_id, $lang_code);
    }

    return $metro_city_id;

}

