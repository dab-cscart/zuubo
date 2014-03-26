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

if ($mode == 'view' || $mode == 'quick_view') {

    $product = Registry::get('view')->getTemplateVars('product');
    $product['discussion'] = fn_get_discussion($product['product_id'], "P", true, $_REQUEST);
    Registry::get('view')->assign('product', $product);
    
    if (!empty($product['company_id'])) {
        $discussion = fn_get_discussion($product['company_id'], 'M', true, $_REQUEST);

        if (empty($discussion) || $discussion['type'] != 'D') {

            if (!empty($discussion['thread_id'])) {
                $thread_condition = fn_generate_thread_condition($discussion);
                $discussion['total_posts'] = db_get_field("SELECT COUNT(*) FROM ?:discussion_posts WHERE $thread_condition AND ?:discussion_posts.status = 'A'");
            }
            Registry::get('view')->assign('discussion', $discussion);
        }
    }

}
