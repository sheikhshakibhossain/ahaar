-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 30, 2024 at 02:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_donation_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `email` varchar(64) DEFAULT NULL,
  `passwd` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`email`, `passwd`) VALUES
('shakib221@gmail.com', 'meaw');

-- --------------------------------------------------------

--
-- Table structure for table `disaster_alert`
--

CREATE TABLE `disaster_alert` (
  `id` int(11) NOT NULL,
  `title` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disaster_alert`
--

INSERT INTO `disaster_alert` (`id`, `title`) VALUES
(1, '250+ martyred, Quota movement 2024');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `donation_id` int(11) NOT NULL,
  `food_name` varchar(64) NOT NULL,
  `quantity` int(11) NOT NULL,
  `location` varchar(64) NOT NULL,
  `postal_code` varchar(64) NOT NULL,
  `expire_date_time` datetime NOT NULL,
  `donor_email` varchar(64) NOT NULL,
  `quantity_available` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`donation_id`, `food_name`, `quantity`, `location`, `postal_code`, `expire_date_time`, `donor_email`, `quantity_available`) VALUES
(1, 'Dim Khichuri', 50, 'Tipu Sultan Road', '1100', '2024-08-10 17:40:00', 'shakib221@gmail.com', 40),
(2, 'Dal Bhat', 60, 'Tipu Sultan Road', '1100', '2024-07-29 22:44:00', 'shakib221@gmail.com', 59),
(3, 'Egg Noodles', 70, 'Mirpur 10', '1216', '2024-08-10 20:01:00', 'riana221@gmail.com', 58),
(4, 'Egg Noodles', 60, 'Uttar Badda', '1212', '2024-08-16 12:05:00', 'sauda221@gmail.com', 59),
(5, 'Ruti Vaji', 50, 'Tipu Sultan Road', '1100', '2024-03-19 01:40:00', 'shakib221@gmail.com', 50),
(6, 'Chicken curry and rice', 2, 'Mirpur', '456', '2024-07-31 16:08:00', 'shamia221@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `donation_taken`
--

CREATE TABLE `donation_taken` (
  `donation_id` int(11) NOT NULL,
  `recipient_email` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_taken`
--

INSERT INTO `donation_taken` (`donation_id`, `recipient_email`) VALUES
(1, 'sauda221@gmail.com'),
(1, 'sauda221@gmail.com'),
(2, 'sauda221@gmail.com'),
(3, 'sauda221@gmail.com'),
(4, 'sauda221@gmail.com'),
(1, 'shakib221@gmail.com'),
(3, 'shakib221@gmail.com'),
(6, 'shamia221@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `donor_id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `passwd` varchar(64) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `gender` varchar(64) DEFAULT NULL,
  `address` varchar(64) DEFAULT NULL,
  `postal_code` varchar(64) DEFAULT NULL,
  `user_type` varchar(64) DEFAULT NULL,
  `restaurant_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`donor_id`, `name`, `email`, `passwd`, `phone`, `gender`, `address`, `postal_code`, `user_type`, `restaurant_name`) VALUES
(1001, 'Sheikh Shakib Hossain', 'shakib221@gmail.com', 'meaw', '01920589868', 'Male', '61, tipu sultan road, dhaka', '1100', 'Regular', NULL),
(1002, 'Afrina Riana', 'riana221@gmail.com', '1234', '018123132123', 'Female', 'Mirpur, Dhaka', '1216', 'Restaurant Owner', 'R\'s Kitchen'),
(1003, 'Sauda Binti Noor', 'sauda221@gmail.com', '1234', '01812313212324', 'Female', 'Uttar Badda, Dhaka', '1212', 'Restaurant Owner', 'Sauda\'s Dine'),
(1004, 'Shamia Islam', 'shamia221@gmail.com', '1234', '0181231365656', 'Female', 'Mirpur, Dhaka', '1216', 'Restaurant Owner', 'Shamia\'s Kitchen');

-- --------------------------------------------------------

--
-- Table structure for table `recipient`
--

CREATE TABLE `recipient` (
  `recipient_id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `passwd` varchar(64) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `gender` varchar(64) DEFAULT NULL,
  `address` varchar(64) DEFAULT NULL,
  `postal_code` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipient`
--

INSERT INTO `recipient` (`recipient_id`, `name`, `email`, `passwd`, `phone`, `gender`, `address`, `postal_code`) VALUES
(1001, 'person', 'person@email.com', '1234', '0192321323', 'Male', 'Wari, Dhaka', 1100),
(1002, 'Sheikh Shakib Hossain', 'shakib221@gmail.com', 'meaw', '01920589868', 'Male', 'Wari, Dhaka', 1100),
(1003, 'Sauda Binti Noor', 'sauda221@gmail.com', '1234', '01920873281', 'Female', 'Uttar badda, Dhaka', 1212),
(1005, 'Mehedi Hasan', 'mehedihasan@gmail.com', '1234', '018123132566', 'Male', NULL, NULL),
(1006, 'Mehedi Hasan Rafi', 'mhasanrafi@gmail.com', '1234', '0181231323', 'Male', 'Faridpur', 8000),
(1007, 'guest', 'guest@ahaar.com', '1234', '017213414242', 'Male', 'N/A', 1200),
(1008, 'guest', 'guest1@ahaar.com', '1234', '017213414242', 'Male', 'N/A', 1200),
(1009, 'guest', 'guest2@ahaar.com', '1234', '017213414242', 'Male', 'N/A', 1200),
(1010, 'guest', 'guest3@ahaar.com', '1234', '017213414242', 'Male', 'N/A', 1200),
(1011, 'guest', 'guest4@ahaar.com', '1234', '017213414242', 'Male', 'N/A', 1200),
(1012, 'guest', 'guest5@ahaar.com', '1234', '017213414242', 'Male', 'N/A', 1200),
(1013, 'guest', 'guest6@ahaar.com', '1234', '017213414242', 'Male', 'N/A', 1200),
(1014, 'guest', 'guest7@ahaar.com', '1234', '017213414242', 'Male', 'N/A', 1200),
(1015, 'guest', 'guest8@ahaar.com', '1234', '017213414242', 'Male', 'N/A', 1200),
(1016, 'guest', 'guest9@ahaar.com', '1234', '016368123', 'Female', 'Dhaka', 1150),
(1017, 'guest', 'guest10@ahaar.com', '1234', '016368123', 'Female', 'Dhaka', 1150),
(1018, 'guest', 'guest11@ahaar.com', '1234', '016368123', 'Female', 'Dhaka', 1150),
(1019, 'guest', 'guest12@ahaar.com', '1234', '016368123', 'Female', 'Dhaka', 1150),
(1020, 'guest', 'guest13@ahaar.com', '1234', '016368123', 'Female', 'Dhaka', 1150),
(1021, 'guest', 'guest14@ahaar.com', '1234', '016368123', 'Female', 'Dhaka', 1150),
(1022, 'guest', 'guest15@ahaar.com', '1234', '016368123', 'Female', 'Dhaka', 1150),
(1023, 'guest', 'guest16@ahaar.com', '1234', '016368123', 'Female', 'Dhaka', 1150),
(1024, 'guest', 'guest17@ahaar.com', '1234', '016368123', 'Female', 'Dhaka', 1150),
(1025, 'guest', 'guest18@ahaar.com', '1234', '016368123', 'Female', 'Dhaka', 1150),
(1026, 'guest', 'guest19@ahaar.com', '1234', '016368123', 'Female', 'Dhaka', 1150),
(1027, 'guest', 'guest20@ahaar.com', '1234', '016368123', 'Female', 'Dhaka', 1150);

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `email` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`email`) VALUES
('shakib221@gmail.com'),
('riana221@gmail.com'),
('sauda221@gmail.com'),
('shamia221@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `sponsors_application`
--

CREATE TABLE `sponsors_application` (
  `email` varchar(64) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sponsors_application`
--

INSERT INTO `sponsors_application` (`email`, `description`, `status`) VALUES
('shakib221@gmail.com', 'I\'ve a restaurant.  I can donate daily.', 'accepted'),
('riana221@gmail.com', 'I\'ve a restaurant.  I can donate daily.', 'accepted'),
('sauda221@gmail.com', 'I\'ve a restaurant.  I can donate daily.', 'accepted'),
('shamia221@gmail.com', 'I\'ve a restaurant.  I can donate daily.', 'accepted');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `disaster_alert`
--
ALTER TABLE `disaster_alert`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`donation_id`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`donor_id`);

--
-- Indexes for table `recipient`
--
ALTER TABLE `recipient`
  ADD PRIMARY KEY (`recipient_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `disaster_alert`
--
ALTER TABLE `disaster_alert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `donor`
--
ALTER TABLE `donor`
  MODIFY `donor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1005;

--
-- AUTO_INCREMENT for table `recipient`
--
ALTER TABLE `recipient`
  MODIFY `recipient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1028;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
