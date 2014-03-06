DROP TABLE IF EXISTS ?:settings_vendor_values_upg;
CREATE TABLE `?:settings_vendor_values_upg` (
  `object_id` mediumint(8) unsigned NOT NULL auto_increment,
  `company_id` int(11) unsigned NOT NULL,
  `name` varchar(128) NOT NULL default '',
  `section_name` varchar(128) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`object_id`, `company_id`)
) Engine=MyISAM DEFAULT CHARSET UTF8;

INSERT INTO ?:settings_vendor_values_upg
    SELECT
        ?:settings_objects.object_id,
        company_id,
        ?:settings_objects.name,
        ?:settings_sections.name as section_name,
        ?:settings_vendor_values.value
    FROM ?:settings_objects
    LEFT JOIN ?:settings_sections ON ?:settings_sections.section_id = ?:settings_objects.section_id
    INNER JOIN ?:settings_vendor_values ON ?:settings_vendor_values.object_id = ?:settings_objects.object_id;

DELETE FROM ?:settings_vendor_values WHERE object_id IN (
    SELECT object_id FROM ?:settings_objects WHERE section_id IN (
        SELECT section_id FROM ?:settings_sections WHERE type = 'ADDON'
    )
);

DROP TABLE IF EXISTS ?:settings_objects_upg;
CREATE TABLE `?:settings_objects_upg` (
  `object_id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(128) NOT NULL default '',
  `section_name` varchar(128) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`object_id`)
) Engine=MyISAM DEFAULT CHARSET UTF8;

INSERT INTO ?:settings_objects_upg
    SELECT
        ?:settings_objects.object_id,
        ?:settings_objects.name,
        ?:settings_sections.name as section_name,
        ?:settings_objects.value
    FROM ?:settings_objects
    LEFT JOIN ?:settings_sections ON ?:settings_sections.section_id = ?:settings_objects.section_id;

DELETE FROM ?:settings_descriptions WHERE object_type = 'V' AND object_id IN (
    SELECT variant_id FROM ?:settings_variants WHERE object_id IN (
        SELECT object_id FROM ?:settings_objects WHERE section_id IN (
            SELECT section_id FROM ?:settings_sections WHERE type = 'ADDON'
        )
    )
);

DELETE FROM ?:settings_descriptions WHERE object_type = 'O' AND object_id IN (
    SELECT object_id FROM ?:settings_objects WHERE section_id IN (
        SELECT section_id FROM ?:settings_sections WHERE type = 'ADDON'
    )
);

DELETE FROM ?:settings_descriptions WHERE object_type = 'S' AND object_id IN (
    SELECT section_id FROM ?:settings_sections WHERE parent_id IN (
        SELECT section_id FROM ?:settings_sections WHERE type = 'ADDON'
    )
);

DELETE FROM ?:settings_descriptions WHERE object_type = 'S' AND object_id IN (
    SELECT section_id FROM ?:settings_sections WHERE type = 'ADDON'
);

DELETE FROM ?:settings_variants WHERE object_id IN (
    SELECT object_id FROM ?:settings_objects WHERE section_id IN (
        SELECT section_id FROM ?:settings_sections WHERE type = 'ADDON'
    )
);

DELETE FROM ?:settings_objects WHERE section_id IN (
    SELECT section_id FROM ?:settings_sections WHERE type = 'ADDON'
);

DELETE s1, s2 FROM ?:settings_sections s1 LEFT JOIN ?:settings_sections as s2 ON s2.parent_id = s1.section_id WHERE s1.type = 'ADDON';

UPDATE `?:payment_processors` SET processor='eWAY Direct Payment', processor_script='eway_direct.php', processor_template='views/orders/components/payments/cc.tpl', admin_template='eway_direct.tpl', callback='Y', type='P' WHERE processor_id='19';
UPDATE `?:payment_processors` SET processor='eWAY Shared Payment', processor_script='eway_shared.php', processor_template='views/orders/components/payments/cc_outside.tpl', admin_template='eway_shared.tpl', callback='Y', type='P' WHERE processor_id='80';
UPDATE `?:payment_processors` SET processor='eWAY Direct Payment (Rapid API)', processor_script='eway_rapidapi_direct.php', processor_template='views/orders/components/payments/cc.tpl', admin_template='eway_rapidapi.tpl', callback='N', type='P' WHERE processor_id='92';
INSERT INTO `?:payment_processors` (processor, processor_script, processor_template, admin_template, callback, type) VALUES ('eWAY Responsive Shared (Rapid API)', 'eway_rapidapi_rsp.php', 'views/orders/components/payments/cc_outside.tpl', 'eway_rapidapi_rsp.tpl', 'N', 'P') ON DUPLICATE KEY UPDATE `processor_id` = `processor_id`;
INSERT INTO `?:payment_processors` (processor, processor_script, processor_template, admin_template, callback, type) VALUES ('FuturePay', 'future_pay.php', 'views/orders/components/payments/cc_outside.tpl', 'future_pay.tpl', 'N', 'P') ON DUPLICATE KEY UPDATE `processor_id` = `processor_id`;
DELETE FROM `?:settings_objects` WHERE name IN ('keep_https', 'header_8159');

ALTER TABLE `?:exim_layouts` ADD `options` text NOT NULL;
ALTER TABLE ?:orders ADD profile_id MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE ?:bm_layouts CHANGE `preset_id` `style_id` varchar(64) NOT NULL default '';
