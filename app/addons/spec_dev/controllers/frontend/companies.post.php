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

if ($mode == 'storefront') {

    $company_data = !empty($_REQUEST['company_id']) ? fn_get_company_data($_REQUEST['company_id']) : array();

    if (empty($company_data) || empty($company_data['status']) || !empty($company_data['status']) && $company_data['status'] != 'A') {
        return array(CONTROLLER_STATUS_NO_PAGE);
    }

    fn_add_breadcrumb(__('all_vendors'), 'companies.catalog');
    fn_add_breadcrumb(__('microsite'), 'companies.view?company_id=' . $_REQUEST['company_id']);
    fn_add_breadcrumb($company_data['company']);

    $company_data['total_products'] = count(db_get_fields(fn_get_products(array(
        'get_query' => true,
        'company_id' => $_REQUEST['company_id']
    ))));

    $company_data['logos'] = fn_get_logos($company_data['company_id']);

    Registry::set('navigation.tabs', array(
        'description' => array(
            'title' => __('description'),
            'js' => true
        )
    ));

    $params = array(
        'company_id' => $_REQUEST['company_id'],
    );

    $categories = fn_get_product_counts_by_category($params);

    Registry::get('view')->assign('company_categories', $categories);
    Registry::get('view')->assign('company_data', $company_data);
    
    
    $params = $_REQUEST;

    if (!empty($_REQUEST['items_per_page'])) {
	$_SESSION['items_per_page'] = $_REQUEST['items_per_page'];
    } elseif (!empty($_SESSION['items_per_page'])) {
	$params['items_per_page'] = $_SESSION['items_per_page'];
    }

    $params['company_id'] = $_REQUEST['company_id'];
    $params['extend'] = array('categories', 'description');
//     $params['subcats'] = '';
//     if (Registry::get('settings.General.show_products_from_subcategories') == 'Y') {
// 	$params['subcats'] = 'Y';
//     }

    list($products, $search) = fn_get_products($params, Registry::get('settings.Appearance.products_per_page'));

    if (isset($search['page']) && ($search['page'] > 1) && empty($products)) {
	return array(CONTROLLER_STATUS_NO_PAGE);
    }

    fn_gather_additional_products_data($products, array(
	'get_icon' => true,
	'get_detailed' => true,
	'get_additional' => true,
	'get_options' => true,
	'get_discounts' => true,
	'get_features' => false
    ));

    $show_no_products_block = (!empty($params['features_hash']) && !$products);
    Registry::get('view')->assign('show_no_products_block', $show_no_products_block);

    $selected_layout = fn_get_products_layout($_REQUEST);
    Registry::get('view')->assign('show_qty', true);
    Registry::get('view')->assign('products', $products);
    Registry::get('view')->assign('search', $search);
    Registry::get('view')->assign('selected_layout', $selected_layout);

}