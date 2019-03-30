CREATE TABLE `IPs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `IP` text,
  `countryCode` text,
  `country` text,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;