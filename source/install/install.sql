--
-- 数据库: `xshopy`
--
CREATE DATABASE `xshopy` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `xshopy`;

-- --------------------------------------------------------

--
-- 表的结构 `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='钱的账户或者辅石的账户' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `account_log`
--

CREATE TABLE IF NOT EXISTS `account_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` int(10) unsigned NOT NULL COMMENT 'id of account',
  `name` char(20) NOT NULL COMMENT '名称|备注',
  `order` int(10) unsigned NOT NULL COMMENT '相关订单',
  `money` decimal(10,2) NOT NULL COMMENT '金额 ',
  `num` int(9) NOT NULL,
  `type` char(20) NOT NULL COMMENT ' 类型',
  `remain` decimal(10,2) NOT NULL COMMENT '账户余额',
  `pay_type` char(20) NOT NULL COMMENT '支付方式',
  `remark` varchar(200) NOT NULL,
  `time` datetime NOT NULL,
  `ms` smallint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  `name` char(20) NOT NULL COMMENT '姓名',
  `customer` int(10) unsigned NOT NULL,
  `phone` char(20) NOT NULL,
  `detail` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `customer` int(10) unsigned NOT NULL,
  `small_order` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `account` int(10) NOT NULL,
  `is_seller` tinyint(1) NOT NULL,
  `material_ratio` decimal(10,4) NOT NULL,
  `price_ratio` decimal(10,4) NOT NULL,
  `state` char(20) NOT NULL COMMENT '是否被通过',
  `gender` char(10) NOT NULL,
  `qq` char(20) NOT NULL,
  `city` char(20) NOT NULL,
  `remark` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sn` char(10) NOT NULL,
  `big_order` int(10) unsigned NOT NULL,
  `fac_order` int(10) unsigned NOT NULL,
  `product` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `stone` int(10) unsigned NOT NULL COMMENT '主石，0代表无',
  `size` varchar(10) NOT NULL,
  `carve_text` varchar(120) DEFAULT NULL,
  `material` char(20) NOT NULL,
  `material_weight` decimal(10,4) NOT NULL,
  `material_price` decimal(10,2) NOT NULL,
  `weight_ratio` decimal(6,2) NOT NULL DEFAULT '1.00',
  `small_stone` smallint(4) NOT NULL,
  `st_weight` decimal(10,4) NOT NULL,
  `length` decimal(10,2) NOT NULL,
  `state` char(18) NOT NULL,
  `image` varchar(100) NOT NULL,
  `price_data` int(10) unsigned NOT NULL,
  `add_cart_time` datetime DEFAULT NULL,
  `submit_time` datetime DEFAULT NULL,
  `confirm_time` datetime DEFAULT NULL,
  `confirm_price_time` datetime NOT NULL,
  `done_time` datetime DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estimate_price` decimal(10,2) NOT NULL,
  `paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'customer_paid',
  `customer_remark` text,
  `price_remark` varchar(500) NOT NULL,
  `admin_remark` text,
  `is_customized` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no` char(20) NOT NULL COMMENT '款号',
  `name` char(60) NOT NULL,
  `is_customized` tinyint(1) NOT NULL DEFAULT '0',
  `is_brand` tinyint(1) NOT NULL DEFAULT '0',
  `brand` int(10) NOT NULL,
  `type` char(20) NOT NULL,
  `material` char(120) NOT NULL COMMENT 'JSON',
  `weight` decimal(10,4) DEFAULT NULL,
  `rabbet_start` decimal(6,3) NOT NULL,
  `rabbet_end` decimal(6,3) NOT NULL,
  `small_stone` int(6) NOT NULL,
  `st_weight` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT '这是什么？',
  `length` decimal(10,2) NOT NULL,
  `labor` decimal(10,2) NOT NULL,
  `remark` text,
  `carve_allow` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `post_time` datetime DEFAULT NULL,
  `sold_count` int(8) NOT NULL DEFAULT '0',
  `pair` int(10) unsigned NOT NULL COMMENT '对戒',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- 表的结构 `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `key` char(30) NOT NULL,
  `value` char(30) NOT NULL,
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_log`
--

CREATE TABLE IF NOT EXISTS `user_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` int(10) unsigned NOT NULL COMMENT '主语 user_id or customer_id or ???',
  `action` char(20) NOT NULL COMMENT '动词',
  `target` int(10) unsigned DEFAULT NULL COMMENT '宾语',
  `info` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
