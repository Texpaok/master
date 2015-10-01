-- Here we save the actual session. If there are two different sessions, here are two different entries. If there is no session, the table is empty.
CREATE TABLE IF NOT EXISTS `#__joommarkt_stats` (
  `session_id_person` varchar(255) NOT NULL, 
  `nowpage`           varchar(255) NULL, 
  `lastupdate_time`   int(11) NULL, 
  `current_name`  varchar(255) NULL,
  PRIMARY KEY (`session_id_person`)
) ENGINE=InnoDB CHARACTER SET `utf8`;

-- If the url changed, we take information from #__joommarkt_stats to this table. For the seconds we count the difference between the actual time and #__joommarkt_stats.lastupdate_time.
CREATE TABLE IF NOT EXISTS `#__joommarkt_serverstats` (
  `session_id` varchar(50), 
  `user_id_person` INT NULL DEFAULT 0,
  `customer_name`     varchar(255), 
  `visitdate`         date,
  `visit_timestamp`   int, 
  `visitedpage`       varchar(255), 
  `geolocation`       varchar(255), 
  `ip`                varchar(255), 
  `browser`           varchar(255), 
  `os`                varchar(255),
  `seconds` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`session_id` ,  `visitdate` ,  `visitedpage`)
) ENGINE=InnoDB CHARACTER SET `utf8`; 

-- perhaps referrals are interesting for a target
CREATE TABLE IF NOT EXISTS `#__joommarkt_referral` (
  `referral` varchar(255) NOT NULL, 
  `record_date` date NOT NULL,
  `ip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB CHARACTER SET `utf8`;

-- perhaps search words are interesting for a target
CREATE TABLE IF NOT EXISTS `#__joommarkt_searches` (
  `searchword` varchar(255) NOT NULL,
  `user_id_person` INT NULL DEFAULT 0, 
  `record_date` date NOT NULL
) ENGINE=InnoDB CHARACTER SET `utf8`;

-- this are our main data, the user can create a plan. Example for type: max clicks on a url, max clicks on an ip, max seconds on a page ...
CREATE TABLE IF NOT EXISTS `#__joommarkt_plansstats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL default '0',
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
CREATE TABLE IF NOT EXISTS `#__joommarkt_plansstats_track` (
  `plan_id` int(11) NOT NULL, 
  `session_id` varchar(200) NOT NULL, 
  `plandate` date NOT NULL, 
  `plan_timestamp` int(11) NOT NULL, 
  PRIMARY KEY (`plan_id`, `session_id`, `plandate`)
) ENGINE=InnoDB CHARACTER SET `utf8`;

-- Perhaps the admin want to check if the plan was good and many people made a feedback ....
CREATE TABLE IF NOT EXISTS `#__joommarkt_feedbacksstats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `planid` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET `utf8`;
