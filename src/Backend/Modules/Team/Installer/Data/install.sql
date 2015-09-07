CREATE TABLE IF NOT EXISTS `team_members` (
  `id`          binary(16)    NOT NULL COMMENT 'a binary representation of a UUID',
  `meta_id`     int(11)       NOT NULL,
  `language`    varchar(5)    NOT NULL,
  `name`        varchar(255)  NOT NULL,
  `description` text          NOT NULL,
  `editedOn`    datetime      NOT NULL,
  `createdOn`   datetime      NOT NULL,
  `is_hidden`      tinyint(1)    NOT NULL DEFAULT 0 COMMENT 'lets not use ENUMs for this',
  PRIMARY KEY  (`id`),
  KEY `hidden` (`hidden`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;
