CREATE TABLE IF NOT EXISTS `movies` (
  `movie_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `year` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `length` int(11) DEFAULT NULL,
  PRIMARY KEY (`movie_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `title`, `year`, `length`) VALUES
(1, 'A Beautiful Mind', '2001', 135),
(2, 'Chicago', '2002', 113),
(3, 'Crouching Tiger, Hidden Dragon', '2000', 121),
(4, 'Gladiator', '2000', 155),
(5, 'Lost in Translation', '2003', 120),
(6, 'Million Dollar Baby', '2004', 132),
(7, 'Moulin Rouge', '2001', 120),
(8, 'The Return of the King', '2003', 201);