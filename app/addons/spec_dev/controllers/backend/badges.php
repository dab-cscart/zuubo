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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //
    // Create/update badge
    //
    //
    if ($mode == 'update') {
        fn_update_badge($_REQUEST['badge_data'], $_REQUEST['badge_id'], DESCR_SL);
    }

    // Updating existing badges
    //
    if ($mode == 'm_update') {
        foreach ($_REQUEST['badges'] as $key => $_data) {
            if (!empty($_data)) {
                fn_update_badge($_data, $key, DESCR_SL);
            }
        }
    }

    //
    // Delete selected badges
    //
    if ($mode == 'm_delete') {

        if (!empty($_REQUEST['badge_ids'])) {
            foreach ($_REQUEST['badge_ids'] as $v) {
                fn_delete_badge($v);
            }
        }
    }

    return array(CONTROLLER_STATUS_OK, "badges.manage");
}

if ($mode == 'manage') {

    $params = $_REQUEST;

    list($badges, $search) = fn_get_badges($params, Registry::get('settings.Appearance.admin_elements_per_page'));

    Registry::get('view')->assign('badges', $badges);
    Registry::get('view')->assign('search', $search);

} elseif ($mode == 'update') {

    $badge = fn_get_badge_data($_REQUEST['badge_id']);

    Registry::get('view')->assign('badge', $badge);

} elseif ($mode == 'delete') {

    if (!empty($_REQUEST['badge_id'])) {
        fn_delete_badge($_REQUEST['badge_id']);
    }

    return array(CONTROLLER_STATUS_REDIRECT, "badges.manage");
}

/** /Body **/
