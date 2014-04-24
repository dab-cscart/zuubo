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

define('DEVELOPMENT', true);
define('TOP_RATED_BADGE_ID', 1);
define('TOP_LINK_ID', 175);

fn_register_hooks(
	'get_company_data_post',
	'update_company',
	'get_category_data_post',
	'update_category_post',
	'get_product_data_post',
	'update_product_post',
	'get_seo_vars',
	'seo_empty_object_name',
	'get_rewrite_rules',
	'get_categories',
	'get_products',
	'get_product_data',
	'get_category_data',
	'get_product_filter_fields',
	'get_products_before_select',
	'get_filters_products_count_query_params',
	'get_discussion',
	'get_orders',
	'change_order_status'
);
