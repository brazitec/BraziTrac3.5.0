Table,Create Table
jos_brazitrac_access_controls,CREATE TABLE `jos_brazitrac_access_controls` (
  `grp` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `control` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`grp`,`type`,`control`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC

0 rows affected
Table,Create Table
jos_brazitrac_access_map,CREATE TABLE `jos_brazitrac_access_map` (
  `grp` varchar(100) NOT NULL,
  `request_type` varchar(100) NOT NULL,
  `request_identifier` varchar(100) NOT NULL,
  `target_type` varchar(100) NOT NULL,
  `target_identifier` varchar(100) NOT NULL,
  `allow` tinyint(1) unsigned DEFAULT '0',
  `control` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`grp`,`request_type`,`request_identifier`,`target_type`,`target_identifier`,`control`,`type`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC

0 rows affected
Table,Create Table
jos_brazitrac_announcements,CREATE TABLE `jos_brazitrac_announcements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `checked_out` int(10) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `publish_from` datetime NOT NULL,
  `publish_to` datetime NOT NULL,
  `revised` int(10) unsigned NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

0 rows affected
Table,Create Table
jos_brazitrac_data_fields,CREATE TABLE `jos_brazitrac_data_fields` (
  `group` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `label` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `default` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL,
  `ordering` int(10) unsigned NOT NULL DEFAULT '1',
  `list` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `version` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`group`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC

0 rows affected
Table,Create Table
jos_brazitrac_data_groups,CREATE TABLE `jos_brazitrac_data_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `ordering` varchar(45) NOT NULL,
  `system` tinyint(3) unsigned DEFAULT '0',
  `description` text NOT NULL,
  `table` varchar(100) NOT NULL,
  `label` varchar(45) NOT NULL,
  `version` int(10) unsigned NOT NULL,
  `checked_out` int(10) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC

0 rows affected
Table,Create Table
jos_brazitrac_data_tables,CREATE TABLE `jos_brazitrac_data_tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `table` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC

0 rows affected
Table,Create Table
jos_brazitrac_document_containers,CREATE TABLE `jos_brazitrac_document_containers` (
  `alias` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `checked_out` int(10) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `hits` int(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text,
  `parent` int(10) unsigned NOT NULL DEFAULT '0',
  `field_metadata_author` varchar(45) NOT NULL,
  `field_metadata_description` varchar(255) NOT NULL,
  `modified` datetime NOT NULL,
  `creator` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUEALIAS` (`alias`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC

0 rows affected
Table,Create Table
jos_brazitrac_faq_categories,CREATE TABLE `jos_brazitrac_faq_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alias` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `checked_out` int(10) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '42',
  `modified` datetime NOT NULL,
  `field_metadata_author` varchar(100) NOT NULL,
  `field_metadata_keywords` varchar(255) NOT NULL,
  `revised` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUEALIAS` (`alias`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC

0 rows affected
Table,Create Table
jos_brazitrac_faqs,CREATE TABLE `jos_brazitrac_faqs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(500) NOT NULL,
  `answer` text NOT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `alias` varchar(200) NOT NULL,
  `version` int(10) unsigned NOT NULL,
  `field_metadata_author` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

0 rows affected
Table,Create Table
jos_brazitrac_glossary,CREATE TABLE `jos_brazitrac_glossary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `term` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `hits` int(10) unsigned NOT NULL,
  `alias` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `revised` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  `hits_reset` datetime NOT NULL,
  `field_metadata_description` varchar(255) NOT NULL,
  `field_metadata_keywords` varchar(45) NOT NULL,
  `field_metadata_robots` varchar(45) NOT NULL,
  `field_metadata_author` varchar(45) NOT NULL,
  `field_related_wikipedia` varchar(400) NOT NULL,
  `field_related_acronyms` varchar(255) NOT NULL,
  `hits_reset_by` int(10) unsigned NOT NULL,
  `field_related_a` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

0 rows affected
Table,Create Table
jos_brazitrac_request_categories,CREATE TABLE `jos_brazitrac_request_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `published` tinyint(1) unsigned NOT NULL,
  `checked_out` int(10) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `revised` int(10) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(500) NOT NULL,
  `parent_id` int(10) unsigned NOT NULL,
  `level` int(10) unsigned NOT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `path` text NOT NULL,
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` int(10) unsigned NOT NULL,
  `access` int(10) unsigned NOT NULL,
  `metakey` text,
  `metadesc` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC

0 rows affected
Table,Create Table
jos_brazitrac_request_history,CREATE TABLE `jos_brazitrac_request_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC

0 rows affected
Table,Create Table
jos_brazitrac_request_priorities,CREATE TABLE `jos_brazitrac_request_priorities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `checked_out` int(10) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `revised` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` int(10) unsigned NOT NULL,
  `access` int(10) unsigned NOT NULL,
  `colour` char(7) NOT NULL,
  `default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC

0 rows affected
Table,Create Table
jos_brazitrac_request_replies,CREATE TABLE `jos_brazitrac_request_replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `request_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC

0 rows affected
Table,Create Table
jos_brazitrac_requests,CREATE TABLE `jos_brazitrac_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `checked_out` int(10) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `revised` int(10) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(500) NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `priority` int(10) unsigned NOT NULL,
  `assignee` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC

0 rows affected
Table,Create Table
jos_brazitrac_tree,CREATE TABLE `jos_brazitrac_tree` (
  `grp` varchar(100) NOT NULL DEFAULT '',
  `type` varchar(100) NOT NULL DEFAULT '',
  `identifier` varchar(100) NOT NULL DEFAULT '0',
  `parent_type` varchar(100) DEFAULT NULL,
  `parent_identifier` varchar(100) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`grp`,`type`,`identifier`),
  KEY `PARENT` (`parent_type`,`parent_identifier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8

0 rows affected
Table,Create Table
jos_brazitrac_tree_groups,CREATE TABLE `jos_brazitrac_tree_groups` (
  `grp` varchar(100) NOT NULL DEFAULT 'system',
  `description` text,
  PRIMARY KEY (`grp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC

0 rows affected
