--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `fullpath` text COLLATE latin1_general_ci,
  `friendlyName` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `fsInodeNumber` varchar(128) COLLATE latin1_general_ci DEFAULT NULL,
  `dbGroup` varchar(128) COLLATE latin1_general_ci NOT NULL,
  `label` enum('default','primary','success','info','warning','danger') COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci NOT NULL,
  UNIQUE KEY `filesystem` (`friendlyName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configHierarchy`
--

CREATE TABLE IF NOT EXISTS `configHierarchy` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `friendlyName` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `fullpath` text COLLATE latin1_general_ci NOT NULL,
  `fsInodeNumber` varchar(128) COLLATE latin1_general_ci DEFAULT NULL,
  `ignoreHrchy` tinyint(1) NOT NULL DEFAULT '0',
  `calcTopLevel` tinyint(1) NOT NULL DEFAULT '0',
  `user` varchar(127) COLLATE latin1_general_ci DEFAULT NULL,
  `grp` varchar(127) COLLATE latin1_general_ci NOT NULL,
  `type` enum('filesystem','group') COLLATE latin1_general_ci NOT NULL DEFAULT 'group',
  PRIMARY KEY (`id`),
  KEY `filesystem` (`friendlyName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE IF NOT EXISTS `info` (
  `key` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `value` varchar(32) COLLATE latin1_general_ci NOT NULL,
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offenders`
--

CREATE TABLE IF NOT EXISTS `offenders` (
  `user` varchar(127) COLLATE latin1_general_ci NOT NULL,
  `timestamp` int(10) NOT NULL,
  `notices` int(3) NOT NULL,
  `noticeType` enum('zot','oldfile') COLLATE latin1_general_ci NOT NULL,
  `type` enum('dir','file','symlink') COLLATE latin1_general_ci NOT NULL,
  `filesystem` varchar(127) COLLATE latin1_general_ci NOT NULL,
  `value` int(12) NOT NULL,
  `path` text COLLATE latin1_general_ci NOT NULL,
  `last_mod` date DEFAULT NULL,
  KEY `user` (`user`,`timestamp`,`filesystem`,`noticeType`,`value`,`notices`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE IF NOT EXISTS `stats` (
  `user` varchar(127) COLLATE latin1_general_ci NOT NULL,
  `grp` varchar(127) COLLATE latin1_general_ci NOT NULL,
  `type` varchar(31) COLLATE latin1_general_ci NOT NULL,
  `size` bigint(20) NOT NULL,
  `blocks` bigint(20) NOT NULL,
  `count` bigint(20) NOT NULL,
  `filesystem` varchar(80) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`user`,`type`,`filesystem`,`grp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
