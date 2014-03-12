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

$l = fn_get_session_data('location');
if (empty($l) && (Registry::get('runtime.controller') != 'spec_dev' || (Registry::get('runtime.mode') != 'choose_location' && Registry::get('runtime.mode') != 'set_location'))) {
    return array(CONTROLLER_STATUS_REDIRECT, "spec_dev.choose_location");
}