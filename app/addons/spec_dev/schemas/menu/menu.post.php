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

use \Tygh\Registry;

$schema['top']['administration']['items']['shippings_taxes']['subitems']['metro_cities'] = array(
    'href' => 'metro_cities.manage',
    'alt' => 'metro_cities.add,metro_cities.update',
    'position' => 220,
);
$schema['top']['administration']['items']['shippings_taxes']['subitems']['cities'] = array(
    'href' => 'cities.manage',
    'alt' => 'cities.add,cities.update',
    'position' => 210,
);
$schema['central']['vendors']['items']['badges'] = array(
    'href' => 'badges.manage',
    'alt' => 'badges.add,badges.update',
    'position' => 500,
);

return $schema;
