
DROP TABLE IF EXISTS cscart_reward_point_changes;
CREATE TABLE `cscart_reward_point_changes` (
  `change_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `amount` int(11) NOT NULL DEFAULT '0',
  `timestamp` int(11) unsigned NOT NULL DEFAULT '0',
  `action` char(1) NOT NULL DEFAULT 'A',
  `reason` text NOT NULL,
  `expiration_date` int(11) unsigned NOT NULL,
  `is_spent` char(1) NOT NULL DEFAULT 'N',
  `allocated` int(11) NOT NULL,
  PRIMARY KEY (`change_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO cscart_reward_point_changes (`change_id`, `user_id`, `amount`, `timestamp`, `action`, `reason`, `expiration_date`, `is_spent`, `allocated`) VALUES ('2', '3', '10', '1395768003', 'O', 'a:4:{s:8:\"order_id\";s:3:\"109\";s:2:\"to\";s:1:\"C\";s:4:\"from\";s:1:\"P\";s:10:\"product_id\";s:2:\"12\";}', '1398729600', 'N', '0');
INSERT INTO cscart_reward_point_changes (`change_id`, `user_id`, `amount`, `timestamp`, `action`, `reason`, `expiration_date`, `is_spent`, `allocated`) VALUES ('3', '3', '23', '1395768003', 'O', 'a:4:{s:8:\"order_id\";s:3:\"109\";s:2:\"to\";s:1:\"C\";s:4:\"from\";s:1:\"P\";s:10:\"product_id\";s:2:\"17\";}', '1398297600', 'Y', '0');
INSERT INTO cscart_reward_point_changes (`change_id`, `user_id`, `amount`, `timestamp`, `action`, `reason`, `expiration_date`, `is_spent`, `allocated`) VALUES ('4', '3', '-25', '1395768886', 'P', 'a:4:{s:8:\"order_id\";s:3:\"110\";s:2:\"to\";s:1:\"O\";s:4:\"from\";s:1:\"N\";s:4:\"text\";s:27:\"text_decrease_points_in_use\";}', '0', 'N', '-23');

DROP TABLE IF EXISTS cscart_user_data;
CREATE TABLE `cscart_user_data` (
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `type` char(1) NOT NULL DEFAULT '',
  `data` text NOT NULL,
  PRIMARY KEY (`user_id`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO cscart_user_data (`user_id`, `type`, `data`) VALUES ('1', 'L', 'a:10:{i:2404353148;a:4:{s:4:\"func\";a:2:{i:0;s:19:\"fn_get_product_name\";i:1;s:3:\"197\";}s:3:\"url\";s:75:\"admin.php?dispatch=products.update&product_id=197&selected_section=location\";s:4:\"icon\";s:12:\"product-item\";s:4:\"text\";s:7:\"product\";}i:3430194429;a:4:{s:4:\"func\";a:2:{i:0;s:19:\"fn_get_product_name\";i:1;s:3:\"208\";}s:3:\"url\";s:75:\"admin.php?dispatch=products.update&product_id=208&selected_section=location\";s:4:\"icon\";s:12:\"product-item\";s:4:\"text\";s:7:\"product\";}i:2897417496;a:4:{s:4:\"func\";a:2:{i:0;s:19:\"fn_get_product_name\";i:1;s:3:\"211\";}s:3:\"url\";s:75:\"admin.php?dispatch=products.update&product_id=211&selected_section=location\";s:4:\"icon\";s:12:\"product-item\";s:4:\"text\";s:7:\"product\";}i:2303053545;a:4:{s:4:\"func\";a:2:{i:0;s:19:\"fn_get_product_name\";i:1;s:3:\"229\";}s:3:\"url\";s:75:\"admin.php?dispatch=products.update&product_id=229&selected_section=location\";s:4:\"icon\";s:12:\"product-item\";s:4:\"text\";s:7:\"product\";}i:1335915774;a:4:{s:4:\"func\";a:2:{i:0;s:19:\"fn_get_product_name\";i:1;s:3:\"246\";}s:3:\"url\";s:75:\"admin.php?dispatch=products.update&product_id=246&selected_section=location\";s:4:\"icon\";s:12:\"product-item\";s:4:\"text\";s:7:\"product\";}i:2996972101;a:4:{s:4:\"func\";a:2:{i:0;s:19:\"fn_get_product_name\";i:1;s:2:\"12\";}s:3:\"url\";s:48:\"admin.php?dispatch=products.update&product_id=12\";s:4:\"icon\";s:12:\"product-item\";s:4:\"text\";s:7:\"product\";}i:3267944138;a:4:{s:4:\"func\";a:2:{i:0;s:19:\"fn_get_product_name\";i:1;s:2:\"17\";}s:3:\"url\";s:79:\"admin.php?dispatch=products.update&product_id=17&selected_section=reward_points\";s:4:\"icon\";s:12:\"product-item\";s:4:\"text\";s:7:\"product\";}i:1837959435;a:4:{s:4:\"func\";a:2:{i:0;s:16:\"fn_get_user_name\";i:1;s:1:\"3\";}s:3:\"url\";s:56:\"admin.php?dispatch=profiles.update&user_id=3&user_type=C\";s:4:\"icon\";s:0:\"\";s:4:\"text\";s:4:\"user\";}i:126625312;a:4:{s:4:\"func\";a:2:{i:0;s:19:\"fn_get_product_name\";i:1;s:3:\"232\";}s:3:\"url\";s:49:\"admin.php?dispatch=products.update&product_id=232\";s:4:\"icon\";s:12:\"product-item\";s:4:\"text\";s:7:\"product\";}i:2724764970;a:4:{s:4:\"func\";a:2:{i:0;s:19:\"fn_get_product_name\";i:1;s:3:\"219\";}s:3:\"url\";s:75:\"admin.php?dispatch=products.update&product_id=219&selected_section=location\";s:4:\"icon\";s:12:\"product-item\";s:4:\"text\";s:7:\"product\";}}');
INSERT INTO cscart_user_data (`user_id`, `type`, `data`) VALUES ('3', 'W', 'd:8;');
