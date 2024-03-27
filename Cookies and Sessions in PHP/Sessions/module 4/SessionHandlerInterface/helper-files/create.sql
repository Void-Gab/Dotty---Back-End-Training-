CREATE DATABASE IF NOT EXISTS sess_handler COLLATE utf8_general_ci;

-- Table structure for table `sessions`
CREATE TABLE IF NOT EXISTS `sessions` (
  `sid` varchar(40) NOT NULL PRIMARY KEY,
  `expiry` int(10) NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
