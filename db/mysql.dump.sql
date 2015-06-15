SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;

START TRANSACTION;

SET time_zone = "+00:00";

DROP TABLE IF EXISTS `user`;

CREATE TABLE IF NOT EXISTS `user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `country` enum('de','at','ch','it') NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='User data' AUTO_INCREMENT=4 ;

INSERT INTO `user` (`id`, `firstname`, `lastname`, `country`, `description`) VALUES
(1, 'Max', 'Mustermann', 'de', 'Ich bin der Max und ein echter Mustermann'),
(2, 'Theo', 'Tester', 'de', 'Ich bin der Theo und teste das hier.'),
(3, 'Moritz', 'Mustermann', 'de', 'Ich bin der Moritz und suche meinen Bruder Max.');

SET FOREIGN_KEY_CHECKS=1;

COMMIT;
