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

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if ($mode == 'update' || $mode == 'add') {

		$tabs = Registry::get('navigation.tabs');
		$badges = array('metro_cities' => array (
			'title' => __('metro_cities'),
			'js' => true
		));

		$tabs = array_merge(array_slice($tabs, 0, 1), $badges, array_slice($tabs, 1));

		Registry::set('navigation.tabs', $tabs);
	}
}