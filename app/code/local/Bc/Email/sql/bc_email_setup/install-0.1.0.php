<?php
$installer = $this;
$installer->startSetup();

$installer->run("
    CREATE TABLE {$this->getTable('bc_email_rule')} (
      `id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `is_active` tinyint(1) NOT NULL DEFAULT '0',
      `event_type` varchar(128) NOT NULL,
      `title` varchar(255) NOT NULL,
      `chain` text NOT NULL,
      `store_ids` varchar(255) NOT NULL,
      `product_type_ids` varchar(128) NOT NULL DEFAULT '',
      `category_ids` text,
      `product_ids` varchar(255) NOT NULL DEFAULT '',
      `sale_amount` varchar(255) DEFAULT NULL,
      `email_copy_to` varchar(255) NOT NULL DEFAULT '',
      `email_send_to_customer` tinyint(1) NOT NULL DEFAULT '1',
      `test_objects` text,
      `test_recipient` varchar(255) DEFAULT '',
      `sender_name` varchar(255) DEFAULT '',
      `sender_email` varchar(255) DEFAULT '',
      `cancel_events` text,
      `sku` text,
      `send_to_subscribers_only` tinyint(1) NOT NULL DEFAULT '0',
      `customer_groups` varchar(255) DEFAULT NULL,
      `anl_segments` text COMMENT 'Advanced Newsletter segments',
      `mss_rule_id` int(10) NOT NULL DEFAULT '0' COMMENT 'aheadWorks Market Segmentation Suite rule ID',
      `coupon_enabled` tinyint(1) NOT NULL DEFAULT '0',
      `coupon_sales_rule_id` int(10) UNSIGNED NOT NULL,
      `coupon_prefix` tinytext NOT NULL,
      `coupon_expire_days` int(10) UNSIGNED NOT NULL,
      `ga_source` varchar(100) NOT NULL COMMENT 'Google Analytics Source',
      `ga_medium` varchar(100) NOT NULL COMMENT 'Google Analytics Medium',
      `ga_term` varchar(100) NOT NULL COMMENT 'Google Analytics Term',
      `ga_content` varchar(100) NOT NULL COMMENT 'Google Analytics Content',
      `ga_name` varchar(100) NOT NULL COMMENT 'Google Analytics Name',
      `unsubscribed_customers` text NOT NULL,
      `cross_active` int(11) NOT NULL,
      `cross_source` varchar(20) NOT NULL,
      `active_from` datetime DEFAULT NULL,
      `active_to` datetime DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();


// template loader
require 'install-bc-email-templates.php';


