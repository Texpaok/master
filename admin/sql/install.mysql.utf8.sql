-- Here we save the actual session. If there are two different sessions, here are two different entries. If there is no session, the table is empty.
CREATE TABLE IF NOT EXISTS `#__joommark_stats` (
  `session_id_person` varchar(255) NOT NULL,
  `nowpage`           varchar(255) NULL,
  `lastupdate_time`   int(11) NULL,
  `current_name`  varchar(255) NULL,
  PRIMARY KEY (`session_id_person`)
) ENGINE=InnoDB CHARACTER SET `utf8`;

-- If the url changed, we take information from #__joommark_stats to this table. For the seconds we count the difference between the actual time and #__joommark_stats.lastupdate_time.
CREATE TABLE IF NOT EXISTS `#__joommark_serverstats` (
  `session_id` varchar(50),
  `user_id_person` INT NULL DEFAULT 0,
  `customer_name`     varchar(255),
  `visitdate`         date,
  `visit_timestamp`   datetime,
  `visitedpage`       varchar(255),
  `geolocation`       varchar(255),
  `ip`                varchar(255),
  `browser`           varchar(255),
  `os`                varchar(255),
  `seconds` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`session_id` ,  `visitdate` ,  `visitedpage`)
) ENGINE=InnoDB CHARACTER SET `utf8`;

-- perhaps referrals are interesting for a target
CREATE TABLE IF NOT EXISTS `#__joommark_referral` (
  `referral` varchar(255) NOT NULL,
  `record_date` date NOT NULL,
  `ip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB CHARACTER SET `utf8`;

-- Messages to be chown to the user
CREATE TABLE IF NOT EXISTS `#__joommark_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `catid` int(11) NOT NULL DEFAULT '0',
  `params` TEXT NOT NULL DEFAULT '',
  `asset_id` int(11) NOT NULL DEFAULT '0',
  `menuitems_message`varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `allmenus` int(3) unsigned,
  `percentage` int(3) unsigned,
  `message` varchar(255) NOT NULL,
  `cookie` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET `utf8`;

-- perhaps search words are interesting for a target
CREATE TABLE IF NOT EXISTS `#__joommark_searches` (
  `searchword` varchar(255) NOT NULL,
  `user_id_person` INT NULL DEFAULT 0,
  `record_date` date NOT NULL
) ENGINE=InnoDB CHARACTER SET `utf8`;

-- this are our main data, the user can create a plan. Example for type: max clicks on a url, max clicks on an ip, max seconds on a page ...
CREATE TABLE IF NOT EXISTS `#__joommark_plansstats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `asset_id` int(11) NOT NULL DEFAULT '0',
  `plans_min_visited_pages` int(11) NOT NULL DEFAULT '0',
  `plans_min_visited_time_sec` int(11) NOT NULL DEFAULT '0',
  `plans_mode_menu_or_url` varchar(50) NOT NULL DEFAULT 'url',
  `plans_menuitems` varchar(255) NOT NULL DEFAULT '',
  `plans_url` varchar(255) NOT NULL DEFAULT 'http://www.example.de',
  `state` tinyint(4) NOT NULL,
  `type` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NULL ,
  `hastarget` tinyint NOT NULL DEFAULT '0',
  `target_expectation` int(11) NULL,
  `checked_out` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET `utf8`;

-- If the admin wants to be informed, if the plan is reached, we have to track …
CREATE TABLE IF NOT EXISTS `#__joommark_plansstats_track` (
  `plan_id` int(11) NOT NULL,
  `session_id` varchar(200) NOT NULL,
  `plandate` date NOT NULL,
  `plan_timestamp` int(11) NOT NULL,
  PRIMARY KEY (`plan_id`, `session_id`, `plandate`)
) ENGINE=InnoDB CHARACTER SET `utf8`;

-- Perhaps the admin want to check if the plan was good and many people made a feedback ....
CREATE TABLE IF NOT EXISTS `#__joommark_feedbacksstats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `planid` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET `utf8`;

CREATE TABLE IF NOT EXISTS `#__joommark_countries_map` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `num_code` smallint(6) NOT NULL,
  `iso1_code` char(2) NOT NULL,
  `name` varchar(80)  NOT NULL,
  `name_caps` varchar(80) NOT NULL,
  `iso3_code` char(3) DEFAULT NULL,
  `visits` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB CHARACTER SET `utf8`;
 
INSERT IGNORE INTO `#__joommark_countries_map` (`id`, `num_code`, `iso1_code`, `name`, `name_caps`, `iso3_code`) VALUES
(1, 4, 'AF', 'Afghanistan', 'AFGHANISTAN', 'AFG'),
(2, 248, 'AX', 'Aland Islands', 'ALAND ISLANDS', 'ALA'),
(32, 76, 'BR', 'Brazil', 'BRAZIL', 'BRA');
