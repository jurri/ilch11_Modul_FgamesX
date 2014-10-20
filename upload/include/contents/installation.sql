--
-- Tabellenstruktur für Tabelle `ic1_flashgames`
--

CREATE TABLE IF NOT EXISTS `prefix_flashgames` (
  `fg_id` int(11) NOT NULL AUTO_INCREMENT,
  `fg_link` varchar(200) COLLATE latin1_german2_ci NOT NULL,
  `fg_bolactive` int(11) DEFAULT NULL,
  `fg_name` varchar(50) COLLATE latin1_german2_ci NOT NULL,
  `fg_img` varchar(200) COLLATE latin1_german2_ci NOT NULL,
  `fg_fgkname` varchar(50) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`fg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci COMMENT='powered by FeTTsack' AUTO_INCREMENT=1;


--
-- Tabellenstruktur für Tabelle `ic1_fgkategory`
--

CREATE TABLE IF NOT EXISTS `prefix_fgkategory` (
  `fgk_id` int(5) NOT NULL AUTO_INCREMENT,
  `fgk_kname` varchar(50) COLLATE latin1_german2_ci NOT NULL,
  `fgk_kbesch` text COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`fgk_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci COMMENT='powered by FeTTsack' AUTO_INCREMENT=1;

insert into `prefix_modules`(url, name, gshow, ashow, fright) values ('flashgamesadmin', 'flashGames', '1', '1', '1');