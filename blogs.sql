-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2019-01-07 17:41:27
-- 服务器版本： 5.5.60-log
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL COMMENT '后台帐号',
  `user` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `user`, `password`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e'),
(2, 'aaaaa', 'e10adc3949ba59abbe56e057f20f883e'),
(3, 'bbbbb', 'e10adc3949ba59abbe56e057f20f883e'),
(4, 'ccccc', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- 表的结构 `admin_role`
--

CREATE TABLE `admin_role` (
  `admin_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `admin_role`
--

INSERT INTO `admin_role` (`admin_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(3, 2);

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE `article` (
  `id` int(10) NOT NULL COMMENT '文章表',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `zan` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `img`, `time`, `zan`) VALUES
(1, '交代是不可能交代的', '这几天被朋友圈的“男友体”刷屏了，吃瓜群众硬是要跟风才感觉自己跟得上潮流吗？然而媒体却猫在一边看着热点流量刷刷刷变现，粉丝一边被卖了还一边帮别人数钱，That so naive，who tm care ！\r\n\r\n现在的明星的影响力足以影响国内娱乐圈的&quot;半壁江山&quot;，发条微博，新浪都恐慌好几天，来来来，蹭个热点给大家介绍一下我的女朋友。\r\n\r\n单身狗哪有女朋友，汪！汪！哈哈，（翻白眼）\r\n\r\n回来，几月不正经写 更新文，不会就这样吧啦几句就跑的，说回正事；当前 Yarn 也差不多使用了一年', '20181229/1c731783fc19dfaab808fa00bf1c1f26.png', '2018-08-10', 3),
(3, '状态', '这几天被朋友圈的“男友体”刷屏了，吃瓜群众硬是要跟风才感觉自己跟得上潮流吗？然而媒体却猫在一边看着热点流量刷刷刷变现，粉丝一边被卖了还一边帮别人数钱，That so naive，who tm care ！\r\n\r\n现在的明星的影响力足以影响国内娱乐圈的&quot;半壁江山&quot;，发条微博，新浪都恐慌好几天，来来来，蹭个热点给大家介绍一下我的女朋友。\r\n\r\n单身狗哪有女朋友，汪！汪！哈哈，（翻白眼）\r\n\r\n回来，几月不正经写 更新文，不会就这样吧啦几句就跑的，说回正事；当前 Yarn 也差不多使用了一年', '20181229/31fcc913e094f55c3884354514114ea0.png', '2018-12-21', 0);

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE `comment` (
  `id` int(10) NOT NULL COMMENT '评论表',
  `pid` int(10) NOT NULL COMMENT '文章id',
  `user_id` int(10) NOT NULL COMMENT '用户id',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`id`, `pid`, `user_id`, `content`, `time`) VALUES
(17, 3, 6, '88', '2019-01-02 09:34:50'),
(18, 1, 6, '6666666666666', '2019-01-02 09:37:05'),
(20, 1, 1, '99887765', '2019-01-02 15:58:39'),
(21, 1, 1, '123654', '2019-01-02 16:01:02'),
(26, 1, 1, '11', '2019-01-07 12:25:39'),
(27, 1, 1, '66', '2019-01-07 12:26:31'),
(28, 1, 1, '888888888888888', '2019-01-07 12:28:49');

-- --------------------------------------------------------

--
-- 表的结构 `link`
--

CREATE TABLE `link` (
  `id` int(10) NOT NULL COMMENT '友情链接表',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '名字',
  `img` varchar(100) NOT NULL COMMENT '头像',
  `url` varchar(100) NOT NULL COMMENT '跳转地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `link`
--

INSERT INTO `link` (`id`, `name`, `img`, `url`) VALUES
(10, 'Akina', '20181228/8efd4589e4a8b1ac062da483a8a62057.jpeg', 'www.baidu.com'),
(11, 'Dearzd', '20181229/24288d9ad82601052f10d3f638dc632f.jpeg', 'www.baidu.com'),
(12, 'Meow', '20181229/b45a7e52d25aad08200735d6d8ad262c.jpeg', 'www.baidu.com'),
(13, 'Tokin', '20181229/804d5121fd786809357421a8e64e20fd.jpeg', 'www.baidu.com');

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE `message` (
  `id` int(10) NOT NULL COMMENT '留言表',
  `user_id` int(10) NOT NULL COMMENT '用户id',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `message`
--

INSERT INTO `message` (`id`, `user_id`, `content`, `time`) VALUES
(5, 1, '99', '2019-01-02 10:52:56'),
(6, 1, '66', '2019-01-02 10:53:35'),
(8, 6, '66', '2019-01-04 16:35:23'),
(9, 6, '11', '2019-01-07 09:25:20'),
(17, 1, '33', '2019-01-07 13:16:38'),
(18, 1, '123', '2019-01-07 14:22:21'),
(21, 1, '999', '2019-01-07 14:31:09'),
(24, 1, '66', '2019-01-07 15:15:58'),
(25, 1, '44', '2019-01-07 16:01:10');

-- --------------------------------------------------------

--
-- 表的结构 `permission`
--

CREATE TABLE `permission` (
  `id` int(10) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `permission_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` int(20) NOT NULL COMMENT '0:菜单，1：其他',
  `ords` int(11) NOT NULL COMMENT '排序',
  `pid` int(11) NOT NULL COMMENT '二级菜单'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `permission`
--

INSERT INTO `permission` (`id`, `name`, `permission_name`, `type`, `ords`, `pid`) VALUES
(1, 'admin/index/index', '首页', 0, 1, 0),
(2, 'admin/article/article', '文章', 0, 2, 0),
(3, 'admin/article/add_article', '新增文章', 1, 0, 2),
(4, 'admin/article/edit_article', '编辑文章', 1, 1, 2),
(5, 'admin/article/delete_article', '删除文章', 1, 2, 2),
(6, 'admin/link/link', '链接', 0, 3, 0),
(7, 'admin/link/add_link', '新增链接', 1, 0, 6),
(8, 'admin/link/edit_link', '编辑链接', 1, 1, 6),
(9, 'admin/link/delete_link', '删除链接', 1, 2, 6),
(10, 'admin/version/version', '版本', 0, 4, 0),
(11, 'admin/version/add_version', '新增版本', 1, 0, 10),
(12, 'admin/version/delete_version', '删除版本', 1, 1, 10),
(13, 'admin/version/edit_version', '编辑版本', 1, 2, 10),
(14, 'admin/feedback/feedback', '留言', 0, 5, 0),
(15, 'admin/feedback/delete_feedback', '删除留言', 1, 0, 14),
(18, 'admin/user/user', '前台会员', 0, 6, 0),
(19, 'admin/user/delete_user', '删除会员', 1, 0, 18),
(20, 'admin/user/edit_user', '编辑会员', 1, 1, 18),
(21, 'admin/role/role', '角色', 0, 7, 0),
(22, 'admin/role/insert', '新增角色', 1, 1, 21),
(23, 'admin/role/edit', '编辑角色', 1, 2, 21),
(24, 'admin/role/delete', '删除角色', 1, 3, 21);

-- --------------------------------------------------------

--
-- 表的结构 `role`
--

CREATE TABLE `role` (
  `id` int(10) NOT NULL COMMENT '角色表',
  `role_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `role`
--

INSERT INTO `role` (`id`, `role_name`) VALUES
(1, '超级管理员'),
(2, '普通管理员'),
(3, '文章管理员'),
(5, 'xx');

-- --------------------------------------------------------

--
-- 表的结构 `role_permission`
--

CREATE TABLE `role_permission` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `role_permission`
--

INSERT INTO `role_permission` (`role_id`, `permission_id`) VALUES
(2, 1),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL COMMENT '前台会员表',
  `user` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pho` varchar(11) NOT NULL,
  `email` varchar(20) NOT NULL,
  `pwd` varchar(32) NOT NULL,
  `img` varchar(100) NOT NULL COMMENT '头像',
  `status` varchar(10) NOT NULL DEFAULT '0' COMMENT '0:启用;1：禁用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `user`, `sex`, `pho`, `email`, `pwd`, `img`, `status`) VALUES
(1, 'admin', '男', '15070935458', '1846052934@qq.com', 'e10adc3949ba59abbe56e057f20f883e', '20190107/38df3b492369ef4d2beea81b724beb4d.jpg', '0'),
(6, 'aaaaa', '男', '15070935459', '744638647@qq.com', 'e10adc3949ba59abbe56e057f20f883e', '20190104/2210a3e09959b9f00c35ec03d76d6b33.jpg', '0'),
(7, 'bbbbb', '男', '15070935663', '744699647@qq.com', 'e10adc3949ba59abbe56e057f20f883e', '20190104/2210a3e09959b9f00c35ec03d76d6b33.jpg', '0');

-- --------------------------------------------------------

--
-- 表的结构 `version`
--

CREATE TABLE `version` (
  `id` int(10) NOT NULL COMMENT '更新版本表',
  `pid` int(10) NOT NULL COMMENT '排序',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(20) NOT NULL COMMENT '时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `version`
--

INSERT INTO `version` (`id`, `pid`, `title`, `time`) VALUES
(3, 0, '版本正式更新至 3.7 ！', '2018-12-30'),
(4, 0, '修复站点 favicon 图标在非主页不显示的情况', ''),
(5, 0, '替换头部为jQuery粒子效果', '2018-12-25'),
(6, 0, ' 修复文章置顶图标在非动效环境下错位', ''),
(7, 0, '修复图像滤镜溢出情况', ''),
(8, 0, '优化主页的图像文章形式获取缩略图数量逻辑', '2018-12-15'),
(9, 0, ' 修复个别用户提及的伪静态下评论翻页失效状况', ''),
(10, 0, '修复主页图像文章“Pics”错位及底部微信二维码错位状况', '2018-11-23');

-- --------------------------------------------------------

--
-- 表的结构 `zan`
--

CREATE TABLE `zan` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `article_id` int(10) NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `zan`
--

INSERT INTO `zan` (`id`, `user_id`, `article_id`, `time`) VALUES
(23, 2, 1, '2019-01-04'),
(25, 4, 1, '2019-01-04'),
(26, 7, 1, '2019-01-07'),
(27, 7, 4, '2019-01-07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `link`
--
ALTER TABLE `link`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `version`
--
ALTER TABLE `version`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zan`
--
ALTER TABLE `zan`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '后台帐号', AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `article`
--
ALTER TABLE `article`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '文章表', AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '评论表', AUTO_INCREMENT=29;

--
-- 使用表AUTO_INCREMENT `link`
--
ALTER TABLE `link`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '友情链接表', AUTO_INCREMENT=14;

--
-- 使用表AUTO_INCREMENT `message`
--
ALTER TABLE `message`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '留言表', AUTO_INCREMENT=26;

--
-- 使用表AUTO_INCREMENT `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- 使用表AUTO_INCREMENT `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '角色表', AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '前台会员表', AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `version`
--
ALTER TABLE `version`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '更新版本表', AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `zan`
--
ALTER TABLE `zan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
