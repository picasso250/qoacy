ALTER TABLE  `product` ADD  `labor` DECIMAL( 10, 2 ) NOT NULL AFTER  `length`;

UPDATE `product` SET `labor`='0';

-----------------------------------------------------------------------------------------
ALTER TABLE  `product` CHANGE  `rabbet_start`  `rabbet_start` DECIMAL( 6, 3 ) NOT NULL;
ALTER TABLE  `product` CHANGE  `rabbet_end`  `rabbet_end` DECIMAL( 6, 3 ) NOT NULL;

ALTER TABLE  `product` CHANGE  `small_stone`  `small_stone` INT( 4 ) NOT NULL;
ALTER TABLE  `product` CHANGE  `small_stone`  `small_stone` INT( 6 ) NOT NULL;
-------------------------------------------------------------------------------------------

-- --------------------------------------------------------

--
-- 表的结构 `visit_log`
--

CREATE TABLE IF NOT EXISTS `visit_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(50) NOT NULL,
  `start` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;
-----------------------------------------------------------------

ALTER TABLE  `visit_log` ADD  `user` INT( 10 ) UNSIGNED NOT NULL AFTER  `url`;
----------------------------------------------------------------------

ALTER TABLE  `cus_order` CHANGE  `size`  `size` VARCHAR( 10 ) NOT NULL;
ALTER TABLE  `cus_order` ADD  `price_remark` VARCHAR( 500 ) NOT NULL AFTER  `customer_remark`
----------------------------------------------------------------------------------------------------
ALTER TABLE  `price_data` ADD `part_expense` decimal(10,2) NOT NULL;
--------------------------------------------------------------------------------
ALTER TABLE  `stone` ADD `count` int(4) NOT NULL;

ALTER TABLE  `customer` ADD  `is_seller` BOOLEAN NOT NULL AFTER  `account`;
ALTER TABLE  `customer` ADD  `material_ratio` DECIMAL( 10, 4 ) NOT NULL AFTER  `is_seller`;
ALTER TABLE  `customer` ADD  `price_ration` DECIMAL( 10, 4 ) NOT NULL AFTER  `material_ratio`;
ALTER TABLE  `customer` CHANGE  `price_ration`  `price_ratio` DECIMAL( 10, 4 ) NOT NULL;
-------------------------------------------------------------
