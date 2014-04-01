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

$schema['vendor_categories'] = array (
    'templates' => array(
	'addons/spec_dev/blocks/vendor_categories.tpl' => array(),
    ),
    'wrappers' => 'blocks/wrappers',
);
$schema['vendor_contact'] = array (
    'templates' => array(
	'addons/spec_dev/blocks/vendor_contact.tpl' => array(),
    ),
    'wrappers' => 'blocks/wrappers',
);
$schema['categories']['cache']['cookie_handlers'] = array('%LOCATION%');
return $schema;
