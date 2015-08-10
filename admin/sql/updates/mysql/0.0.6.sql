DROP TABLE IF EXISTS `#__bulkorder`;

CREATE TABLE `#__bulkorder` (
	`id`       INT(11)     NOT NULL AUTO_INCREMENT,
	`message` VARCHAR(250) NOT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

INSERT INTO `#__bulkorder` (`message`) VALUES
('Bulk Orders'),
('Bulk Orders ');