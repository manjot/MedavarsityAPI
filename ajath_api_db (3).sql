-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 15, 2018 at 02:42 PM
-- Server version: 5.7.24-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ajath_api_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `authentication_token`
--

CREATE TABLE `authentication_token` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `auth_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authentication_token`
--

INSERT INTO `authentication_token` (`id`, `student_id`, `auth_token`) VALUES
(1, 7, '5be9630c64d76');

-- --------------------------------------------------------

--
-- Table structure for table `college_master`
--

CREATE TABLE `college_master` (
  `id` int(11) NOT NULL,
  `college_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `college_master`
--

INSERT INTO `college_master` (`id`, `college_name`) VALUES
(1, 'Jipmer'),
(2, 'AFMC');

-- --------------------------------------------------------

--
-- Table structure for table `daily_updates`
--

CREATE TABLE `daily_updates` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daily_updates`
--

INSERT INTO `daily_updates` (`id`, `title`, `url`, `status`) VALUES
(1, 'sample externam link', 'https://youtu.be/PCwL3-hkKrg', 1),
(2, 'sample videos', 'https://youtu.be/EngW7tLk6R8', 1);

-- --------------------------------------------------------

--
-- Table structure for table `device_details`
--

CREATE TABLE `device_details` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `device_type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `device_details`
--

INSERT INTO `device_details` (`id`, `student_id`, `device_id`, `device_type`) VALUES
(1, 7, 'fdkgsfdbsfsdbfdslfdshbglsdgdsgsdgdfsgd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `intro_url`
--

CREATE TABLE `intro_url` (
  `id` int(11) NOT NULL,
  `intro_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `intro_url`
--

INSERT INTO `intro_url` (`id`, `intro_url`) VALUES
(1, 'https://youtu.be/PCwL3-hkKrg');

-- --------------------------------------------------------

--
-- Table structure for table `lecture_videos`
--

CREATE TABLE `lecture_videos` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `video_title` varchar(255) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `video_image_url` varchar(255) DEFAULT NULL,
  `video_type` int(1) NOT NULL DEFAULT '0' COMMENT '0 = paid 1 = demo',
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lecture_videos`
--

INSERT INTO `lecture_videos` (`id`, `subject_id`, `video_title`, `video_url`, `video_image_url`, `video_type`, `status`) VALUES
(1, 1, 'abc', 'https://youtu.be/PCwL3-hkKrg', 'https://youtu.be/PCwL3-hkKrg', 1, 1),
(2, 1, 'tec', 'https://youtu.be/PCwL3-hkKrg', 'https://youtu.be/PCwL3-hkKrg', 1, 1),
(3, 2, 'fsjhfsd', 'https://youtu.be/PCwL3-hkKrg', 'https://youtu.be/PCwL3-hkKrg', 1, 1),
(4, 2, 'ftusdfsd', 'https://youtu.be/PCwL3-hkKrg', 'https://youtu.be/PCwL3-hkKrg', 1, 1),
(5, 2, 'efrf', 'https://youtu.be/PCwL3-hkKrg', 'https://youtu.be/PCwL3-hkKrg', 0, 1),
(6, 3, 'efsdf', 'https://youtu.be/PCwL3-hkKrg', 'https://youtu.be/PCwL3-hkKrg', 0, 1),
(7, 3, 'fsfsdfsfsdsfsfsfsfsdfdffddffd', 'https://youtu.be/PCwL3-hkKrg', 'https://youtu.be/PCwL3-hkKrg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `medi_login_users`
--

CREATE TABLE `medi_login_users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `about` longtext NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT '0' COMMENT '0 = faculty 1= super admin',
  `password` varchar(255) NOT NULL,
  `profile_image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `medi_registered_students`
--

CREATE TABLE `medi_registered_students` (
  `student_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `college_id` int(11) NOT NULL,
  `mbbs_year` varchar(255) NOT NULL,
  `social_id` varchar(255) DEFAULT NULL,
  `registration_type` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medi_registered_students`
--

INSERT INTO `medi_registered_students` (`student_id`, `name`, `email`, `contact_no`, `password`, `college_id`, `mbbs_year`, `social_id`, `registration_type`, `image_url`, `status`, `address`, `created_date`) VALUES
(7, 'deepak', 'shahdeepak88@gmail.com', '9971601865', '9561bb63d77db30356820b9f6aa5c42d', 1, '1', 'abcd', 0, '', 1, '', '1542002100'),
(8, 'deepak', 'shahdeepdeak37@gmail.com', '9971603568', '9561bb63d77db30356820b9f6aa5c42d', 1, '1', '', 0, '', 0, '', '1542178200');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `review` longtext,
  `status` int(1) NOT NULL,
  `rating` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `video_id`, `subject_id`, `student_id`, `review`, `status`, `rating`) VALUES
(1, 1, 1, 7, 'testsfsnfkjsdbfsdsdg gdg dfsg sdg dfg sdg dsg ds gds gd sg dsgd', 1, 3.50),
(2, 2, 1, 7, 'test er erfsd fdsf df dsfds fsd fs fs f sfsf sf s', 1, 5.00),
(5, 1, 1, 7, 'very good video', 1, 3.00),
(6, 1, 1, 7, 'very good video', 1, 3.00),
(7, 1, 1, 7, 'very good video', 1, 3.00),
(8, 1, 1, 7, 'very good video', 1, 3.00);

-- --------------------------------------------------------

--
-- Table structure for table `student_otp`
--

CREATE TABLE `student_otp` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `otp` int(11) NOT NULL,
  `contact_num` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_otp`
--

INSERT INTO `student_otp` (`id`, `student_id`, `otp`, `contact_num`, `created_date`) VALUES
(2, 7, 9518, '9971601865', '1542002100'),
(3, 8, 2204, '9971601865', '1542002280'),
(4, 9, 6584, '9971601865', '1542002280'),
(5, 8, 8602, '9971603568', '1542178200');

-- --------------------------------------------------------

--
-- Table structure for table `subject_details`
--

CREATE TABLE `subject_details` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `subject_description` longtext NOT NULL,
  `subject_features` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject_details`
--

INSERT INTO `subject_details` (`id`, `subject_id`, `subject_description`, `subject_features`) VALUES
(1, 1, 'The study of the human body and how it is affected by disease. Includes study at cellular and molecular levels.', 'The study of the human body and how it is affected by disease. Includes study at cellular and molecular levels.'),
(2, 2, 'The study of the function and behaviour of the human body, including subjects such as respiration, circulation, digestion, excretion, reproduction and neuroscience.', 'The study of the function and behaviour of the human body, including subjects such as respiration, circulation, digestion, excretion, reproduction and neuroscience.'),
(3, 3, 'The study of the major physiology systems in humans, measurement techniques in their normal and abnormal function, and their use in the diagnosis and treatment of disease.', 'The study of the major physiology systems in humans, measurement techniques in their normal and abnormal function, and their use in the diagnosis and treatment of disease.'),
(4, 4, 'The study of the effects and nature of diseases in cellular structures.', 'The study of the effects and nature of diseases in cellular structures.'),
(5, 5, 'The study of the anatomy, physiology, biophysics, biochemistry, molecular biology, pharmacology and behaviour of human nerve cells and nervous systems.', 'The study of the anatomy, physiology, biophysics, biochemistry, molecular biology, pharmacology and behaviour of human nerve cells and nervous systems.'),
(6, 6, 'The study of the planning and execution of treatment programmes to prevent or remedy physical dysfunction, relieve pain and prevent further disability.', 'The study of the planning and execution of treatment programmes to prevent or remedy physical dysfunction, relieve pain and prevent further disability.'),
(7, 7, 'he study of the diagnosis and management of pathologies of the lower limb and foot.', 'he study of the diagnosis and management of pathologies of the lower limb and foot.');

-- --------------------------------------------------------

--
-- Table structure for table `subject_master`
--

CREATE TABLE `subject_master` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject_master`
--

INSERT INTO `subject_master` (`id`, `subject_name`) VALUES
(1, 'Anatomy'),
(2, 'physiology'),
(3, 'Physiology'),
(4, 'Clinical physiology '),
(5, 'Cellular pathology '),
(6, 'Neuroscience '),
(7, 'Physiotherapy ');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_details`
--

CREATE TABLE `subscription_details` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `added_on` varchar(255) NOT NULL,
  `modified_on` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_details`
--

INSERT INTO `subscription_details` (`id`, `student_id`, `subject_id`, `status`, `added_on`, `modified_on`) VALUES
(1, 7, 1, 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_orders`
--

CREATE TABLE `subscription_orders` (
  `order_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `student_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `net_amount` float(10,2) NOT NULL,
  `tax_rate` int(11) NOT NULL,
  `data_added` varchar(255) NOT NULL,
  `data_modified` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `test_name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `grand_test` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `video_id`, `subject_id`, `test_name`, `status`, `grand_test`) VALUES
(5, 1, 1, 'test fdsf', 1, 0),
(6, 1, 1, 'test ddfsd', 1, 0),
(7, 2, 1, 'test rgdf', 1, 0),
(8, 2, 1, 'test efdsf', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_details`
--

CREATE TABLE `user_bank_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name_as_per_bank_account` varchar(255) NOT NULL,
  `account_no` varchar(255) NOT NULL,
  `ifsc_code` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authentication_token`
--
ALTER TABLE `authentication_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `college_master`
--
ALTER TABLE `college_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_updates`
--
ALTER TABLE `daily_updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_details`
--
ALTER TABLE `device_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `intro_url`
--
ALTER TABLE `intro_url`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecture_videos`
--
ALTER TABLE `lecture_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medi_login_users`
--
ALTER TABLE `medi_login_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `medi_registered_students`
--
ALTER TABLE `medi_registered_students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_otp`
--
ALTER TABLE `student_otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_details`
--
ALTER TABLE `subject_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_master`
--
ALTER TABLE `subject_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_details`
--
ALTER TABLE `subscription_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_orders`
--
ALTER TABLE `subscription_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authentication_token`
--
ALTER TABLE `authentication_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `college_master`
--
ALTER TABLE `college_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `daily_updates`
--
ALTER TABLE `daily_updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `device_details`
--
ALTER TABLE `device_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `intro_url`
--
ALTER TABLE `intro_url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lecture_videos`
--
ALTER TABLE `lecture_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `medi_login_users`
--
ALTER TABLE `medi_login_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `medi_registered_students`
--
ALTER TABLE `medi_registered_students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `student_otp`
--
ALTER TABLE `student_otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `subject_details`
--
ALTER TABLE `subject_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `subject_master`
--
ALTER TABLE `subject_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `subscription_details`
--
ALTER TABLE `subscription_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `subscription_orders`
--
ALTER TABLE `subscription_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
