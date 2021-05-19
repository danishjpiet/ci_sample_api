-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2021 at 11:46 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_sample_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `_gta_users_gta_`
--

CREATE TABLE `_gta_users_gta_` (
  `user_id` int(11) NOT NULL,
  `user_type` tinyint(4) DEFAULT NULL COMMENT '1=>buyer 2=>seller',
  `name` varchar(400) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `mobile` varchar(250) DEFAULT NULL,
  `gst_registered` varchar(350) DEFAULT NULL,
  `states` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `address` varchar(1000) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `distance_covered` int(11) NOT NULL DEFAULT 50 COMMENT 'in KM',
  `profile_pic` varchar(250) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL COMMENT 'in Years',
  `gender` varchar(250) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `account_type` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `razorpay_acc_id` varchar(255) DEFAULT NULL,
  `total_earning` varchar(255) DEFAULT NULL,
  `withdrawal` varchar(255) DEFAULT NULL,
  `balance_amount` varchar(255) DEFAULT NULL,
  `today_earning` varchar(255) DEFAULT NULL,
  `is_mobile_verified` tinyint(4) DEFAULT 0,
  `is_email_verified` tinyint(4) NOT NULL DEFAULT 0,
  `app_token` varchar(255) DEFAULT NULL COMMENT 'mobile device id',
  `credibility_score` int(11) NOT NULL DEFAULT 0 COMMENT 'in percentage',
  `rating` int(11) NOT NULL DEFAULT 0 COMMENT '0=>no rating 1=>min  5=>max',
  `is_new_user` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=new_user 0=old_user',
  `notification` tinyint(4) NOT NULL DEFAULT 1 COMMENT '2=>off 1=>on',
  `is_blocked` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=>Blocked',
  `is_profile_completed` tinyint(4) DEFAULT 0 COMMENT '1=>completed',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `_gta_users_gta_`
--
ALTER TABLE `_gta_users_gta_`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `_gta_users_gta_`
--
ALTER TABLE `_gta_users_gta_`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=522;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
