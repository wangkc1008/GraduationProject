SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `t_shop_banner`;
CREATE TABLE `t_shop_banner`(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT 'Banner名称，通常作为标识',
  `description` varchar(255) DEFAULT NULL COMMENT 'Banner描述',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='banner管理表';

DROP TABLE IF EXISTS `t_shop_banner_item`;
CREATE TABLE `t_shop_banner_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL COMMENT '外键，关联image表',
  `key_word` varchar(100) NOT NULL COMMENT '执行关键字，根据不同的type含义不同',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '跳转类型，可能导向商品，可能导向专题，可能导向其他。0，无导向；1：导向商品;2:导向专题',
  `delete_time` int(11) DEFAULT NULL,
  `banner_id` int(11) NOT NULL COMMENT '外键，关联banner表',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='banner子项表';

INSERT INTO `t_shop_banner_item` VALUES ('1', '1', '2', '1', null, '1', null);
INSERT INTO `t_shop_banner_item` VALUES ('2', '12', '8', '1', null, '1', null);
INSERT INTO `t_shop_banner_item` VALUES ('3', '23', '15', '1', null, '1', null);
INSERT INTO `t_shop_banner_item` VALUES ('4', '34', '22', '1', null, '1', null);
INSERT INTO `t_shop_banner_item` VALUES ('5', '45', '29', '1', null, '1', null);

DROP TABLE IF EXISTS `t_shop_category`;
CREATE TABLE `t_shop_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `topic_img_id` int(11) DEFAULT NULL COMMENT '外键，关联image表',
  `delete_time` int(11) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL COMMENT '描述',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品类目';

INSERT INTO `t_shop_category` VALUES ('1', '荣耀', '9', null, null, null);
INSERT INTO `t_shop_category` VALUES ('2', '小米', '19', null, null, null);
INSERT INTO `t_shop_category` VALUES ('3', '华为', '31', null, null, null);
INSERT INTO `t_shop_category` VALUES ('4', 'Apple', '42', null, null, null);
INSERT INTO `t_shop_category` VALUES ('5', 'OPPO', '53', null, null, null);

DROP TABLE IF EXISTS `t_shop_image`;
CREATE TABLE `t_shop_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL COMMENT '图片路径',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 来自本地，2 来自公网',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='图片总表';

INSERT INTO `t_shop_image` VALUES ('1', '/honor@banner_head.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('2', '/product_honor_v20.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('3', '/product_honor_10_young.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('4', '/product_honor_20i.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('5', '/product_honor_10.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('6', '/product_honor_8x.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('7', '/product_honor_flypods.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('8', '/product_honor_MagicBook.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('9', '/category-honor.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('10', '/honor@theme.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('11', '/honor@theme-head.png', '1', null, null);

INSERT INTO `t_shop_image` VALUES ('12', '/xiaomi@banner_head.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('13', '/product_xiaomi_9.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('14', '/product_xiaomi_Note7.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('15', '/product_xiaomi_Note7Pro.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('16', '/product_xiaomi_8SE.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('17', '/product_xiaomi_Mix3.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('18', '/product_xiaomi_AI.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('19', '/product_xiaomi_hand.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('20', '/category-xiaomi.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('21', '/xiaomi@theme.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('22', '/xiaomi@theme-head.png', '1', null, null);

INSERT INTO `t_shop_image` VALUES ('23', '/huawei@banner_head.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('24', '/product_huawei_P30.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('25', '/product_huawei_9S.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('26', '/product_huawei_Mate20Pro.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('27', '/product_huawei_Mate20.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('28', '/product_huawei_P20.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('29', '/product_huawei_MateBook14.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('30', '/product_huawei_M5.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('31', '/category-huawei.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('32', '/huawei@theme.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('33', '/huawei@theme-head.png', '1', null, null);

INSERT INTO `t_shop_image` VALUES ('34', '/apple@banner_head.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('35', '/product_iphone_XR.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('36', '/product_iphone_XS.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('37', '/product_iphone_X.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('38', '/product_iphone_8Plus.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('39', '/product_iphone_MacBook.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('40', '/product_iphone_Watch.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('41', '/product_iphone_iPadPro2018.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('42', '/category-apple.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('43', '/apple@theme.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('44', '/apple@theme-head.png', '1', null, null);

INSERT INTO `t_shop_image` VALUES ('45', '/oppo@banner_head.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('46', '/product_oppo_reno.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('47', '/product_oppo_a9.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('48', '/product_oppo_k1.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('49', '/product_oppo_findx.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('50', '/product_oppo_r17.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('51', '/product_oppo_r15x.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('52', '/product_oppo_a5.png', '1', null, null);
INSERT INTO `t_shop_image` VALUES ('53', '/category-oppo.png', '1', null, null);

DROP TABLE IF EXISTS `t_shop_order`;
CREATE TABLE `t_shop_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) NOT NULL COMMENT '订单号',
  `user_id` int(11) NOT NULL COMMENT '外键，用户id，注意并不是openid',
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `total_price` decimal(6,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:未支付， 2：已支付，3：已发货 , 4: 已支付，但库存不足',
  `snap_img` varchar(255) DEFAULT NULL COMMENT '订单快照图片',
  `snap_name` varchar(80) DEFAULT NULL COMMENT '订单快照名称',
  `total_count` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) DEFAULT NULL,
  `snap_items` text COMMENT '订单其他信息快照（json)',
  `snap_address` varchar(500) DEFAULT NULL COMMENT '地址快照',
  `prepay_id` varchar(100) DEFAULT NULL COMMENT '订单微信支付的预订单id（用于发送模板消息）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_no` (`order_no`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `t_shop_order_product`;
CREATE TABLE `t_shop_order_product` (
  `order_id` int(11) NOT NULL COMMENT '联合主键，订单id',
  `product_id` int(11) NOT NULL COMMENT '联合主键，商品id',
  `count` int(11) NOT NULL COMMENT '商品数量',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`,`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `t_shop_product`;
CREATE TABLE `t_shop_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL COMMENT '商品名称',
  `price` decimal(6,2) NOT NULL COMMENT '价格,单位：分',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存量',
  `delete_time` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `main_img_url` varchar(255) DEFAULT NULL COMMENT '主图ID号，这是一个反范式设计，有一定的冗余',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '图片来自 1 本地 ，2公网',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL,
  `summary` varchar(50) DEFAULT NULL COMMENT '摘要',
  `img_id` int(11) DEFAULT NULL COMMENT '图片外键',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `t_shop_product` VALUES ('1', '荣耀V20', '0.01', '998', null, '1', '/product_honor_v20.png', '1', null, null, null, '2');
INSERT INTO `t_shop_product` VALUES ('2', '荣耀10-青春版', '0.01', '984', null, '1', '/product_honor_10_young.png', '1', null, null, null, '3');
INSERT INTO `t_shop_product` VALUES ('3', '荣耀20i', '0.01', '996', null, '1', '/product_honor_20i.png', '1', null, null, null, '4');
INSERT INTO `t_shop_product` VALUES ('4', '荣耀10', '0.01', '998', null, '1', '/product_honor_10.png', '1', null, null, null, '5');
INSERT INTO `t_shop_product` VALUES ('5', '荣耀8X', '0.01', '995', null, '1', '/product_honor_8x.png', '1', null, null, null, '6');
INSERT INTO `t_shop_product` VALUES ('6', '荣耀Flypods', '0.01', '997', null, '1', '/product_honor_flypods.png', '1', null, null, null, '7');
INSERT INTO `t_shop_product` VALUES ('7', '荣耀MagicBook', '0.01', '998', null, '1', '/product_honor_MagicBook.png', '1', null, null, null, '8');

INSERT INTO `t_shop_product` VALUES ('8', '小米9', '0.01', '995', null, '2', '/product_xiaomi_9.png', '1', null, null, null, '13');
INSERT INTO `t_shop_product` VALUES ('9', '小米Note7', '0.01', '995', null, '2', '/product_xiaomi_Note7.png', '1', null, null, null, '14');
INSERT INTO `t_shop_product` VALUES ('10', '小米Note7Pro', '0.01', '995', null, '2', '/product_xiaomi_Note7Pro.png', '1', null, null, null, '15');
INSERT INTO `t_shop_product` VALUES ('11', '小米8SE', '0.01', '995', null, '2', '/product_xiaomi_8SE.png', '1', null, null, null, '16');
INSERT INTO `t_shop_product` VALUES ('12', '小米Mix3', '0.01', '995', null, '2', '/product_xiaomi_Mix3.png', '1', null, null, null, '17');
INSERT INTO `t_shop_product` VALUES ('13', '小米AI音响', '0.01', '995', null, '2', '/product_xiaomi_AI.png', '1', null, null, null, '18');
INSERT INTO `t_shop_product` VALUES ('14', '小米手环', '0.01', '995', null, '2', '/product_xiaomi_hand.png', '1', null, null, null, '19');

INSERT INTO `t_shop_product` VALUES ('15', '华为P30', '0.01', '995', null, '3', '/product_huawei_P30.png', '1', null, null, null, '24');
INSERT INTO `t_shop_product` VALUES ('16', '华为9S', '0.01', '995', null, '3', '/product_huawei_9S.png', '1', null, null, null, '25');
INSERT INTO `t_shop_product` VALUES ('17', '华为Mate20Pro', '0.01', '995', null, '3', '/product_huawei_Mate20Pro.png', '1', null, null, null, '26');
INSERT INTO `t_shop_product` VALUES ('18', '华为Mate20', '0.01', '995', null, '3', '/product_huawei_Mate20.png', '1', null, null, null, '27');
INSERT INTO `t_shop_product` VALUES ('19', '华为P20', '0.01', '995', null, '3', '/product_huawei_P20.png', '1', null, null, null, '28');
INSERT INTO `t_shop_product` VALUES ('20', '华为笔记本MateBook14', '0.01', '995', null, '3', '/product_huawei_MateBook14.png', '1', null, null, null, '29');
INSERT INTO `t_shop_product` VALUES ('21', '华为平板M5', '0.01', '995', null, '3', '/product_huawei_M5.png', '1', null, null, null, '30');

INSERT INTO `t_shop_product` VALUES ('22', 'iPhone XR', '0.01', '995', null, '4', '/product_iphone_XR.png', '1', null, null, null, '35');
INSERT INTO `t_shop_product` VALUES ('23', 'iPhone XS', '0.01', '995', null, '4', '/product_iphone_XS.png', '1', null, null, null, '36');
INSERT INTO `t_shop_product` VALUES ('24', 'iPhone X', '0.01', '995', null, '4', '/product_iphone_X.png', '1', null, null, null, '37');
INSERT INTO `t_shop_product` VALUES ('25', 'iPhone 8Plus', '0.01', '995', null, '4', '/product_iphone_8Plus.png', '1', null, null, null, '38');
INSERT INTO `t_shop_product` VALUES ('26', 'MacBook', '0.01', '995', null, '4', '/product_iphone_MacBook.png', '1', null, null, null, '39');
INSERT INTO `t_shop_product` VALUES ('27', 'Apple Watch', '0.01', '995', null, '4', '/product_iphone_Watch.png', '1', null, null, null, '40');
INSERT INTO `t_shop_product` VALUES ('28', 'iPadPro2018', '0.01', '995', null, '4', '/product_iphone_iPadPro2018.png', '1', null, null, null, '41');

INSERT INTO `t_shop_product` VALUES ('29', 'OPPO Reno', '0.01', '995', null, '5', '/product_oppo_reno.png', '1', null, null, null, '46');
INSERT INTO `t_shop_product` VALUES ('30', 'OPPO A9', '0.01', '995', null, '5', '/product_oppo_a9.png', '1', null, null, null, '47');
INSERT INTO `t_shop_product` VALUES ('31', 'OPPO K1', '0.01', '995', null, '5', '/product_oppo_k1.png', '1', null, null, null, '48');
INSERT INTO `t_shop_product` VALUES ('32', 'OPPO FindX', '0.01', '995', null, '5', '/product_oppo_findx.png', '1', null, null, null, '49');
INSERT INTO `t_shop_product` VALUES ('33', 'OPPO R17', '0.01', '995', null, '5', '/product_oppo_r17.png', '1', null, null, null, '50');
INSERT INTO `t_shop_product` VALUES ('34', 'OPPO R15X', '0.01', '995', null, '5', '/product_oppo_r15x.png', '1', null, null, null, '51');
INSERT INTO `t_shop_product` VALUES ('35', 'OPPO A5', '0.01', '995', null, '5', '/product_oppo_a5.png', '1', null, null, null, '52');


DROP TABLE IF EXISTS `t_shop_product_image`;
CREATE TABLE `t_shop_product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL COMMENT '外键，关联图片表',
  `delete_time` int(11) DEFAULT NULL COMMENT '状态，主要表示是否删除，也可以扩展其他状态',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '图片排序序号',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `t_shop_product_property`;
CREATE TABLE `t_shop_product_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT '' COMMENT '详情属性名称',
  `detail` varchar(255) NOT NULL COMMENT '详情属性',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `t_shop_theme`;
CREATE TABLE `t_shop_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '专题名称',
  `description` varchar(255) DEFAULT NULL COMMENT '专题描述',
  `topic_img_id` int(11) NOT NULL COMMENT '主题图，外键',
  `delete_time` int(11) DEFAULT NULL,
  `head_img_id` int(11) NOT NULL COMMENT '专题列表页，头图',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='主题信息表';

INSERT INTO `t_shop_theme` VALUES ('1', '荣耀商城', '荣耀商城', '10', null, '11', null);
INSERT INTO `t_shop_theme` VALUES ('2', '小米商城', '小米商城', '21', null, '22', null);
INSERT INTO `t_shop_theme` VALUES ('3', '华为商城', '华为商城', '32', null, '33', null);
INSERT INTO `t_shop_theme` VALUES ('4', '苹果商城', '苹果商城', '43', null, '44', null);

DROP TABLE IF EXISTS `t_shop_theme_product`;
CREATE TABLE `t_shop_theme_product` (
  `theme_id` int(11) NOT NULL COMMENT '主题外键',
  `product_id` int(11) NOT NULL COMMENT '商品外键',
  PRIMARY KEY (`theme_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='主题所包含的商品';

INSERT INTO `t_shop_theme_product` VALUES ('1', '1');
INSERT INTO `t_shop_theme_product` VALUES ('1', '2');
INSERT INTO `t_shop_theme_product` VALUES ('1', '3');
INSERT INTO `t_shop_theme_product` VALUES ('1', '4');
INSERT INTO `t_shop_theme_product` VALUES ('1', '5');
INSERT INTO `t_shop_theme_product` VALUES ('1', '6');
INSERT INTO `t_shop_theme_product` VALUES ('1', '7');

INSERT INTO `t_shop_theme_product` VALUES ('2', '8');
INSERT INTO `t_shop_theme_product` VALUES ('2', '9');
INSERT INTO `t_shop_theme_product` VALUES ('2', '10');
INSERT INTO `t_shop_theme_product` VALUES ('2', '11');
INSERT INTO `t_shop_theme_product` VALUES ('2', '12');
INSERT INTO `t_shop_theme_product` VALUES ('2', '13');
INSERT INTO `t_shop_theme_product` VALUES ('2', '14');

INSERT INTO `t_shop_theme_product` VALUES ('3', '15');
INSERT INTO `t_shop_theme_product` VALUES ('3', '16');
INSERT INTO `t_shop_theme_product` VALUES ('3', '17');
INSERT INTO `t_shop_theme_product` VALUES ('3', '18');
INSERT INTO `t_shop_theme_product` VALUES ('3', '19');
INSERT INTO `t_shop_theme_product` VALUES ('3', '20');
INSERT INTO `t_shop_theme_product` VALUES ('3', '21');

INSERT INTO `t_shop_theme_product` VALUES ('4', '22');
INSERT INTO `t_shop_theme_product` VALUES ('4', '23');
INSERT INTO `t_shop_theme_product` VALUES ('4', '24');
INSERT INTO `t_shop_theme_product` VALUES ('4', '25');
INSERT INTO `t_shop_theme_product` VALUES ('4', '26');
INSERT INTO `t_shop_theme_product` VALUES ('4', '27');
INSERT INTO `t_shop_theme_product` VALUES ('4', '28');


DROP TABLE IF EXISTS `t_shop_user`;
CREATE TABLE `t_shop_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `extend` varchar(255) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `t_shop_user_address`;
CREATE TABLE `t_shop_user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '收获人姓名',
  `mobile` varchar(20) NOT NULL COMMENT '手机号',
  `province` varchar(20) DEFAULT NULL COMMENT '省',
  `city` varchar(20) DEFAULT NULL COMMENT '市',
  `country` varchar(20) DEFAULT NULL COMMENT '区',
  `detail` varchar(100) DEFAULT NULL COMMENT '详细地址',
  `delete_time` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT '外键',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

