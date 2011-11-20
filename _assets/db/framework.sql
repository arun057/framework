-- MySQL dump 10.13  Distrib 5.5.14, for Linux (x86_64)
--
-- Host: localhost    Database: framework
-- ------------------------------------------------------
-- Server version	5.5.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `a3m_account`
--

DROP TABLE IF EXISTS `a3m_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `a3m_account` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(24) NOT NULL,
  `email` varchar(160) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  `createdon` datetime NOT NULL,
  `verifiedon` datetime DEFAULT NULL,
  `lastsignedinon` datetime DEFAULT NULL,
  `resetsenton` datetime DEFAULT NULL,
  `deletedon` datetime DEFAULT NULL,
  `suspendedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=10005 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a3m_account`
--

LOCK TABLES `a3m_account` WRITE;
/*!40000 ALTER TABLE `a3m_account` DISABLE KEYS */;
INSERT INTO `a3m_account` VALUES (1,'admin','cindy@fissionstrategy.com','935bda53552e49cd56fc00eea5a6702e','2011-11-02 17:01:07',NULL,'2011-11-20 10:53:19',NULL,NULL,NULL);
/*!40000 ALTER TABLE `a3m_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `a3m_account_details`
--

DROP TABLE IF EXISTS `a3m_account_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `a3m_account_details` (
  `account_id` bigint(20) unsigned NOT NULL,
  `fullname` varchar(160) DEFAULT NULL,
  `firstname` varchar(80) DEFAULT NULL,
  `lastname` varchar(80) DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `postalcode` varchar(40) DEFAULT NULL,
  `country` char(2) DEFAULT NULL,
  `language` char(2) DEFAULT NULL,
  `timezone` varchar(40) DEFAULT NULL,
  `picture` varchar(240) DEFAULT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a3m_account_details`
--

LOCK TABLES `a3m_account_details` WRITE;
/*!40000 ALTER TABLE `a3m_account_details` DISABLE KEYS */;
INSERT INTO `a3m_account_details` VALUES (1,NULL,'admin','Admin',NULL,NULL,NULL,NULL,'en',NULL,NULL);
/*!40000 ALTER TABLE `a3m_account_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `a3m_account_facebook`
--

DROP TABLE IF EXISTS `a3m_account_facebook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `a3m_account_facebook` (
  `account_id` bigint(20) NOT NULL,
  `facebook_id` bigint(20) NOT NULL,
  `linkedon` datetime NOT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `facebook_id` (`facebook_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a3m_account_facebook`
--

LOCK TABLES `a3m_account_facebook` WRITE;
/*!40000 ALTER TABLE `a3m_account_facebook` DISABLE KEYS */;
/*!40000 ALTER TABLE `a3m_account_facebook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `a3m_account_openid`
--

DROP TABLE IF EXISTS `a3m_account_openid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `a3m_account_openid` (
  `openid` varchar(240) NOT NULL,
  `account_id` bigint(20) unsigned NOT NULL,
  `linkedon` datetime NOT NULL,
  PRIMARY KEY (`openid`),
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a3m_account_openid`
--

LOCK TABLES `a3m_account_openid` WRITE;
/*!40000 ALTER TABLE `a3m_account_openid` DISABLE KEYS */;
/*!40000 ALTER TABLE `a3m_account_openid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `a3m_account_twitter`
--

DROP TABLE IF EXISTS `a3m_account_twitter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `a3m_account_twitter` (
  `account_id` bigint(20) NOT NULL,
  `twitter_id` bigint(20) NOT NULL,
  `oauth_token` varchar(80) NOT NULL,
  `oauth_token_secret` varchar(80) NOT NULL,
  `linkedon` datetime NOT NULL,
  PRIMARY KEY (`account_id`),
  KEY `twitter_id` (`twitter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a3m_account_twitter`
--

LOCK TABLES `a3m_account_twitter` WRITE;
/*!40000 ALTER TABLE `a3m_account_twitter` DISABLE KEYS */;
/*!40000 ALTER TABLE `a3m_account_twitter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_session`
--

DROP TABLE IF EXISTS `ci_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_session` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_session`
--

LOCK TABLES `ci_session` WRITE;
/*!40000 ALTER TABLE `ci_session` DISABLE KEYS */;
INSERT INTO `ci_session` VALUES ('cd413bdf243ef0f9dc71d0cf91dd202a','192.168.1.2','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.30',1321805650,'a:1:{s:10:\"account_id\";s:1:\"1\";}');
/*!40000 ALTER TABLE `ci_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_answers`
--

DROP TABLE IF EXISTS `fs_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` int(11) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_answers`
--

LOCK TABLES `fs_answers` WRITE;
/*!40000 ALTER TABLE `fs_answers` DISABLE KEYS */;
INSERT INTO `fs_answers` VALUES (23,5,'sdfagsdfg','2011-06-22 10:33:02',0);
/*!40000 ALTER TABLE `fs_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_block`
--

DROP TABLE IF EXISTS `fs_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_block` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `block_content` text NOT NULL,
  `block_type` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_block`
--

LOCK TABLES `fs_block` WRITE;
/*!40000 ALTER TABLE `fs_block` DISABLE KEYS */;
INSERT INTO `fs_block` VALUES (4,'Donate','Donate','<article class=\"action-a\">\n	<h3>\n		Donate</h3>\n	<div class=\"content\">\n		<p class=\"left\">\n			<img alt=\"Donate\" src=\"/uploads/images/Block_Donate.jpg\" style=\"margin: 2px; float: left; width: 125px; height: 125px;\" /></p>\n		<p>\n			Make a difference. Give today.</p>\n		<a class=\"button-a\" href=\"/giving/donate\">Donate</a></div>\n	</article>','page_block'),(35,'sidebarblock','sidebar block','<div class=\"widget-a\">\n	<h4>\n		Title goes here</h4>\n	<p>\n		Blurb goes here</p>\n	<p class=\"buttons\">\n		<a class=\"button-a\" href=\"./\">Button Text</a></p>\n</div>\n','sidebar_block');
/*!40000 ALTER TABLE `fs_block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_blog`
--

DROP TABLE IF EXISTS `fs_blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_blog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content` longtext NOT NULL,
  `title` text NOT NULL,
  `excerpt` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content_filtered` text NOT NULL,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  `thumb` varchar(256) NOT NULL,
  `image` varchar(256) NOT NULL,
  `quote` varchar(512) NOT NULL,
  `order` int(11) NOT NULL,
  `new` int(11) NOT NULL,
  `url` varchar(256) NOT NULL,
  `publish_on` datetime DEFAULT NULL,
  `unpublish_on` datetime DEFAULT NULL,
  `sticky` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `post_name` (`name`),
  KEY `type_status_date` (`status`,`date`,`id`),
  KEY `post_parent` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=733 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_blog`
--

LOCK TABLES `fs_blog` WRITE;
/*!40000 ALTER TABLE `fs_blog` DISABLE KEYS */;
INSERT INTO `fs_blog` VALUES (625,10001,'0000-00-00 00:00:00','','If You Have a Question for Nancy Pelosi, Just Ask! asdfadsf','','','open','open','','','','0000-00-00 00:00:00','',1,'',0,'','','',0,0,'',NULL,NULL,0),(732,1,'2011-11-20 11:13:00','<p>\n	Blog content goes here, styled with the base site styling.css</p>\n<p>\n	&nbsp;</p>\n','This is a blog','and this is teh excerpt','draft','open','open','this-is-a-blog','','','2011-11-20 11:13:00','',0,'',0,'','','',0,0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0);
/*!40000 ALTER TABLE `fs_blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_blog_categories`
--

DROP TABLE IF EXISTS `fs_blog_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_blog_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `monthly_theme_date` date NOT NULL DEFAULT '0000-00-00',
  `cat_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_blog_categories`
--

LOCK TABLES `fs_blog_categories` WRITE;
/*!40000 ALTER TABLE `fs_blog_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_blog_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_blog_category_map`
--

DROP TABLE IF EXISTS `fs_blog_category_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_blog_category_map` (
  `blog_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_blog_category_map`
--

LOCK TABLES `fs_blog_category_map` WRITE;
/*!40000 ALTER TABLE `fs_blog_category_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_blog_category_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_blog_comments`
--

DROP TABLE IF EXISTS `fs_blog_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_blog_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_blog_comments`
--

LOCK TABLES `fs_blog_comments` WRITE;
/*!40000 ALTER TABLE `fs_blog_comments` DISABLE KEYS */;
INSERT INTO `fs_blog_comments` VALUES (1,672,0,'teset comment','2011-06-14 22:03:01',1),(2,672,0,'','2011-06-15 12:43:30',1),(3,672,0,'ffffffffffffffffffff','2011-06-15 12:44:50',1),(4,672,0,'ffffffffffffffffffff','2011-06-15 12:49:03',1),(5,672,0,'this is another comment given by me','2011-06-15 13:02:32',1),(6,672,0,'and yet another','2011-06-15 13:02:41',1),(7,672,0,'and yet another','2011-06-15 13:04:11',1),(8,672,0,'now save this comment','2011-06-15 13:10:42',1),(9,612,0,'This is a comment','2011-07-07 22:46:54',1),(10,612,0,'This is a comment','2011-07-07 22:47:43',1),(11,612,0,'This is a comment','2011-07-07 22:48:02',1);
/*!40000 ALTER TABLE `fs_blog_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_blog_tag_map`
--

DROP TABLE IF EXISTS `fs_blog_tag_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_blog_tag_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_id` (`blog_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_blog_tag_map`
--

LOCK TABLES `fs_blog_tag_map` WRITE;
/*!40000 ALTER TABLE `fs_blog_tag_map` DISABLE KEYS */;
INSERT INTO `fs_blog_tag_map` VALUES (1,732,1);
/*!40000 ALTER TABLE `fs_blog_tag_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_blog_tags`
--

DROP TABLE IF EXISTS `fs_blog_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_blog_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(128) NOT NULL,
  `order` int(11) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_blog_tags`
--

LOCK TABLES `fs_blog_tags` WRITE;
/*!40000 ALTER TABLE `fs_blog_tags` DISABLE KEYS */;
INSERT INTO `fs_blog_tags` VALUES (1,'fancy tag',0,'2011-06-12 15:31:29');
/*!40000 ALTER TABLE `fs_blog_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_comments`
--

DROP TABLE IF EXISTS `fs_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `asset_type` varchar(64) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `comment` text,
  `visible` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `_asset_id_and_type` (`asset_id`,`asset_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_comments`
--

LOCK TABLES `fs_comments` WRITE;
/*!40000 ALTER TABLE `fs_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_events`
--

DROP TABLE IF EXISTS `fs_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `repeat` int(11) NOT NULL DEFAULT '0',
  `title` text NOT NULL,
  `description` varchar(2048) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_events`
--

LOCK TABLES `fs_events` WRITE;
/*!40000 ALTER TABLE `fs_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_features`
--

DROP TABLE IF EXISTS `fs_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feature_type` varchar(32) NOT NULL,
  `status` varchar(64) NOT NULL,
  `title` varchar(258) NOT NULL,
  `long_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `f_order` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` int(11) NOT NULL,
  `link` varchar(1024) NOT NULL DEFAULT '',
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_features`
--

LOCK TABLES `fs_features` WRITE;
/*!40000 ALTER TABLE `fs_features` DISABLE KEYS */;
INSERT INTO `fs_features` VALUES (6,'homepage','publish','the title of this feature goes here','','','gratitude.jpg',1,'2011-08-17 20:12:00',0,'new link needs to go here');
/*!40000 ALTER TABLE `fs_features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_form`
--

DROP TABLE IF EXISTS `fs_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `form_json` text COLLATE utf8_unicode_ci NOT NULL,
  `is_emailed` tinyint(4) NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_form`
--

LOCK TABLES `fs_form` WRITE;
/*!40000 ALTER TABLE `fs_form` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_form_type`
--

DROP TABLE IF EXISTS `fs_form_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_form_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `form_key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thanks_message` text COLLATE utf8_unicode_ci NOT NULL,
  `form_fields` text COLLATE utf8_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_form_type`
--

LOCK TABLES `fs_form_type` WRITE;
/*!40000 ALTER TABLE `fs_form_type` DISABLE KEYS */;
INSERT INTO `fs_form_type` VALUES (1,'','ConatctUS','cindy@fissionstrategy.com','<p>\n	Thank you for contacting us, we will get back to you shortly.</p>\n','','2011-11-20 16:14:50');
/*!40000 ALTER TABLE `fs_form_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_links`
--

DROP TABLE IF EXISTS `fs_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_links` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `target` varchar(25) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `visible` varchar(20) NOT NULL DEFAULT 'Y',
  `owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `rating` int(11) NOT NULL DEFAULT '0',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `rel` varchar(255) NOT NULL DEFAULT '',
  `notes` mediumtext NOT NULL,
  `rss` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `link_visible` (`visible`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_links`
--

LOCK TABLES `fs_links` WRITE;
/*!40000 ALTER TABLE `fs_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_navigation`
--

DROP TABLE IF EXISTS `fs_navigation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_navigation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nav_type` varchar(32) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `nav_order` smallint(6) NOT NULL,
  `name` varchar(64) NOT NULL,
  `url` varchar(256) NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_navigation`
--

LOCK TABLES `fs_navigation` WRITE;
/*!40000 ALTER TABLE `fs_navigation` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_navigation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_page`
--

DROP TABLE IF EXISTS `fs_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_page` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content` longtext NOT NULL,
  `title` text NOT NULL,
  `excerpt` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'publish',
  `name` varchar(200) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL,
  `new` int(11) NOT NULL,
  `url` varchar(256) NOT NULL,
  `menu` varchar(128) NOT NULL,
  `video` varchar(128) NOT NULL,
  `content_source` varchar(128) NOT NULL,
  `monthly_theme_year` varchar(255) NOT NULL,
  `monthly_theme_month` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `large_image` varchar(255) NOT NULL,
  `allow_comments` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `post_name` (`name`),
  KEY `type_status_date` (`status`,`date`,`id`),
  KEY `post_parent` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_page`
--

LOCK TABLES `fs_page` WRITE;
/*!40000 ALTER TABLE `fs_page` DISABLE KEYS */;
INSERT INTO `fs_page` VALUES (1,0,'0000-00-00 00:00:00','<p>\n	Page content goes here styled with base website styling.</p>\n','This is a page','','publish','this-is-a-page','0000-00-00 00:00:00',0,0,0,'','','','','','','','',0);
/*!40000 ALTER TABLE `fs_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_page_block_map`
--

DROP TABLE IF EXISTS `fs_page_block_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_page_block_map` (
  `page_id` int(11) NOT NULL,
  `block_name` varchar(255) NOT NULL,
  `block_order` int(40) NOT NULL,
  `block_type` varchar(64) NOT NULL,
  PRIMARY KEY (`page_id`,`block_name`,`block_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_page_block_map`
--

LOCK TABLES `fs_page_block_map` WRITE;
/*!40000 ALTER TABLE `fs_page_block_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_page_block_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_page_category_map`
--

DROP TABLE IF EXISTS `fs_page_category_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_page_category_map` (
  `page_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`page_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_page_category_map`
--

LOCK TABLES `fs_page_category_map` WRITE;
/*!40000 ALTER TABLE `fs_page_category_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_page_category_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_page_type`
--

DROP TABLE IF EXISTS `fs_page_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_page_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(1024) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_page_type`
--

LOCK TABLES `fs_page_type` WRITE;
/*!40000 ALTER TABLE `fs_page_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_page_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_questions`
--

DROP TABLE IF EXISTS `fs_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` int(11) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_questions`
--

LOCK TABLES `fs_questions` WRITE;
/*!40000 ALTER TABLE `fs_questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_share_counts`
--

DROP TABLE IF EXISTS `fs_share_counts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_share_counts` (
  `share_type` varchar(64) NOT NULL,
  `url` varchar(1024) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_share_counts`
--

LOCK TABLES `fs_share_counts` WRITE;
/*!40000 ALTER TABLE `fs_share_counts` DISABLE KEYS */;
INSERT INTO `fs_share_counts` VALUES ('twitter','http://framework/',0,'2011-11-20 16:11:53');
/*!40000 ALTER TABLE `fs_share_counts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_signups`
--

DROP TABLE IF EXISTS `fs_signups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_signups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `zip` varchar(32) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_signups`
--

LOCK TABLES `fs_signups` WRITE;
/*!40000 ALTER TABLE `fs_signups` DISABLE KEYS */;
INSERT INTO `fs_signups` VALUES (2,'Cindy','Mottershead','cindy@mottershead.us','01741','2011-06-22 13:23:31');
/*!40000 ALTER TABLE `fs_signups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_story`
--

DROP TABLE IF EXISTS `fs_story`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_story` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` date DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(255) NOT NULL,
  `url` varchar(132) NOT NULL,
  `status` int(11) NOT NULL,
  `field_isfeature_value` longtext,
  `topic_id` int(11) DEFAULT NULL,
  `cell` varchar(16) NOT NULL DEFAULT '',
  `email` varchar(200) NOT NULL,
  `city` varchar(80) NOT NULL,
  `state` longtext NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `zip` varchar(12) NOT NULL,
  `story_body` longtext NOT NULL,
  `smallbusiness` longtext NOT NULL,
  `share_media_ok` varchar(6) NOT NULL,
  `anonymous` varchar(20) NOT NULL,
  `excerpt` longtext NOT NULL,
  `video` text NOT NULL,
  `photos` text NOT NULL,
  `audio` text NOT NULL,
  `tags` varchar(255) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `secret` varchar(16) NOT NULL,
  `story_type` int(11) NOT NULL DEFAULT '0',
  `sticky` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_story`
--

LOCK TABLES `fs_story` WRITE;
/*!40000 ALTER TABLE `fs_story` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_story` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_story_collection`
--

DROP TABLE IF EXISTS `fs_story_collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_story_collection` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `action_kit_id` varchar(64) NOT NULL,
  `ask` longtext NOT NULL,
  `user_fields` longtext NOT NULL,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `topic_id` int(11) NOT NULL,
  `campaigners_email` text NOT NULL,
  `show_map` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nid` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_story_collection`
--

LOCK TABLES `fs_story_collection` WRITE;
/*!40000 ALTER TABLE `fs_story_collection` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_story_collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_story_tags`
--

DROP TABLE IF EXISTS `fs_story_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_story_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `collection` varchar(32) NOT NULL,
  `name` text NOT NULL,
  `term_id` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_story_tags`
--

LOCK TABLES `fs_story_tags` WRITE;
/*!40000 ALTER TABLE `fs_story_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_story_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_story_topic`
--

DROP TABLE IF EXISTS `fs_story_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_story_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term_id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `url_name` varchar(256) NOT NULL,
  `show` int(11) DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_story_topic`
--

LOCK TABLES `fs_story_topic` WRITE;
/*!40000 ALTER TABLE `fs_story_topic` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_story_topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_user`
--

DROP TABLE IF EXISTS `fs_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_user` (
  `user_id` int(11) NOT NULL,
  `permission` varchar(16) NOT NULL,
  `admin_state` varchar(4) NOT NULL,
  `admin_topic` int(11) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_user`
--

LOCK TABLES `fs_user` WRITE;
/*!40000 ALTER TABLE `fs_user` DISABLE KEYS */;
INSERT INTO `fs_user` VALUES (1,'SUPER','',0,'2011-05-10 16:04:29');
/*!40000 ALTER TABLE `fs_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fs_zipcodes`
--

DROP TABLE IF EXISTS `fs_zipcodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fs_zipcodes` (
  `zip` varchar(16) NOT NULL DEFAULT '0',
  `city` varchar(30) NOT NULL DEFAULT '',
  `state` varchar(30) NOT NULL DEFAULT '',
  `latitude` decimal(10,6) NOT NULL DEFAULT '0.000000',
  `longitude` decimal(10,6) NOT NULL DEFAULT '0.000000',
  `timezone` tinyint(4) NOT NULL DEFAULT '0',
  `dst` tinyint(4) NOT NULL DEFAULT '0',
  `country` char(2) DEFAULT '',
  KEY `pc` (`country`,`zip`),
  KEY `zip` (`zip`),
  KEY `latitude` (`latitude`),
  KEY `longitude` (`longitude`),
  KEY `country` (`country`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fs_zipcodes`
--

LOCK TABLES `fs_zipcodes` WRITE;
/*!40000 ALTER TABLE `fs_zipcodes` DISABLE KEYS */;
/*!40000 ALTER TABLE `fs_zipcodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_country`
--

DROP TABLE IF EXISTS `ref_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_country` (
  `alpha2` char(2) NOT NULL,
  `alpha3` char(3) NOT NULL,
  `numeric` varchar(3) NOT NULL,
  `country` varchar(80) NOT NULL,
  PRIMARY KEY (`alpha2`),
  UNIQUE KEY `alpha3` (`alpha3`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_country`
--

LOCK TABLES `ref_country` WRITE;
/*!40000 ALTER TABLE `ref_country` DISABLE KEYS */;
INSERT INTO `ref_country` VALUES ('ao','ago','024','Angola'),('ai','aia','660','Anguilla'),('aq','ata','010','Antarctica'),('ag','atg','028','Antigua and Barbuda'),('ar','arg','032','Argentina'),('am','arm','051','Armenia'),('aw','abw','533','Aruba'),('au','aus','036','Australia'),('at','aut','040','Austria'),('az','aze','031','Azerbaijan'),('bs','bhs','044','Bahamas'),('bh','bhr','048','Bahrain'),('bd','bgd','050','Bangladesh'),('bb','brb','052','Barbados'),('by','blr','112','Belarus'),('be','bel','056','Belgium'),('bz','blz','084','Belize'),('bj','ben','204','Benin'),('bm','bmu','060','Bermuda'),('bt','btn','064','Bhutan'),('bo','bol','068','Bolivia, Plurinational State of'),('ba','bih','070','Bosnia and Herzegovina'),('bw','bwa','072','Botswana'),('bv','bvt','074','Bouvet Island'),('br','bra','076','Brazil'),('io','iot','086','British Indian Ocean Territory'),('bn','brn','096','Brunei Darussalam'),('bg','bgr','100','Bulgaria'),('bf','bfa','854','Burkina Faso'),('bi','bdi','108','Burundi'),('kh','khm','116','Cambodia'),('cm','cmr','120','Cameroon'),('ca','can','124','Canada'),('cv','cpv','132','Cape Verde'),('ky','cym','136','Cayman Islands'),('cf','caf','140','Central African Republic'),('td','tcd','148','Chad'),('cl','chl','152','Chile'),('cn','chn','156','China'),('cx','cxr','162','Christmas Island'),('cc','cck','166','Cocos (Keeling) Islands'),('co','col','170','Colombia'),('km','com','174','Comoros'),('cg','cog','178','Congo'),('cd','cod','180','Congo, the Democratic Republic of the'),('ck','cok','184','Cook Islands'),('cr','cri','188','Costa Rica'),('ci','civ','384','Côte d\'Ivoire'),('hr','hrv','191','Croatia'),('cu','cub','192','Cuba'),('cy','cyp','196','Cyprus'),('cz','cze','203','Czech Republic'),('dk','dnk','208','Denmark'),('dj','dji','262','Djibouti'),('dm','dma','212','Dominica'),('do','dom','214','Dominican Republic'),('ec','ecu','218','Ecuador'),('eg','egy','818','Egypt'),('sv','slv','222','El Salvador'),('gq','gnq','226','Equatorial Guinea'),('er','eri','232','Eritrea'),('ee','est','233','Estonia'),('et','eth','231','Ethiopia'),('fk','flk','238','Falkland Islands (Malvinas)'),('fo','fro','234','Faroe Islands'),('fj','fji','242','Fiji'),('fi','fin','246','Finland'),('fr','fra','250','France'),('gf','guf','254','French Guiana'),('pf','pyf','258','French Polynesia'),('tf','atf','260','French Southern Territories'),('ga','gab','266','Gabon'),('gm','gmb','270','Gambia'),('ge','geo','268','Georgia'),('de','deu','276','Germany'),('gh','gha','288','Ghana'),('gi','gib','292','Gibraltar'),('gr','grc','300','Greece'),('gl','grl','304','Greenland'),('gd','grd','308','Grenada'),('gp','glp','312','Guadeloupe'),('gu','gum','316','Guam'),('gt','gtm','320','Guatemala'),('gg','ggy','831','Guernsey'),('gn','gin','324','Guinea'),('gw','gnb','624','Guinea-Bissau'),('gy','guy','328','Guyana'),('ht','hti','332','Haiti'),('hm','hmd','334','Heard Island and McDonald Islands'),('va','vat','336','Holy See (Vatican City State)'),('hn','hnd','340','Honduras'),('hk','hkg','344','Hong Kong'),('hu','hun','348','Hungary'),('is','isl','352','Iceland'),('in','ind','356','India'),('id','idn','360','Indonesia'),('ir','irn','364','Iran, Islamic Republic of'),('iq','irq','368','Iraq'),('ie','irl','372','Ireland'),('im','imn','833','Isle of Man'),('il','isr','376','Israel'),('it','ita','380','Italy'),('jm','jam','388','Jamaica'),('jp','jpn','392','Japan'),('je','jey','832','Jersey'),('jo','jor','400','Jordan'),('kz','kaz','398','Kazakhstan'),('ke','ken','404','Kenya'),('ki','kir','296','Kiribati'),('kp','prk','408','Korea, Democratic People\'s Republic of'),('kr','kor','410','Korea, Republic of'),('kw','kwt','414','Kuwait'),('kg','kgz','417','Kyrgyzstan'),('la','lao','418','Lao People\'s Democratic Republic'),('lv','lva','428','Latvia'),('lb','lbn','422','Lebanon'),('ls','lso','426','Lesotho'),('lr','lbr','430','Liberia'),('ly','lby','434','Libyan Arab Jamahiriya'),('li','lie','438','Liechtenstein'),('lt','ltu','440','Lithuania'),('lu','lux','442','Luxembourg'),('mo','mac','446','Macao'),('mk','mkd','807','Macedonia, the former Yugoslav Republic of'),('mg','mdg','450','Madagascar'),('mw','mwi','454','Malawi'),('my','mys','458','Malaysia'),('mv','mdv','462','Maldives'),('ml','mli','466','Mali'),('mt','mlt','470','Malta'),('mh','mhl','584','Marshall Islands'),('mq','mtq','474','Martinique'),('mr','mrt','478','Mauritania'),('mu','mus','480','Mauritius'),('yt','myt','175','Mayotte'),('mx','mex','484','Mexico'),('fm','fsm','583','Micronesia, Federated States of'),('md','mda','498','Moldova, Republic of'),('mc','mco','492','Monaco'),('mn','mng','496','Mongolia'),('me','mne','499','Montenegro'),('ms','msr','500','Montserrat'),('ma','mar','504','Morocco'),('mz','moz','508','Mozambique'),('mm','mmr','104','Myanmar'),('na','nam','516','Namibia'),('nr','nru','520','Nauru'),('np','npl','524','Nepal'),('nl','nld','528','Netherlands'),('an','ant','530','Netherlands Antilles'),('nc','ncl','540','New Caledonia'),('nz','nzl','554','New Zealand'),('ni','nic','558','Nicaragua'),('ne','ner','562','Niger'),('ng','nga','566','Nigeria'),('nu','niu','570','Niue'),('nf','nfk','574','Norfolk Island'),('mp','mnp','580','Northern Mariana Islands'),('no','nor','578','Norway'),('om','omn','512','Oman'),('pk','pak','586','Pakistan'),('pw','plw','585','Palau'),('ps','pse','275','Palestinian Territory, Occupied'),('pa','pan','591','Panama'),('pg','png','598','Papua New Guinea'),('py','pry','600','Paraguay'),('pe','per','604','Peru'),('ph','phl','608','Philippines'),('pn','pcn','612','Pitcairn'),('pl','pol','616','Poland'),('pt','prt','620','Portugal'),('pr','pri','630','Puerto Rico'),('qa','qat','634','Qatar'),('re','reu','638','Réunion'),('ro','rou','642','Romania'),('ru','rus','643','Russian Federation'),('rw','rwa','646','Rwanda'),('bl','blm','652','Saint Barthélemy'),('sh','shn','654','Saint Helena'),('kn','kna','659','Saint Kitts and Nevis'),('lc','lca','662','Saint Lucia'),('mf','maf','663','Saint Martin (French part)'),('pm','spm','666','Saint Pierre and Miquelon'),('vc','vct','670','Saint Vincent and the Grenadines'),('ws','wsm','882','Samoa'),('sm','smr','674','San Marino'),('st','stp','678','Sao Tome and Principe'),('sa','sau','682','Saudi Arabia'),('sn','sen','686','Senegal'),('rs','srb','688','Serbia'),('sc','syc','690','Seychelles'),('sl','sle','694','Sierra Leone'),('sg','sgp','702','Singapore'),('sk','svk','703','Slovakia'),('si','svn','705','Slovenia'),('sb','slb','090','Solomon Islands'),('so','som','706','Somalia'),('za','zaf','710','South Africa'),('gs','sgs','239','South Georgia and the South Sandwich Islands'),('es','esp','724','Spain'),('lk','lka','144','Sri Lanka'),('sd','sdn','736','Sudan'),('sr','sur','740','Suriname'),('sj','sjm','744','Svalbard and Jan Mayen'),('sz','swz','748','Swaziland'),('se','swe','752','Sweden'),('ch','che','756','Switzerland'),('sy','syr','760','Syrian Arab Republic'),('tw','twn','158','Taiwan, Province of China'),('tj','tjk','762','Tajikistan'),('tz','tza','834','Tanzania, United Republic of'),('th','tha','764','Thailand'),('tl','tls','626','Timor-Leste'),('tg','tgo','768','Togo'),('tk','tkl','772','Tokelau'),('to','ton','776','Tonga'),('tt','tto','780','Trinidad and Tobago'),('tn','tun','788','Tunisia'),('tr','tur','792','Turkey'),('tm','tkm','795','Turkmenistan'),('tc','tca','796','Turks and Caicos Islands'),('tv','tuv','798','Tuvalu'),('ug','uga','800','Uganda'),('ua','ukr','804','Ukraine'),('ae','are','784','United Arab Emirates'),('gb','gbr','826','United Kingdom'),('us','usa','840','United States'),('um','umi','581','United States Minor Outlying Islands'),('uy','ury','858','Uruguay'),('uz','uzb','860','Uzbekistan'),('vu','vut','548','Vanuatu'),('ve','ven','862','Venezuela, Bolivarian Republic of'),('vn','vnm','704','Viet Nam'),('vg','vgb','092','Virgin Islands, British'),('vi','vir','850','Virgin Islands, U.S.'),('wf','wlf','876','Wallis and Futuna'),('eh','esh','732','Western Sahara'),('ye','yem','887','Yemen'),('zm','zmb','894','Zambia'),('zw','zwe','716','Zimbabwe'),('af','afg','004','Afghanistan'),('ax','ala','248','Åland Islands'),('al','alb','008','Albania'),('dz','dza','012','Algeria'),('as','asm','016','American Samoa'),('ad','and','020','Andorra');
/*!40000 ALTER TABLE `ref_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_currency`
--

DROP TABLE IF EXISTS `ref_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_currency` (
  `alpha` char(3) NOT NULL,
  `numeric` varchar(3) DEFAULT NULL,
  `currency` varchar(80) NOT NULL,
  PRIMARY KEY (`alpha`),
  KEY `numeric` (`numeric`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_currency`
--

LOCK TABLES `ref_currency` WRITE;
/*!40000 ALTER TABLE `ref_currency` DISABLE KEYS */;
INSERT INTO `ref_currency` VALUES ('AFN','971','Afghani'),('DZD','12','Algerian Dinar'),('ARS','32','Argentine Peso'),('AMD','51','Armenian Dram'),('AWG','533','Aruban Guilder'),('AUD','36','Australian Dollar'),('AZN','944','Azerbaijanian Manat'),('BSD','44','Bahamian Dollar'),('BHD','48','Bahraini Dinar'),('THB','764','Baht'),('PAB','590','Balboa'),('BBD','52','Barbados Dollar'),('BYR','974','Belarussian Ruble'),('BZD','84','Belize Dollar'),('BMD','60','Bermudian Dollar (customarily known as Bermuda Dollar)'),('VEF','937','Bolivar Fuerte'),('BOB','68','Boliviano'),('XBA','955','Bond Markets Units European Composite Unit (EURCO)'),('BRL','986','Brazilian Real'),('BND','96','Brunei Dollar'),('BGN','975','Bulgarian Lev'),('BIF','108','Burundi Franc'),('CAD','124','Canadian Dollar'),('CVE','132','Cape Verde Escudo'),('KYD','136','Cayman Islands Dollar'),('GHS','936','Cedi'),('XOF','952','CFA Franc BCEAO'),('XAF','950','CFA Franc BEAC'),('XPF','953','CFP Franc'),('CLP','152','Chilean Peso'),('XTS','963','Codes specifically reserved for testing purposes'),('COP','170','Colombian Peso'),('KMF','174','Comoro Franc'),('CDF','976','Congolese Franc'),('BAM','977','Convertible Marks'),('NIO','558','Cordoba Oro'),('CRC','188','Costa Rican Colon'),('HRK','191','Croatian Kuna'),('CUP','192','Cuban Peso'),('CZK','203','Czech Koruna'),('GMD','270','Dalasi'),('DKK','208','Danish Krone'),('MKD','807','Denar'),('DJF','262','Djibouti Franc'),('STD','678','Dobra'),('DOP','214','Dominican Peso'),('VND','704','Dong'),('XCD','951','East Caribbean Dollar'),('EGP','818','Egyptian Pound'),('SVC','222','El Salvador Colon'),('ETB','230','Ethiopian Birr'),('EUR','978','Euro'),('XBB','956','European Monetary Unit (E.M.U.-6)'),('XBD','958','European Unit of Account 17 (E.U.A.-17)'),('XBC','957','European Unit of Account 9 (E.U.A.-9)'),('FKP','238','Falkland Islands Pound'),('FJD','242','Fiji Dollar'),('HUF','348','Forint'),('GIP','292','Gibraltar Pound'),('XAU','959','Gold'),('HTG','332','Gourde'),('PYG','600','Guarani'),('GNF','324','Guinea Franc'),('GWP','624','Guinea-Bissau Peso'),('GYD','328','Guyana Dollar'),('HKD','344','Hong Kong Dollar'),('UAH','980','Hryvnia'),('ISK','352','Iceland Krona'),('INR','356','Indian Rupee'),('IRR','364','Iranian Rial'),('IQD','368','Iraqi Dinar'),('JMD','388','Jamaican Dollar'),('JOD','400','Jordanian Dinar'),('KES','404','Kenyan Shilling'),('PGK','598','Kina'),('LAK','418','Kip'),('EEK','233','Kroon'),('KWD','414','Kuwaiti Dinar'),('MWK','454','Kwacha'),('AOA','973','Kwanza'),('MMK','104','Kyat'),('GEL','981','Lari'),('LVL','428','Latvian Lats'),('LBP','422','Lebanese Pound'),('ALL','8','Lek'),('HNL','340','Lempira'),('SLL','694','Leone'),('LRD','430','Liberian Dollar'),('LYD','434','Libyan Dinar'),('SZL','748','Lilangeni'),('LTL','440','Lithuanian Litas'),('LSL','426','Loti'),('MGA','969','Malagasy Ariary'),('MYR','458','Malaysian Ringgit'),('TMT','934','Manat'),('MUR','480','Mauritius Rupee'),('MZN','943','Metical'),('MXN','484','Mexican Peso'),('MXV','979','Mexican Unidad de Inversion (UDI)'),('MDL','498','Moldovan Leu'),('MAD','504','Moroccan Dirham'),('BOV','984','Mvdol'),('NGN','566','Naira'),('ERN','232','Nakfa'),('NAD','516','Namibia Dollar'),('NPR','524','Nepalese Rupee'),('ANG','532','Netherlands Antillian Guilder'),('ILS','376','New Israeli Sheqel'),('RON','946','New Leu'),('TWD','901','New Taiwan Dollar'),('NZD','554','New Zealand Dollar'),('BTN','64','Ngultrum'),('KPW','408','North Korean Won'),('NOK','578','Norwegian Krone'),('PEN','604','Nuevo Sol'),('MRO','478','Ouguiya'),('TOP','776','Pa\'anga'),('PKR','586','Pakistan Rupee'),('XPD','964','Palladium'),('MOP','446','Pataca'),('CUC','931','Peso Convertible'),('UYU','858','Peso Uruguayo'),('PHP','608','Philippine Peso'),('XPT','962','Platinum'),('GBP','826','Pound Sterling'),('BWP','72','Pula'),('QAR','634','Qatari Rial'),('GTQ','320','Quetzal'),('ZAR','710','Rand'),('OMR','512','Rial Omani'),('KHR','116','Riel'),('MVR','462','Rufiyaa'),('IDR','360','Rupiah'),('RUB','643','Russian Ruble'),('RWF','646','Rwanda Franc'),('SHP','654','Saint Helena Pound'),('SAR','682','Saudi Riyal'),('XDR','960','SDR'),('RSD','941','Serbian Dinar'),('SCR','690','Seychelles Rupee'),('XAG','961','Silver'),('SGD','702','Singapore Dollar'),('SBD','90','Solomon Islands Dollar'),('KGS','417','Som'),('SOS','706','Somali Shilling'),('TJS','972','Somoni'),('LKR','144','Sri Lanka Rupee'),('SDG','938','Sudanese Pound'),('SRD','968','Surinam Dollar'),('SEK','752','Swedish Krona'),('CHF','756','Swiss Franc'),('SYP','760','Syrian Pound'),('BDT','50','Taka'),('WST','882','Tala'),('TZS','834','Tanzanian Shilling'),('KZT','398','Tenge'),('XXX','999','Codes assigned for transactions where no currency is involved'),('TTD','780','Trinidad and Tobago Dollar'),('MNT','496','Tugrik'),('TND','788','Tunisian Dinar'),('TRY','949','Turkish Lira'),('AED','784','UAE Dirham'),('UGX','800','Uganda Shilling'),('XFU',NULL,'UIC-Franc'),('COU','970','Unidad de Valor Real'),('CLF','990','Unidades de fomento'),('UYI','940','Uruguay Peso en Unidades Indexadas'),('USD','840','US Dollar'),('USN','997','US Dollar (Next day)'),('USS','998','US Dollar (Same day)'),('UZS','860','Uzbekistan Sum'),('VUV','548','Vatu'),('CHE','947','WIR Euro'),('CHW','948','WIR Franc'),('KRW','410','Won'),('YER','886','Yemeni Rial'),('JPY','392','Yen'),('CNY','156','Yuan Renminbi'),('ZMK','894','Zambian Kwacha'),('ZWL','932','Zimbabwe Dollar'),('PLN','985','Zloty');
/*!40000 ALTER TABLE `ref_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_iptocountry`
--

DROP TABLE IF EXISTS `ref_iptocountry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_iptocountry` (
  `ip_from` int(10) unsigned NOT NULL,
  `ip_to` int(10) unsigned NOT NULL,
  `country_code` char(2) NOT NULL,
  KEY `country_code` (`country_code`),
  KEY `ip_to` (`ip_to`),
  KEY `ip_from` (`ip_from`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_iptocountry`
--

LOCK TABLES `ref_iptocountry` WRITE;
/*!40000 ALTER TABLE `ref_iptocountry` DISABLE KEYS */;
/*!40000 ALTER TABLE `ref_iptocountry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_language`
--

DROP TABLE IF EXISTS `ref_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_language` (
  `one` char(2) NOT NULL,
  `two` char(3) NOT NULL,
  `language` varchar(120) NOT NULL,
  `native` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`one`),
  KEY `two` (`two`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_language`
--

LOCK TABLES `ref_language` WRITE;
/*!40000 ALTER TABLE `ref_language` DISABLE KEYS */;
INSERT INTO `ref_language` VALUES ('ab','abk','Abkhazian','?????'),('aa','aar','Afar','Afaraf'),('af','afr','Afrikaans','Afrikaans'),('ak','aka','Akan','Akan'),('sq','sqi','Albanian','Shqip'),('am','amh','Amharic',NULL),('ar','ara','Arabic','???????'),('an','arg','Aragonese','Aragonés'),('hy','hye','Armenian','???????'),('as','asm','Assamese',NULL),('av','ava','Avaric','???? ????, ???????? ????'),('ae','ave','Avestan','avesta'),('ay','aym','Aymara','aymar aru'),('az','aze','Azerbaijani','az?rbaycan dili'),('bm','bam','Bambara','bamanankan'),('ba','bak','Bashkir','??????? ????'),('eu','eus','Basque','euskara, euskera'),('be','bel','Belarusian','??????????'),('bn','ben','Bengali',NULL),('bh','bih','Bihari','???????'),('bi','bis','Bislama','Bislama'),('bs','bos','Bosnian','bosanski jezik'),('br','bre','Breton','brezhoneg'),('bg','bul','Bulgarian','????????? ????'),('my','mya','Burmese',NULL),('ca','cat','Catalan, Valencian','Català'),('km','khm','Central Khmer',NULL),('ch','cha','Chamorro','Chamoru'),('ce','che','Chechen','??????? ????'),('ny','nya','Chichewa, Chewa, Nyanja','chiChe?a, chinyanja'),('zh','zho','Chinese','?? (Zh?ngwén), ??, ??'),('cu','chu','Old Church Slavonic, Old Bulgarian','????? ??????????'),('cv','chv','Chuvash','????? ?????'),('kw','cor','Cornish','Kernewek'),('co','cos','Corsican','corsu, lingua corsa'),('cr','cre','Cree',NULL),('hr','hrv','Croatian','hrvatski'),('cs','ces','Czech','?esky, ?eština'),('da','dan','Danish','dansk'),('dv','div','Divehi, Dhivehi, Maldivian','??????'),('nl','nld','Dutch, Flemish','Nederlands, Vlaams'),('dz','dzo','Dzongkha',NULL),('en','eng','English','English'),('eo','epo','Esperanto','Esperanto'),('et','est','Estonian','eesti, eesti keel'),('ee','ewe','Ewe','E?egbe'),('fo','fao','Faroese','føroyskt'),('fj','fij','Fijian','vosa Vakaviti'),('fi','fin','Finnish','suomi, suomen kieli'),('fr','fra','French','français, langue française'),('ff','ful','Fulah','Fulfulde, Pulaar, Pular'),('gd','gla','Gaelic, Scottish Gaelic','Gàidhlig'),('gl','glg','Galician','Galego'),('lg','lug','Ganda','Luganda'),('ka','kat','Georgian','???????'),('de','deu','German','Deutsch'),('gn','grn','Guaraní','Avañe\'?'),('gu','guj','Gujarati','???????'),('ht','hat','Haitian, Haitian Creole','Kreyòl ayisyen'),('ha','hau','Hausa','Hausa, ??????'),('hz','her','Herero','Otjiherero'),('hi','hin','Hindi','??????, ?????'),('ho','hmo','Hiri Motu','Hiri Motu'),('hu','hun','Hungarian','Magyar'),('is','isl','Icelandic','Íslenska'),('io','ido','Ido','Ido'),('ig','ibo','Igbo','Igbo'),('id','ind','Indonesian','Bahasa Indonesia'),('ia','ina','Interlingua (IALA)','Interlingua'),('ie','ile','Interlingue, Occidental','Interlingue'),('iu','iku','Inuktitut',NULL),('ik','ipk','Inupiaq','Iñupiaq, Iñupiatun'),('ga','gle','Irish','Gaeilge'),('it','ita','Italian','Italiano'),('ja','jpn','Japanese','??? (??????????)'),('jv','jav','Javanese','basa Jawa'),('kl','kal','Kalaallisut, Greenlandic','kalaallisut, kalaallit oqaasii'),('kn','kan','Kannada','?????'),('kr','kau','Kanuri','Kanuri'),('ks','kas','Kashmiri','???????, ???????'),('kk','kaz','Kazakh','????? ????'),('ki','kik','Kikuyu, Gikuyu','G?k?y?'),('rw','kin','Kinyarwanda','Ikinyarwanda'),('ky','kir','Kirghiz, Kyrgyz','?????? ????'),('kv','kom','Komi','???? ???'),('kg','kon','Kongo','KiKongo'),('ko','kor','Korean','??? (???), ??? (???)'),('ku','kur','Kurdish','Kurdî, ??????'),('kj','kua','Kwanyama, Kuanyama','Kuanyama'),('lo','lao','Lao',NULL),('la','lat','Latin','latine, lingua latina'),('lv','lav','Latvian','latviešu valoda'),('li','lim','Limburgish, Limburgan, Limburger','Limburgs'),('ln','lin','Lingala','Lingála'),('lt','lit','Lithuanian','lietuvi? kalba'),('lu','lub','Luba-Katanga',NULL),('lb','ltz','Luxembourgish, Letzeburgesch','Lëtzebuergesch'),('mk','mkd','Macedonian','?????????? ?????'),('mg','mlg','Malagasy','Malagasy fiteny'),('ms','msa','Malay','bahasa Melayu, ???? ??????'),('ml','mal','Malayalam',NULL),('mt','mlt','Maltese','Malti'),('gv','glv','Manx','Gaelg, Gailck'),('mi','mri','M?ori','te reo M?ori'),('mr','mar','Marathi','?????'),('mh','mah','Marshallese','Kajin M?aje?'),('el','ell','Modern Greek','????????'),('he','heb','Modern Hebrew','?????'),('mn','mon','Mongolian','??????'),('na','nau','Nauru','Ekakair? Naoero'),('nv','nav','Navajo, Navaho','Diné bizaad, Dinék?eh?í'),('ng','ndo','Ndonga','Owambo'),('ne','nep','Nepali','??????'),('nd','nde','North Ndebele','isiNdebele'),('se','sme','Northern Sami','Davvisámegiella'),('no','nor','Norwegian','Norsk'),('nb','nob','Norwegian Bokmål','Norsk bokmål'),('nn','nno','Norwegian Nynorsk','Norsk nynorsk'),('oc','oci','Occitan (after 1500)','Occitan'),('oj','oji','Ojibwa',NULL),('or','ori','Oriya',NULL),('om','orm','Oromo','Afaan Oromoo'),('os','oss','Ossetian, Ossetic','???? æ????'),('pi','pli','P?li','????'),('pa','pan','Panjabi, Punjabi','??????, ???????'),('ps','pus','Pashto, Pushto','????'),('fa','fas','Persian','?????'),('pl','pol','Polish','polski'),('pt','por','Portuguese','Português'),('qu','que','Quechua','Runa Simi, Kichwa'),('ro','ron','Romanian, Moldavian, Moldovan','român?'),('rm','roh','Romansh','rumantsch grischun'),('rn','run','Rundi','kiRundi'),('ru','rus','Russian','??????? ????'),('sm','smo','Samoan','gagana fa\'a Samoa'),('sg','sag','Sango','yângâ tî sängö'),('sa','san','Sanskrit','?????????'),('sc','srd','Sardinian','sardu'),('sr','srp','Serbian','?????? ?????'),('sn','sna','Shona','chiShona'),('ii','iii','Sichuan Yi, Nuosu',NULL),('sd','snd','Sindhi','??????, ????? ??????'),('si','sin','Sinhala, Sinhalese',NULL),('sk','slk','Slovak','sloven?ina'),('sl','slv','Slovene','slovenš?ina'),('so','som','Somali','Soomaaliga, af Soomaali'),('nr','nbl','South Ndebele','isiNdebele'),('st','sot','Southern Sotho','Sesotho'),('es','spa','Spanish, Castilian','español, castellano'),('su','sun','Sundanese','Basa Sunda'),('sw','swa','Swahili','Kiswahili'),('ss','ssw','Swati','SiSwati'),('sv','swe','Swedish','svenska'),('tl','tgl','Tagalog','Wikang Tagalog'),('ty','tah','Tahitian','Reo M?`ohi'),('tg','tgk','Tajik','??????, to?ik?, ???????'),('ta','tam','Tamil','?????'),('tt','tat','Tatar','???????, tatarça, ????????'),('te','tel','Telugu','??????'),('th','tha','Thai','???'),('bo','bod','Tibetan',NULL),('ti','tir','Tigrinya',NULL),('to','ton','Tonga (Tonga Islands)','faka Tonga'),('ts','tso','Tsonga','Xitsonga'),('tn','tsn','Tswana','Setswana'),('tr','tur','Turkish','Türkçe'),('tk','tuk','Turkmen','Türkmen, ???????'),('tw','twi','Twi','Twi'),('ug','uig','Uighur, Uyghur','Uy?urq?, ?????????'),('uk','ukr','Ukrainian','??????????'),('ur','urd','Urdu','????'),('uz','uzb','Uzbek','O\'zbek, ?????, ???????'),('ve','ven','Venda','Tshiven?a'),('vi','vie','Vietnamese','Ti?ng Vi?t'),('vo','vol','Volapük','Volapük'),('wa','wln','Walloon','Walon'),('cy','cym','Welsh','Cymraeg'),('fy','fry','Western Frisian','Frysk'),('wo','wol','Wolof','Wollof'),('xh','xho','Xhosa','isiXhosa'),('yi','yid','Yiddish','??????'),('yo','yor','Yoruba','Yorùbá'),('za','zha','Zhuang, Chuang','Sa? cue??, Saw cuengh'),('zu','zul','Zulu','isiZulu');
/*!40000 ALTER TABLE `ref_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_timezone`
--

DROP TABLE IF EXISTS `ref_timezone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_timezone` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `abbr` varchar(8) NOT NULL,
  `name` varchar(80) NOT NULL,
  `utc` varchar(18) NOT NULL,
  `hours` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `abbr` (`abbr`),
  KEY `utc` (`utc`)
) ENGINE=MyISAM AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_timezone`
--

LOCK TABLES `ref_timezone` WRITE;
/*!40000 ALTER TABLE `ref_timezone` DISABLE KEYS */;
INSERT INTO `ref_timezone` VALUES (1,'BIT','Baker Island Time','UTC-12',-12),(2,'SST','Samoa Standard Time','UTC-11',-11),(3,'CKT','Cook Island Time','UTC-10',-10),(4,'HAST','Hawaii-Aleutian Standard Time','UTC-10',-10),(5,'TAHT','Tahiti Time','UTC-10',-10),(6,'MIT','Marquesas Islands Time','UTC-9:30',-10),(7,'AKST','Alaska Standard Time','UTC-9',-9),(8,'GIT','Gambier Island Time','UTC-9',-9),(9,'CIST','Clipperton Island Standard Time','UTC-8',-8),(10,'PST','Pacific Standard Time (North America)','UTC-8',-8),(11,'MST','Mountain Standard Time (North America)','UTC-7',-7),(12,'PDT','Pacific Daylight Time (North America)','UTC-7',-7),(13,'THA','Thailand Standard Time','UTC-7',-7),(14,'CST','Central Standard Time (North America)','UTC-6',-6),(15,'EAST','Easter Island Standard Time','UTC-6',-6),(16,'GALT','Galapagos Time','UTC-6',-6),(17,'MDT','Mountain Daylight Time (North America)','UTC-6',-6),(18,'CDT','Central Daylight Time (North America)','UTC-5',-5),(19,'COT','Colombia Time','UTC-5',-5),(20,'ECT','Ecuador Time','UTC-5',-5),(21,'EST','Eastern Standard Time (North America)','UTC-5',-5),(22,'VET','Venezuelan Standard Time','UTC-4:30',-5),(23,'AST','Atlantic Standard Time','UTC-4',-4),(24,'BOT','Bolivia Time','UTC-4',-4),(25,'CLT','Chile Standard Time','UTC-4',-4),(26,'COST','Colombia Summer Time','UTC-4',-4),(27,'ECT','Eastern Caribbean Time (does not recognise DST)','UTC-4',-4),(28,'EDT','Eastern Daylight Time (North America)','UTC-4',-4),(29,'FKST','Falkland Islands Standard Time','UTC-4',-4),(30,'GYT','Guyana Time','UTC-4',-4),(31,'NT','Newfoundland Time','UTC-3:30',-4),(32,'ART','Argentina Time','UTC-3',-3),(33,'BRT','Brasilia Time','UTC-3',-3),(34,'CLST','Chile Summer Time','UTC-3',-3),(35,'GFT','French Guiana Time','UTC-3',-3),(36,'UYT','Uruguay Standard Time','UTC-3',-3),(37,'NDT','Newfoundland Daylight Time','UTC-2:30',-3),(38,'GST','South Georgia and the South Sandwich Islands','UTC-2',-2),(39,'UYST','Uruguay Summer Time','UTC-2',-2),(40,'AZOST','Azores Standard Time','UTC-1',-1),(41,'CVT','Cape Verde Time','UTC-1',-1),(42,'GMT','Greenwich Mean Time','UTC+0',0),(43,'WET','Western European Time','UTC+0',0),(44,'BST','British Summer Time (British Standard Time from Feb 1968 to Oct 1971)','UTC+1',1),(45,'CET','Central European Time','UTC+1',1),(46,'WAT','West Africa Time','UTC+1',1),(47,'WEST','Western European Summer Time','UTC+1',1),(48,'CAT','Central Africa Time','UTC+2',2),(49,'CEST','Central European Summer Time','UTC+2',2),(50,'EET','Eastern European Time','UTC+2',2),(51,'IST','Israel Standard Time','UTC+2',2),(52,'SAST','South African Standard Time','UTC+2',2),(53,'AST','Arab Standard Time (Kuwait, Riyadh)','UTC+3',3),(54,'AST','Arabic Standard Time (Baghdad)','UTC+3',3),(55,'EAT','East Africa Time','UTC+3',3),(56,'EEST','Eastern European Summer Time','UTC+3',3),(57,'MSK','Moscow Standard Time','UTC+3',3),(58,'IRST','Iran Standard Time','UTC+3:30',4),(59,'AMT','Armenia Time','UTC+4',4),(60,'AST','Arabian Standard Time (Abu Dhabi, Muscat)','UTC+4',4),(61,'AZT','Azerbaijan Time','UTC+4',4),(62,'GET','Georgia Standard Time','UTC+4',4),(63,'MUT','Mauritius Time','UTC+4',4),(64,'RET','Réunion Time','UTC+4',4),(65,'SAMT','Samara Time','UTC+4',4),(66,'SCT','Seychelles Time','UTC+4',4),(67,'AFT','Afghanistan Time','UTC+4:30',5),(68,'AMST','Armenia Summer Time','UTC+5',5),(69,'HMT','Heard and McDonald Islands Time','UTC+5',5),(70,'PKT','Pakistan Standard Time','UTC+5',5),(71,'YEKT','Yekaterinburg Time','UTC+5',5),(72,'IST','Indian Standard Time','UTC+5:30',6),(73,'SLT','Sri Lanka Time','UTC+5:30',6),(74,'NPT','Nepal Time','UTC+5:45',6),(75,'BIOT','British Indian Ocean Time','UTC+6',6),(76,'BST','Bangladesh Standard Time','UTC+6',6),(77,'BTT','Bhutan Time','UTC+6',6),(78,'OMST','Omsk Time','UTC+6',6),(79,'CCT','Cocos Islands Time','UTC+6:30',7),(80,'MST','Myanmar Standard Time','UTC+6:30',7),(81,'CXT','Christmas Island Time','UTC+7',7),(82,'KRAT','Krasnoyarsk Time','UTC+7',7),(83,'ACT','ASEAN Common Time','UTC+8',8),(84,'AWST','Australian Western Standard Time','UTC+8',8),(85,'BDT','Brunei Time','UTC+8',8),(86,'CST','China Standard Time','UTC+8',8),(87,'HKT','Hong Kong Time','UTC+8',8),(88,'IRKT','Irkutsk Time','UTC+8',8),(89,'MST','Malaysian Standard Time','UTC+8',8),(90,'PST','Philippine Standard Time','UTC+8',8),(91,'SST','Singapore Standard Time','UTC+8',8),(92,'JST','Japan Standard Time','UTC+9',9),(93,'KST','Korea Standard Time','UTC+9',9),(94,'YAKT','Yakutsk Time','UTC+9',9),(95,'ACST','Australian Central Standard Time','UTC+9:30',10),(96,'AEST','Australian Eastern Standard Time','UTC+10',10),(97,'ChST','Chamorro Standard Time','UTC+10',10),(98,'VLAT','Vladivostok Time','UTC+10',10),(99,'LHST','Lord Howe Standard Time','UTC+10:30',11),(100,'MAGT','Magadan Time','UTC+11',11),(101,'SBT','Solomon Islands Time','UTC+11',11),(102,'NFT','Norfolk Time','UTC+11:30',12),(103,'FJT','Fiji Time','UTC+12',12),(104,'GILT','Gilbert Island Time','UTC+12',12),(105,'PETT','Kamchatka Time','UTC+12',12),(106,'CHAST','Chatham Standard Time','UTC+12:45',13),(107,'PHOT','Phoenix Island Time','UTC+13',13),(108,'LINT','Line Islands Time','UTC+14',14);
/*!40000 ALTER TABLE `ref_timezone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_zoneinfo`
--

DROP TABLE IF EXISTS `ref_zoneinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_zoneinfo` (
  `zoneinfo` varchar(40) NOT NULL,
  `offset` varchar(16) DEFAULT NULL,
  `summer` varchar(16) DEFAULT NULL,
  `country` char(2) NOT NULL,
  PRIMARY KEY (`zoneinfo`),
  KEY `country` (`country`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_zoneinfo`
--

LOCK TABLES `ref_zoneinfo` WRITE;
/*!40000 ALTER TABLE `ref_zoneinfo` DISABLE KEYS */;
INSERT INTO `ref_zoneinfo` VALUES ('Europe/Andorra','UTC+1','UTC+2','ad'),('Asia/Dubai','UTC+4',NULL,'ae'),('Asia/Kabul','UTC+4:30',NULL,'af'),('America/Antigua','UTC-4',NULL,'ag'),('America/Anguilla','UTC-4',NULL,'ai'),('Europe/Tirane','UTC+1','UTC+2','al'),('Asia/Yerevan','UTC+4','UTC+5','am'),('America/Curacao','UTC-4',NULL,'an'),('Africa/Luanda','UTC+1',NULL,'ao'),('Antarctica/McMurdo','UTC+12','UTC+13','aq'),('Antarctica/South_Pole','UTC+12','UTC+13','aq'),('Antarctica/Rothera','UTC-3',NULL,'aq'),('Antarctica/Palmer','UTC-4','UTC-3','aq'),('Antarctica/Mawson','UTC+6',NULL,'aq'),('Antarctica/Davis','UTC+7',NULL,'aq'),('Antarctica/Casey','UTC+8',NULL,'aq'),('Antarctica/Vostok',NULL,NULL,'aq'),('Antarctica/DumontDUrville','UTC+10',NULL,'aq'),('Antarctica/Syowa','UTC+3',NULL,'aq'),('America/Argentina/Buenos_Aires','UTC-3','UTC-2','ar'),('America/Argentina/Cordoba','UTC-3','UTC-2','ar'),('America/Argentina/Salta','UTC-3',NULL,'ar'),('America/Argentina/Jujuy','UTC-3',NULL,'ar'),('America/Argentina/Tucuman','UTC-3','UTC-2','ar'),('America/Argentina/Catamarca','UTC-3',NULL,'ar'),('America/Argentina/La_Rioja','UTC-3',NULL,'ar'),('America/Argentina/San_Juan','UTC-3',NULL,'ar'),('America/Argentina/Mendoza','UTC-3',NULL,'ar'),('America/Argentina/San_Luis','UTC-4','UTC-3','ar'),('America/Argentina/Rio_Gallegos','UTC-3',NULL,'ar'),('America/Argentina/Ushuaia','UTC-3',NULL,'ar'),('Pacific/Pago_Pago','UTC-11',NULL,'as'),('Europe/Vienna','UTC+1','UTC+2','at'),('Australia/Lord_Howe','UTC+10:30','UTC+11','au'),('Australia/Hobart','UTC+10','UTC+11','au'),('Australia/Currie','UTC+10','UTC+11','au'),('Australia/Melbourne','UTC+10','UTC+11','au'),('Australia/Sydney','UTC+10','UTC+11','au'),('Australia/Broken_Hill','UTC+9:30','UTC+10:30','au'),('Australia/Brisbane','UTC+10',NULL,'au'),('Australia/Lindeman','UTC+10',NULL,'au'),('Australia/Adelaide','UTC+9:30','UTC+10:30','au'),('Australia/Darwin','UTC+9:30',NULL,'au'),('Australia/Perth','UTC+8',NULL,'au'),('Australia/Eucla','UTC+8:45','UTC+9:45','au'),('America/Aruba','UTC-4',NULL,'aw'),('Europe/Mariehamn','UTC+2','UTC+3','ax'),('Asia/Baku','UTC+4','UTC+5','az'),('Europe/Sarajevo','UTC+1','UTC+2','ba'),('America/Barbados','UTC-4',NULL,'bb'),('Asia/Dhaka','UTC+6',NULL,'bd'),('Europe/Brussels','UTC+1','UTC+2','be'),('Africa/Ouagadougou','UTC',NULL,'bf'),('Europe/Sofia','UTC+2','UTC+3','bg'),('Asia/Bahrain','UTC+3',NULL,'bh'),('Africa/Bujumbura','UTC+2',NULL,'bi'),('Africa/Porto-Novo','UTC+1',NULL,'bj'),('America/St_Barthelemy','UTC-4',NULL,'bl'),('Atlantic/Bermuda','UTC-4',NULL,'bm'),('Asia/Brunei','UTC+8',NULL,'bn'),('America/La_Paz','UTC-4',NULL,'bo'),('America/Noronha','UTC-2',NULL,'br'),('America/Belem','UTC-3',NULL,'br'),('America/Fortaleza','UTC-3',NULL,'br'),('America/Recife','UTC-3',NULL,'br'),('America/Araguaina','UTC-3',NULL,'br'),('America/Maceio','UTC-3',NULL,'br'),('America/Bahia','UTC-3',NULL,'br'),('America/Sao_Paulo','UTC-3','UTC-2','br'),('America/Campo_Grande','UTC-4','UTC-3','br'),('America/Cuiaba','UTC-4','UTC-3','br'),('America/Santarem','UTC-3',NULL,'br'),('America/Porto_Velho','UTC-4',NULL,'br'),('America/Boa_Vista','UTC-4',NULL,'br'),('America/Manaus','UTC-4',NULL,'br'),('America/Eirunepe','UTC-4',NULL,'br'),('America/Rio_Branco','UTC-4',NULL,'br'),('America/Nassau','UTC-4','UTC-3','bs'),('Asia/Thimphu','UTC+6',NULL,'bt'),('Africa/Gaborone','UTC+2',NULL,'bw'),('Europe/Minsk','UTC+2','UTC+3','by'),('America/Belize','UTC-6',NULL,'bz'),('America/St_Johns','UTC-3:30','UTC-2:30','ca'),('America/Halifax','UTC-4','UTC-3','ca'),('America/Glace_Bay','UTC-4','UTC-3','ca'),('America/Moncton','UTC-4','UTC-3','ca'),('America/Goose_Bay','UTC-4','UTC-3','ca'),('America/Blanc-Sablon','UTC-4',NULL,'ca'),('America/Montreal','UTC-5','UTC-4','ca'),('America/Toronto','UTC-5','UTC-4','ca'),('America/Nipigon','UTC-5','UTC-4','ca'),('America/Thunder_Bay','UTC-5','UTC-4','ca'),('America/Iqaluit','UTC-5','UTC-4','ca'),('America/Pangnirtung','UTC-5','UTC-4','ca'),('America/Resolute','UTC-5','UTC-4','ca'),('America/Atikokan','UTC-5',NULL,'ca'),('America/Rankin_Inlet','UTC-6','UTC-5','ca'),('America/Winnipeg','UTC-6','UTC-5','ca'),('America/Rainy_River','UTC-6','UTC-5','ca'),('America/Regina','UTC-6',NULL,'ca'),('America/Swift_Current','UTC-6',NULL,'ca'),('America/Edmonton','UTC-7','UTC-6','ca'),('America/Cambridge_Bay','UTC-7','UTC-6','ca'),('America/Yellowknife','UTC-7','UTC-6','ca'),('America/Inuvik','UTC-7','UTC-6','ca'),('America/Dawson_Creek','UTC-7',NULL,'ca'),('America/Vancouver','UTC-8','UTC-7','ca'),('America/Whitehorse','UTC-8','UTC-7','ca'),('America/Dawson','UTC-8','UTC-7','ca'),('Indian/Cocos','UTC+6:30',NULL,'cc'),('Africa/Kinshasa','UTC+1',NULL,'cd'),('Africa/Lubumbashi','UTC+2',NULL,'cd'),('Africa/Bangui','UTC+1',NULL,'cf'),('Africa/Brazzaville','UTC+1',NULL,'cg'),('Europe/Zurich','UTC+1','UTC+2','ch'),('Africa/Abidjan','UTC',NULL,'ci'),('Pacific/Rarotonga','UTC-10',NULL,'ck'),('America/Santiago','UTC-4','UTC-3','cl'),('Pacific/Easter','UTC-6','UTC-5','cl'),('Africa/Douala','UTC+1',NULL,'cm'),('Asia/Shanghai','UTC+8',NULL,'cn'),('Asia/Harbin','UTC+8',NULL,'cn'),('Asia/Chongqing','UTC+8',NULL,'cn'),('Asia/Urumqi','UTC+8',NULL,'cn'),('Asia/Kashgar','UTC+8',NULL,'cn'),('America/Bogota','UTC-5',NULL,'co'),('America/Costa_Rica','UTC-6',NULL,'cr'),('America/Havana','UTC-5','UTC-4','cu'),('Atlantic/Cape_Verde','UTC-1',NULL,'cv'),('Indian/Christmas','UTC+7',NULL,'cx'),('Asia/Nicosia','UTC+2','UTC+3','cy'),('Europe/Prague','UTC+1','UTC+2','cz'),('Europe/Berlin','UTC+1','UTC+2','de'),('Africa/Djibouti','UTC+3',NULL,'dj'),('Europe/Copenhagen','UTC+1','UTC+2','dk'),('America/Dominica','UTC-4',NULL,'dm'),('America/Santo_Domingo','UTC-4',NULL,'do'),('Africa/Algiers','UTC+1',NULL,'dz'),('America/Guayaquil','UTC-5',NULL,'ec'),('Pacific/Galapagos','UTC-6',NULL,'ec'),('Europe/Tallinn','UTC+2','UTC+3','ee'),('Africa/Cairo','UTC+2',NULL,'eg'),('Africa/El_Aaiun','UTC',NULL,'eh'),('Africa/Asmara','UTC+3',NULL,'er'),('Europe/Madrid','UTC+1','UTC+2','es'),('Africa/Ceuta','UTC+1','UTC+2','es'),('Atlantic/Canary','UTC','UTC+1','es'),('Africa/Addis_Ababa','UTC+3',NULL,'et'),('Europe/Helsinki','UTC+2','UTC+3','fi'),('Pacific/Fiji','UTC+12',NULL,'fj'),('Atlantic/Stanley','UTC-4','UTC-3','fk'),('Pacific/Truk','UTC+10',NULL,'fm'),('Pacific/Ponape','UTC+11',NULL,'fm'),('Pacific/Kosrae','UTC+11',NULL,'fm'),('Atlantic/Faroe','UTC','UTC+1','fo'),('Europe/Paris','UTC+1','UTC+2','fr'),('Africa/Libreville','UTC+1',NULL,'ga'),('Europe/London','UTC','UTC+1','gb'),('America/Grenada','UTC-4',NULL,'gd'),('Asia/Tbilisi','UTC+4',NULL,'ge'),('America/Cayenne','UTC-3',NULL,'gf'),('Europe/Guernsey','UTC','UTC+1','gg'),('Africa/Accra','UTC',NULL,'gh'),('Europe/Gibraltar','UTC+1','UTC+2','gi'),('America/Godthab','UTC-3','UTC-2','gl'),('America/Danmarkshavn','UTC',NULL,'gl'),('America/Scoresbysund','UTC-1','UTC','gl'),('America/Thule','UTC-4','UTC-3','gl'),('Africa/Banjul','UTC',NULL,'gm'),('Africa/Conakry','UTC',NULL,'gn'),('America/Guadeloupe','UTC-4',NULL,'gp'),('Africa/Malabo','UTC+1',NULL,'gq'),('Europe/Athens','UTC+2','UTC+3','gr'),('Atlantic/South_Georgia','UTC-2',NULL,'gs'),('America/Guatemala','UTC-6',NULL,'gt'),('Pacific/Guam','UTC+10',NULL,'gu'),('Africa/Bissau','UTC',NULL,'gw'),('America/Guyana','UTC-4',NULL,'gy'),('Asia/Hong_Kong','UTC+8',NULL,'hk'),('America/Tegucigalpa','UTC-6',NULL,'hn'),('Europe/Zagreb','UTC+1','UTC+2','hr'),('America/Port-au-Prince','UTC-5',NULL,'ht'),('Europe/Budapest','UTC+1','UTC+2','hu'),('Asia/Jakarta','UTC+7',NULL,'id'),('Asia/Pontianak','UTC+7',NULL,'id'),('Asia/Makassar','UTC+8',NULL,'id'),('Asia/Jayapura','UTC+9',NULL,'id'),('Europe/Dublin','UTC','UTC+1','ie'),('Asia/Jerusalem','UTC+2','UTC+3','il'),('Europe/Isle_of_Man','UTC','UTC+1','im'),('Asia/Kolkata','UTC+5:30',NULL,'in'),('Indian/Chagos','UTC+6',NULL,'io'),('Asia/Baghdad','UTC+3',NULL,'iq'),('Asia/Tehran','UTC+3:30','UTC+4:30','ir'),('Atlantic/Reykjavik','UTC',NULL,'is'),('Europe/Rome','UTC+1','UTC+2','it'),('Europe/Jersey','UTC','UTC+1','je'),('America/Jamaica','UTC-5',NULL,'jm'),('Asia/Amman','UTC+2','UTC+3','jo'),('Asia/Tokyo','UTC+9',NULL,'jp'),('Africa/Nairobi','UTC+3',NULL,'ke'),('Asia/Bishkek','UTC+6',NULL,'kg'),('Asia/Phnom_Penh','UTC+7',NULL,'kh'),('Pacific/Tarawa','UTC+12',NULL,'ki'),('Pacific/Enderbury','UTC+13',NULL,'ki'),('Pacific/Kiritimati','UTC+14',NULL,'ki'),('Indian/Comoro','UTC+3',NULL,'km'),('America/St_Kitts','UTC-4',NULL,'kn'),('Asia/Pyongyang','UTC+9',NULL,'kp'),('Asia/Seoul','UTC+9',NULL,'kr'),('Asia/Kuwait','UTC+3',NULL,'kw'),('America/Cayman','UTC-5',NULL,'ky'),('Asia/Almaty','UTC+6',NULL,'kz'),('Asia/Qyzylorda','UTC+6',NULL,'kz'),('Asia/Aqtobe','UTC+5',NULL,'kz'),('Asia/Aqtau','UTC+5',NULL,'kz'),('Asia/Oral','UTC+5',NULL,'kz'),('Asia/Vientiane','UTC+7',NULL,'la'),('Asia/Beirut','UTC+2','UTC+3','lb'),('America/St_Lucia','UTC-4',NULL,'lc'),('Europe/Vaduz','UTC+1','UTC+2','li'),('Asia/Colombo','UTC+5:30',NULL,'lk'),('Africa/Monrovia','UTC',NULL,'lr'),('Africa/Maseru','UTC+2',NULL,'ls'),('Europe/Vilnius','UTC+2','UTC+3','lt'),('Europe/Luxembourg','UTC+1','UTC+2','lu'),('Europe/Riga','UTC+2','UTC+3','lv'),('Africa/Tripoli','UTC+2',NULL,'ly'),('Africa/Casablanca','UTC',NULL,'ma'),('Europe/Monaco','UTC+1','UTC+2','mc'),('Europe/Chisinau','UTC+2','UTC+3','md'),('Europe/Podgorica','UTC+1','UTC+2','me'),('America/Marigot','UTC-4',NULL,'mf'),('Indian/Antananarivo','UTC+3',NULL,'mg'),('Pacific/Majuro','UTC+12',NULL,'mh'),('Pacific/Kwajalein','UTC+12',NULL,'mh'),('Europe/Skopje','UTC+1','UTC+2','mk'),('Africa/Bamako','UTC',NULL,'ml'),('Asia/Rangoon','UTC+6:30',NULL,'mm'),('Asia/Ulaanbaatar','UTC+8',NULL,'mn'),('Asia/Hovd','UTC+7',NULL,'mn'),('Asia/Choibalsan','UTC+8',NULL,'mn'),('Asia/Macau','UTC+8',NULL,'mo'),('Pacific/Saipan','UTC+10',NULL,'mp'),('America/Martinique','UTC-4',NULL,'mq'),('Africa/Nouakchott','UTC',NULL,'mr'),('America/Montserrat','UTC-4',NULL,'ms'),('Europe/Malta','UTC+1','UTC+2','mt'),('Indian/Mauritius','UTC+4',NULL,'mu'),('Indian/Maldives','UTC+5',NULL,'mv'),('Africa/Blantyre','UTC+2',NULL,'mw'),('America/Mexico_City','UTC-6','UTC-5','mx'),('America/Cancun','UTC-6','UTC-5','mx'),('America/Merida','UTC-6','UTC-5','mx'),('America/Monterrey','UTC-6','UTC-5','mx'),('America/Mazatlan','UTC-7','UTC-6','mx'),('America/Chihuahua','UTC-7','UTC-6','mx'),('America/Hermosillo','UTC-7',NULL,'mx'),('America/Tijuana','UTC-8','UTC-7','mx'),('Asia/Kuala_Lumpur','UTC+8',NULL,'my'),('Asia/Kuching','UTC+8',NULL,'my'),('Africa/Maputo','UTC+2',NULL,'mz'),('Africa/Windhoek','UTC+1','UTC+2','na'),('Pacific/Noumea','UTC+11',NULL,'nc'),('Africa/Niamey','UTC+1',NULL,'ne'),('Pacific/Norfolk','UTC+11:30',NULL,'nf'),('Africa/Lagos','UTC+1',NULL,'ng'),('America/Managua','UTC-6',NULL,'ni'),('Europe/Amsterdam','UTC+1',NULL,'nl'),('Europe/Oslo','UTC+1','UTC+2','no'),('Asia/Katmandu','UTC+5:45',NULL,'np'),('Pacific/Nauru','UTC+12',NULL,'nr'),('Pacific/Niue','UTC-11',NULL,'nu'),('Pacific/Auckland','UTC+12','UTC+13','nz'),('Pacific/Chatham','UTC+12:45','UTC+13:45','nz'),('Asia/Muscat','UTC+4',NULL,'om'),('America/Panama','UTC-5',NULL,'pa'),('America/Lima','UTC-5',NULL,'pe'),('Pacific/Tahiti','UTC-10',NULL,'pf'),('Pacific/Marquesas','UTC+9:30',NULL,'pf'),('Pacific/Gambier','UTC-9',NULL,'pf'),('Pacific/Port_Moresby','UTC+10',NULL,'pg'),('Asia/Manila','UTC+8',NULL,'ph'),('Asia/Karachi','UTC+6',NULL,'pk'),('Europe/Warsaw','UTC+1','UTC+2','pl'),('America/Miquelon','UTC-3','UTC-2','pm'),('Pacific/Pitcairn','UTC-8',NULL,'pn'),('America/Puerto_Rico','UTC-4',NULL,'pr'),('Asia/Gaza','UTC+2','UTC+3','ps'),('Europe/Lisbon','UTC','UTC+1','pt'),('Atlantic/Madeira','UTC','UTC+1','pt'),('Atlantic/Azores','UTC-1','UTC','pt'),('Pacific/Palau','UTC+9',NULL,'pw'),('America/Asuncion','UTC-4','UTC-3','py'),('Asia/Qatar','UTC+3',NULL,'qa'),('Indian/Reunion','UTC+4',NULL,'re'),('Europe/Bucharest','UTC+2','UTC+3','ro'),('Europe/Belgrade','UTC+1','UTC+2','rs'),('Europe/Kaliningrad','UTC+2','UTC+3','ru'),('Europe/Moscow','UTC+3','UTC+4','ru'),('Europe/Volgograd','UTC+3','UTC+4','ru'),('Europe/Samara','UTC+4','UTC+5','ru'),('Asia/Yekaterinburg','UTC+5','UTC+6','ru'),('Asia/Omsk','UTC+6','UTC+7','ru'),('Asia/Novosibirsk','UTC+6','UTC+7','ru'),('Asia/Krasnoyarsk','UTC+7','UTC+8','ru'),('Asia/Irkutsk','UTC+8','UTC+9','ru'),('Asia/Yakutsk','UTC+9','UTC+10','ru'),('Asia/Vladivostok','UTC+10','UTC+11','ru'),('Asia/Sakhalin','UTC+10','UTC+11','ru'),('Asia/Magadan','UTC+11','UTC+12','ru'),('Asia/Kamchatka','UTC+12','UTC+13','ru'),('Asia/Anadyr','UTC+12','UTC+13','ru'),('Africa/Kigali','UTC+2',NULL,'rw'),('Asia/Riyadh','UTC+3',NULL,'sa'),('Pacific/Guadalcanal','UTC+11',NULL,'sb'),('Indian/Mahe','UTC+4',NULL,'sc'),('Africa/Khartoum','UTC+3',NULL,'sd'),('Europe/Stockholm','UTC+1','UTC+2','se'),('Asia/Singapore','UTC+8',NULL,'sg'),('Atlantic/St_Helena','UTC',NULL,'sh'),('Europe/Ljubljana','UTC+1','UTC+2','si'),('Arctic/Longyearbyen','UTC+1','UTC+2','sj'),('Europe/Bratislava','UTC+1','UTC+2','sk'),('Africa/Freetown','UTC',NULL,'sl'),('Europe/San_Marino','UTC+1','UTC+2','sm'),('Africa/Dakar','UTC',NULL,'sn'),('Africa/Mogadishu','UTC+3',NULL,'so'),('America/Paramaribo','UTC-3',NULL,'sr'),('Africa/Sao_Tome','UTC',NULL,'st'),('America/El_Salvador','UTC-6',NULL,'sv'),('Asia/Damascus','UTC+2','UTC+3','sy'),('Africa/Mbabane','UTC+2',NULL,'sz'),('America/Grand_Turk','UTC-5','UTC-4','tc'),('Africa/Ndjamena','UTC+1',NULL,'td'),('Indian/Kerguelen','UTC+5',NULL,'tf'),('Africa/Lome','UTC',NULL,'tg'),('Asia/Bangkok','UTC+7',NULL,'th'),('Asia/Dushanbe','UTC+5',NULL,'tj'),('Pacific/Fakaofo','UTC-10',NULL,'tk'),('Asia/Dili','UTC+9',NULL,'tl'),('Asia/Ashgabat','UTC+5',NULL,'tm'),('Africa/Tunis','UTC+1','UTC+2','tn'),('Pacific/Tongatapu','UTC+13',NULL,'to'),('Europe/Istanbul','UTC+2','UTC+3','tr'),('America/Port_of_Spain','UTC-4',NULL,'tt'),('Pacific/Funafuti','UTC+12',NULL,'tv'),('Asia/Taipei','UTC+8',NULL,'tw'),('Africa/Dar_es_Salaam','UTC+3',NULL,'tz'),('Europe/Kiev','UTC+2','UTC+3','ua'),('Europe/Uzhgorod','UTC+2','UTC+3','ua'),('Europe/Zaporozhye','UTC+2','UTC+3','ua'),('Europe/Simferopol','UTC+2','UTC+3','ua'),('Africa/Kampala','UTC+3',NULL,'ug'),('Pacific/Johnston','UTC-10',NULL,'um'),('Pacific/Midway','UTC-11',NULL,'um'),('Pacific/Wake','UTC+12',NULL,'um'),('America/New_York','UTC-5','UTC-4','us'),('America/Detroit','UTC-5','UTC-4','us'),('America/Kentucky/Louisville','UTC-5','UTC-4','us'),('America/Kentucky/Monticello','UTC-5','UTC-4','us'),('America/Indiana/Indianapolis','UTC-5','UTC-4','us'),('America/Indiana/Vincennes','UTC-5','UTC-4','us'),('America/Indiana/Winamac','UTC-5','UTC-4','us'),('America/Indiana/Marengo','UTC-5','UTC-4','us'),('America/Indiana/Petersburg','UTC-5','UTC-4','us'),('America/Indiana/Vevay','UTC-5','UTC-4','us'),('America/Chicago','UTC-6','UTC-5','us'),('America/Indiana/Tell_City','UTC-6','UTC-5','us'),('America/Indiana/Knox','UTC-6','UTC-5','us'),('America/Menominee','UTC-6','UTC-5','us'),('America/North_Dakota/Center','UTC-6','UTC-5','us'),('America/North_Dakota/New_Salem','UTC-6','UTC-5','us'),('America/Denver','UTC-7','UTC-6','us'),('America/Boise','UTC-7','UTC-6','us'),('America/Shiprock','UTC-7','UTC-6','us'),('America/Phoenix','UTC-7',NULL,'us'),('America/Los_Angeles','UTC-8','UTC-7','us'),('America/Anchorage','UTC-9','UTC-8','us'),('America/Juneau','UTC-9','UTC-8','us'),('America/Yakutat','UTC-9','UTC-8','us'),('America/Nome','UTC-9','UTC-8','us'),('America/Adak','UTC-10','UTC-9','us'),('Pacific/Honolulu','UTC-10',NULL,'us'),('America/Montevideo','UTC-3','UTC-2','uy'),('Asia/Samarkand','UTC+5',NULL,'uz'),('Asia/Tashkent','UTC+5',NULL,'uz'),('Europe/Vatican','UTC+1','UTC+2','va'),('America/St_Vincent','UTC-4',NULL,'vc'),('America/Caracas','UTC-4:30',NULL,'ve'),('America/Tortola','UTC-4',NULL,'vg'),('America/St_Thomas','UTC-4',NULL,'vi'),('Asia/Ho_Chi_Minh','UTC+7',NULL,'vn'),('Pacific/Efate','UTC+11',NULL,'vu'),('Pacific/Wallis','UTC+12',NULL,'wf'),('Pacific/Apia','UTC-11',NULL,'ws'),('Asia/Aden','UTC+3',NULL,'ye'),('Indian/Mayotte','UTC+3',NULL,'yt'),('Africa/Johannesburg','UTC+2',NULL,'za'),('Africa/Lusaka','UTC+2',NULL,'zm'),('Africa/Harare','UTC+2',NULL,'zw');
/*!40000 ALTER TABLE `ref_zoneinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpsd_trends`
--

DROP TABLE IF EXISTS `wpsd_trends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpsd_trends` (
  `wpsd_trends_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `wpsd_trends_type` int(11) DEFAULT NULL,
  `wpsd_trends_date` datetime DEFAULT NULL,
  `wpsd_trends_stats` float DEFAULT NULL,
  PRIMARY KEY (`wpsd_trends_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpsd_trends`
--

LOCK TABLES `wpsd_trends` WRITE;
/*!40000 ALTER TABLE `wpsd_trends` DISABLE KEYS */;
/*!40000 ALTER TABLE `wpsd_trends` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-11-20 11:30:46
