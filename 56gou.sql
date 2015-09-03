-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-09-03 13:54:07
-- 服务器版本： 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `56g`
--

-- --------------------------------------------------------

--
-- 表的结构 `collect`
--

CREATE TABLE IF NOT EXISTS `collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `key` varchar(100) NOT NULL,
  `cat` varchar(50) NOT NULL,
  `cid` int(11) NOT NULL DEFAULT '1',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='采集列' AUTO_INCREMENT=155 ;

--
-- 转存表中的数据 `collect`
--

INSERT INTO `collect` (`id`, `name`, `key`, `cat`, `cid`, `add_time`) VALUES
(146, '衣服-休闲裤', '休闲裤', '16,18', 1, 1438516073),
(145, '衣服-T恤', 'T恤', '16,18', 1, 1438515990),
(147, '鞋子-单鞋', '单鞋', '50012027', 2, 1438516839),
(148, '包包-单肩包', '单肩包', '50006842', 3, 1438518661),
(149, '包包-钱包', '女 钱包', '50006842', 3, 1438520235),
(150, '配饰-手表', '女 手表', '0', 4, 1438520344),
(151, '配饰-项链', '项链', '0', 4, 1438520519),
(152, '鞋子-帆布鞋', '帆布鞋', '50012042', 2, 1438521268),
(153, '鞋子-高跟单鞋', '高跟单鞋', '0', 2, 1438521372),
(154, '鞋子-低跟单鞋', '低跟单鞋', '0', 2, 1438521746);

-- --------------------------------------------------------

--
-- 表的结构 `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `iid` bigint(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `pic_url` varchar(255) NOT NULL,
  `small_images` varchar(255) NOT NULL,
  `price` double(10,2) NOT NULL,
  `zk_price` double(10,2) NOT NULL,
  `rate` double(4,1) NOT NULL,
  `provcity` varchar(50) NOT NULL,
  `item_url` varchar(255) NOT NULL,
  `volume` int(11) NOT NULL,
  `taobao_uid` bigint(11) NOT NULL,
  `taobao_uname` varchar(50) NOT NULL,
  `shop_url` varchar(255) NOT NULL,
  `shop_type` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `index` int(11) NOT NULL DEFAULT '0',
  `tuijian` int(11) NOT NULL DEFAULT '0',
  `baoyou` int(11) NOT NULL DEFAULT '0',
  `endtime` int(11) NOT NULL,
  `starttime` int(11) NOT NULL,
  `addtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品存放表' AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `goods`
--

INSERT INTO `goods` (`id`, `cid`, `iid`, `title`, `pic_url`, `small_images`, `price`, `zk_price`, `rate`, `provcity`, `item_url`, `volume`, `taobao_uid`, `taobao_uname`, `shop_url`, `shop_type`, `user_id`, `index`, `tuijian`, `baoyou`, `endtime`, `starttime`, `addtime`) VALUES
(1, 2, 44818788663, '义兴源北京布鞋女春夏款坡跟圆头通勤工装鞋女式低跟黑色上班单鞋', 'http://img2.tbcdn.cn/tfscom/i3/TB1Ni6fIXXXXXamXFXXXXXXXXXX_!!0-item_pic.jpg', 'http://img3.tbcdn.cn/tfscom/i2/786710037/TB2soKxcpXXXXXOXpXXXXXXXXXX_!!786710037.jpg|br|http://img1.tbcdn.cn/tfscom/i1/786710037/TB2eC4acFXXXXXBXpXXXXXXXXXX_!!786710037.jpg|br|http://img1.tbcdn.cn/tfscom/i3/786710037/TB2lQpXcFXXXXaGXpXXXXXXXXXX_!!78671003', 128.00, 39.00, 3.0, '陕西 西安', 'http://item.taobao.com/item.htm?id=44818788663', 7, 786710037, '义兴源鞋类旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=786710037', 'tmall', 0, 0, 0, 0, 1443629844, 1441037844, 1441037844),
(2, 2, 22113535279, '【Kvoll】pu皮黑色 韩版时尚淑女条形尖头拼色低跟单鞋D7429', 'http://img2.tbcdn.cn/tfscom/i2/T1SsKxFdVfXXXXXXXX_!!0-item_pic.jpg', 'http://img3.tbcdn.cn/tfscom/i2/19209027140635495/T1XJ9tFkdbXXXXXXXX_!!0-item_pic.jpg|br|http://img3.tbcdn.cn/tfscom/i2/139649209/T2CkQ3XfBaXXXXXXXX_!!139649209.jpg|br|http://img3.tbcdn.cn/tfscom/i1/139649209/T2wxjEXh4bXXXXXXXX_!!139649209.jpg|br|http://im', 166.00, 49.00, 3.0, '广东 广州', 'http://item.taobao.com/item.htm?id=22113535279', 1, 139649209, 'kvoll旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=139649209', 'tmall', 0, 0, 0, 0, 1443629847, 1441037847, 1441037847),
(3, 2, 16468607526, '【kvoll】帆布印花鞋后系带草编跟舒适百搭低跟浅口单鞋 D6229', 'http://img3.tbcdn.cn/tfscom/i3/T1RNuRFB4dXXXXXXXX_!!0-item_pic.jpg', 'http://img2.tbcdn.cn/tfscom/i1/T12s2qXXpsXXXWpZEW_023020.jpg|br|http://img3.tbcdn.cn/tfscom/i3/139649209/T29OVwXiNNXXXXXXXX_!!139649209.jpg|br|http://img1.tbcdn.cn/tfscom/i3/139649209/T2DOFeXe4OXXXXXXXX_!!139649209.jpg|br|http://img3.tbcdn.cn/tfscom/i4/13', 128.00, 38.00, 3.0, '广东 广州', 'http://item.taobao.com/item.htm?id=16468607526', 1, 139649209, 'kvoll旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=139649209', 'tmall', 0, 0, 0, 0, 1443629865, 1441037865, 1441037865),
(4, 2, 521072212358, '秋夏季2015新款低跟平底时尚潮低帮学生韩版休闲鞋运动鞋女鞋单鞋', 'http://img3.tbcdn.cn/tfscom/i1/TB1p_Q7IFXXXXaoaXXXXXXXXXXX_!!0-item_pic.jpg', 'http://img2.tbcdn.cn/tfscom/i3/704084145/TB2Z9MveXXXXXcKXXXXXXXXXXXX_!!704084145.jpg|br|http://img3.tbcdn.cn/tfscom/i2/704084145/TB2z5gFeXXXXXaqXXXXXXXXXXXX_!!704084145.jpg|br|http://img1.tbcdn.cn/tfscom/i1/704084145/TB2Y9EKeXXXXXXkXXXXXXXXXXXX_!!70408414', 168.00, 49.90, 3.0, '浙江 台州', 'http://item.taobao.com/item.htm?id=521072212358', 29, 704084145, '伊途旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=704084145', 'tmall', 0, 0, 0, 0, 1443630007, 1441038007, 1441038007),
(5, 2, 520535930404, '名典艺族2015夏季新款时尚低跟舒适尖头单鞋水钻一脚蹬工作女鞋子', 'http://img1.tbcdn.cn/tfscom/i1/TB1if4HIFXXXXc4XFXXXXXXXXXX_!!0-item_pic.jpg', 'http://img4.tbcdn.cn/tfscom/i3/1919306328/TB2bxYrdFXXXXbFXXXXXXXXXXXX_!!1919306328.jpg|br|http://img4.tbcdn.cn/tfscom/i3/1919306328/TB2ACzudFXXXXa9XXXXXXXXXXXX_!!1919306328.jpg|br|http://img1.tbcdn.cn/tfscom/i4/1919306328/TB2Q0vmdFXXXXcHXXXXXXXXXXXX_!!191', 72.00, 47.00, 6.5, '浙江 台州', 'http://item.taobao.com/item.htm?id=520535930404', 0, 1919306328, '名典艺族旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=1919306328', 'tmall', 0, 0, 0, 0, 1443630013, 1441038013, 1441038013),
(6, 2, 521198110671, '名典艺族2015春秋新款绒面方跟圆头中口单鞋套脚低跟学生乐福女鞋', 'http://img3.tbcdn.cn/tfscom/i1/TB13FluIFXXXXc5XXXXXXXXXXXX_!!0-item_pic.jpg', 'http://img4.tbcdn.cn/tfscom/i1/1919306328/TB2DiSHepXXXXaAXXXXXXXXXXXX_!!1919306328.jpg|br|http://img3.tbcdn.cn/tfscom/i4/1919306328/TB2cT9zepXXXXb4XXXXXXXXXXXX_!!1919306328.jpg|br|http://img4.tbcdn.cn/tfscom/i1/1919306328/TB2SAWoepXXXXasXpXXXXXXXXXX_!!191', 68.00, 48.00, 7.1, '浙江 台州', 'http://item.taobao.com/item.htm?id=521198110671', 0, 1919306328, '名典艺族旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=1919306328', 'tmall', 0, 0, 0, 0, 1443630016, 1441038016, 1441038016),
(7, 2, 45576008155, 'AIMALY/爱丽舒适妈妈鞋夏季新款牛皮浅口坡跟圆头低跟休闲单鞋', 'http://img3.tbcdn.cn/tfscom/i4/TB1zesjFFXXXXaJaVXXXXXXXXXX_!!0-item_pic.jpg', 'http://img1.tbcdn.cn/tfscom/i3/1971682217/TB2ZpgXcFXXXXXVXXXXXXXXXXXX_!!1971682217.jpg|br|http://img4.tbcdn.cn/tfscom/i3/1971682217/TB2AFTOcFXXXXXLXXXXXXXXXXXX_!!1971682217.jpg|br|http://img1.tbcdn.cn/tfscom/i3/1971682217/TB2Q1DOcFXXXXXjXXXXXXXXXXXX_!!197', 226.00, 35.00, 1.5, '广东 广州', 'http://item.taobao.com/item.htm?id=45576008155', 0, 1971682217, '爱丽旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=1971682217', 'tmall', 0, 0, 0, 0, 1443630019, 1441038019, 1441038019),
(8, 2, 520827333632, '名典艺族2015春秋日系新款方跟流苏漆皮复古学生单鞋浅口低跟女鞋', 'http://img3.tbcdn.cn/tfscom/i2/TB1Zb_RIFXXXXXcaXXXXXXXXXXX_!!0-item_pic.jpg', 'http://img2.tbcdn.cn/tfscom/i4/1919306328/TB2Ia_0dVXXXXcRXXXXXXXXXXXX_!!1919306328.jpg|br|http://img4.tbcdn.cn/tfscom/i4/1919306328/TB2BPP4dVXXXXb2XXXXXXXXXXXX_!!1919306328.jpg|br|http://img3.tbcdn.cn/tfscom/i1/1919306328/TB2ekfUdVXXXXc8XXXXXXXXXXXX_!!191', 76.00, 46.00, 6.1, '浙江 台州', 'http://item.taobao.com/item.htm?id=520827333632', 0, 1919306328, '名典艺族旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=1919306328', 'tmall', 0, 0, 0, 0, 1443630023, 1441038023, 1441038023),
(9, 2, 521054778807, '秋季新款2015夏时尚潮低跟平底韩版弹力布女鞋乐福鞋女单鞋休闲鞋', 'http://img2.tbcdn.cn/tfscom/i3/TB1gCKdIVXXXXbVXVXXXXXXXXXX_!!0-item_pic.jpg', 'http://img1.tbcdn.cn/tfscom/i1/704084145/TB2E4cheXXXXXbSXXXXXXXXXXXX_!!704084145.jpg|br|http://img2.tbcdn.cn/tfscom/i2/704084145/TB2pnspeXXXXXXRXXXXXXXXXXXX_!!704084145.jpg|br|http://img2.tbcdn.cn/tfscom/i4/704084145/TB25Lr.eXXXXXX0XpXXXXXXXXXX_!!70408414', 158.00, 45.50, 2.9, '浙江 台州', 'http://item.taobao.com/item.htm?id=521054778807', 1, 704084145, '伊途旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=704084145', 'tmall', 0, 0, 0, 0, 1443630032, 1441038032, 1441038032),
(10, 2, 22990940322, '2015秋新品条纹休闲低跟蝴蝶结单鞋老北京特色布鞋淑女鞋条纹鞋女', 'http://img3.tbcdn.cn/tfscom/i3/TB1TlpcIXXXXXbwXVXXXXXXXXXX_!!0-item_pic.jpg', 'http://img4.tbcdn.cn/tfscom/i2/795569396/TB29FtobXXXXXbTXpXXXXXXXXXX_!!795569396.jpg|br|http://img4.tbcdn.cn/tfscom/i4/795569396/TB2t6_kcVXXXXbWXXXXXXXXXXXX_!!795569396.jpg|br|http://img1.tbcdn.cn/tfscom/i1/795569396/TB2tO2fcVXXXXXBXpXXXXXXXXXX_!!79556939', 89.00, 49.00, 5.5, '浙江 台州', 'http://item.taobao.com/item.htm?id=22990940322', 0, 795569396, '燕语清秋旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=795569396', 'tmall', 0, 0, 0, 0, 1443630054, 1441038054, 1441038054),
(11, 2, 521072469893, '秋夏季2015新款时尚潮韩版甜美糖果色漆皮女鞋浅口低跟圆头单鞋女', 'http://img3.tbcdn.cn/tfscom/i2/TB1GDXsIpXXXXX1XFXXXXXXXXXX_!!0-item_pic.jpg', 'http://img1.tbcdn.cn/tfscom/i1/704084145/TB2jucHeXXXXXbcXXXXXXXXXXXX_!!704084145.jpg|br|http://img2.tbcdn.cn/tfscom/i3/704084145/TB2incPeXXXXXXjXXXXXXXXXXXX_!!704084145.jpg|br|http://img1.tbcdn.cn/tfscom/i1/704084145/TB29o.veXXXXXX7XpXXXXXXXXXX_!!70408414', 88.00, 29.90, 3.4, '浙江 台州', 'http://item.taobao.com/item.htm?id=521072469893', 2, 704084145, '伊途旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=704084145', 'tmall', 0, 0, 0, 0, 1443630061, 1441038061, 1441038061);

-- --------------------------------------------------------

--
-- 表的结构 `itemtxt`
--

CREATE TABLE IF NOT EXISTS `itemtxt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iid` bigint(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `pic_url` varchar(255) NOT NULL,
  `small_images` varchar(255) NOT NULL,
  `price` double(10,2) NOT NULL,
  `zk_price` double(10,2) NOT NULL,
  `provcity` varchar(50) NOT NULL,
  `item_url` varchar(255) NOT NULL,
  `volume` int(11) NOT NULL,
  `taobao_uid` bigint(11) NOT NULL,
  `taobao_uname` varchar(50) NOT NULL,
  `shop_url` varchar(255) NOT NULL,
  `shop_type` varchar(50) NOT NULL,
  `rand` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='采集临时表' AUTO_INCREMENT=136 ;

--
-- 转存表中的数据 `itemtxt`
--

INSERT INTO `itemtxt` (`id`, `iid`, `cid`, `title`, `pic_url`, `small_images`, `price`, `zk_price`, `provcity`, `item_url`, `volume`, `taobao_uid`, `taobao_uname`, `shop_url`, `shop_type`, `rand`) VALUES
(132, 521143489744, 2, '2015年春夏季新款休闲单鞋铆钉低跟平底坡跟浅口圆头软面女鞋子潮', 'http://img1.tbcdn.cn/tfscom/i1/TB1xn6OIVXXXXb1XFXXXXXXXXXX_!!0-item_pic.jpg', 'http://img1.tbcdn.cn/tfscom/i1/1918538255/TB2aFN8epXXXXXhXXXXXXXXXXXX_!!1918538255.jpg|br|http://img4.tbcdn.cn/tfscom/i3/1918538255/TB2Jv88epXXXXXdXXXXXXXXXXXX_!!1918538255.jpg|br|http://img2.tbcdn.cn/tfscom/i2/1918538255/TB27W4YepXXXXbFXXXXXXXXXXXX_!!191', 98.00, 39.00, '浙江 台州', 'http://item.taobao.com/item.htm?id=521143489744', 73, 1918538255, 'hygeia海吉亚旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=1918538255', 'tmall', 367),
(133, 16161648872, 2, '2015夏秋季低跟平底潮女鞋甜美蝴蝶结豆豆鞋浅口时尚休闲鞋女单鞋', 'http://img2.tbcdn.cn/tfscom/i1/TB1wIxDJXXXXXaIXFXXXXXXXXXX_!!0-item_pic.jpg', 'http://img3.tbcdn.cn/tfscom/i4/704084145/TB2BDqsdFXXXXXeXpXXXXXXXXXX_!!704084145.jpg|br|http://img4.tbcdn.cn/tfscom/i3/704084145/TB26EsKepXXXXXKXXXXXXXXXXXX_!!704084145.jpg|br|http://img3.tbcdn.cn/tfscom/i2/704084145/TB2XfwLepXXXXXGXXXXXXXXXXXX_!!70408414', 118.00, 45.00, '浙江 台州', 'http://item.taobao.com/item.htm?id=16161648872', 71, 704084145, '伊途旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=704084145', 'tmall', 400),
(134, 44363367432, 2, 'KTBG2015春商务精英新饰花漆皮单鞋中细跟低跟简约OL低帮尖头女鞋', 'http://img2.tbcdn.cn/tfscom/i3/TB1BiIlHpXXXXcaXFXXXXXXXXXX_!!0-item_pic.jpg', 'http://img3.tbcdn.cn/tfscom/i4/2106137334/TB26VYpcXXXXXaDXpXXXXXXXXXX_!!2106137334.jpg|br|http://img2.tbcdn.cn/tfscom/i3/2106137334/TB2vqHncXXXXXbmXpXXXXXXXXXX_!!2106137334.jpg|br|http://img4.tbcdn.cn/tfscom/i4/2106137334/TB2hvYxcXXXXXbRXXXXXXXXXXXX_!!210', 198.00, 39.00, '浙江 杭州', 'http://item.taobao.com/item.htm?id=44363367432', 81, 2106137334, 'ktbg旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=2106137334', 'tmall', 730),
(135, 521470997804, 2, 'KTBG2015新品韩版尖头低跟细跟甜美浅口蝴蝶结黑色优雅职业女单鞋', 'http://img4.tbcdn.cn/tfscom/i3/TB13TQpJXXXXXcgXXXXXXXXXXXX_!!0-item_pic.jpg', 'http://img3.tbcdn.cn/tfscom/i4/2106137334/TB2YmPJeFXXXXbBXpXXXXXXXXXX_!!2106137334.jpg|br|http://img1.tbcdn.cn/tfscom/i2/2106137334/TB2FEvIeFXXXXbVXpXXXXXXXXXX_!!2106137334.jpg|br|http://img1.tbcdn.cn/tfscom/i2/2106137334/TB2Gb2WeFXXXXcAXXXXXXXXXXXX_!!210', 158.00, 39.00, '浙江 台州', 'http://item.taobao.com/item.htm?id=521470997804', 2, 2106137334, 'ktbg旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=2106137334', 'tmall', 772);

-- --------------------------------------------------------

--
-- 表的结构 `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='标签库' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `tag`
--

INSERT INTO `tag` (`id`, `name`) VALUES
(1, 'T恤'),
(2, '长袖T恤'),
(3, '短袖T恤'),
(4, '韩版'),
(5, '单肩包');

-- --------------------------------------------------------

--
-- 表的结构 `tbshop`
--

CREATE TABLE IF NOT EXISTS `tbshop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL,
  `shop_url` varchar(255) NOT NULL,
  `shop_type` varchar(50) NOT NULL,
  `taobao_uname` varchar(50) NOT NULL,
  `taobao_uid` bigint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='taobao_shop' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `tbshop`
--

INSERT INTO `tbshop` (`id`, `logo`, `title`, `shop_url`, `shop_type`, `taobao_uname`, `taobao_uid`) VALUES
(1, 'http://logo.taobaocdn.com/shop-logo/ba/00/TB1OB.wHpXXXXb7XFXXSutbFXXX.jpg', '义兴源鞋类旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=786710037', 'tmall', '义兴源鞋类旗舰店', 786710037),
(2, 'http://logo.taobaocdn.com/shop-logo/38/59/TB1P5uNGXXXXXXPapXXSutbFXXX.jpg', 'kvoll旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=139649209', 'tmall', 'kvoll旗舰店', 139649209),
(3, 'http://logo.taobaocdn.com/shop-logo/37/1b/TB1HdE.IFXXXXabaXXXSutbFXXX.jpg', '伊途旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=704084145', 'tmall', '伊途旗舰店', 704084145),
(4, '/Public/tbshoppic/logo.jpg', '名典艺族旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=1919306328', 'tmall', '名典艺族旗舰店', 1919306328),
(5, 'http://logo.taobaocdn.com/shop-logo/8a/7a/T10XaLFqNkXXb1upjX.jpg', '爱丽旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=1971682217', 'tmall', '爱丽旗舰店', 1971682217),
(6, 'http://logo.taobaocdn.com/shop-logo/66/3f/TB1MezjFFXXXXbTaXXXwu0bFXXX.png', '燕语清秋旗舰店', 'http://store.taobao.com/shop/view_shop.htm?user_number_id=795569396', 'tmall', '燕语清秋旗舰店', 795569396);

-- --------------------------------------------------------

--
-- 表的结构 `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `seo_title` varchar(50) DEFAULT NULL,
  `seo_key` varchar(100) DEFAULT NULL,
  `seo_des` varchar(500) DEFAULT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='类别' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `type`
--

INSERT INTO `type` (`id`, `pid`, `name`, `tag`, `seo_title`, `seo_key`, `seo_des`, `add_time`) VALUES
(1, 0, '衣服', 'yifu', '女装-新款品牌女装,时尚精品女式服装,潮流服饰推荐', '女装,品牌女装,时尚服装，潮流服饰', '衣服是服饰搭配的时尚元素，我乐购精心挑选出了当季最流行的新款女装、名牌女装、品牌服饰、长袖连衣裙，精致搭配，尽显女士潮流风情，爱时尚就上我乐购！', 1438511947),
(2, 0, '鞋子', 'xiezi', '女鞋-新款品牌女鞋,时尚精品女式靴子,潮流鞋推荐', '女鞋,品牌女鞋,时尚靴子，潮流鞋', '鞋子是服饰搭配的时尚元素，我乐购精心挑选出了当季最流行的高跟鞋子、品牌鞋、时尚鞋、休闲鞋，精致搭配，尽显女士潮流风情，爱时尚就上我乐购！', 1438511977),
(3, 0, '包包', 'baobao', '包包-新款品牌女包,时尚精品女式包,潮流包包推荐', '包包,品牌女包,女式包，潮流包包', '包包是服饰搭配的时尚元素，我乐购精心挑选出了当季最流行的时尚女包、世界品牌女包、潮流女包、休闲女包，精致搭配，尽显女士潮流风情，爱时尚就上我乐购！', 1438512025),
(4, 0, '配饰', 'peishi', '配饰：水晶饰品、银饰品、时尚饰品、珠宝首饰-我乐购', '水晶饰品,饰品品牌,银饰品,时尚饰品,珠宝首饰', '配饰是服饰搭配的时尚元素，我乐购精心挑选出了当季最流行的水晶饰品、银饰品、时尚饰品、珠宝首饰，精致搭配，尽显女士潮流风情，爱时尚就上我乐购！', 1438512100),
(5, 0, '美妆', 'meizhuang', NULL, NULL, NULL, 1440325666),
(6, 0, '居家', 'jujia', '111', '222', '22222', 1440325826);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
