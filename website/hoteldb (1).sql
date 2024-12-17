-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2024 at 08:54 AM
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
-- Database: `hoteldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(10) UNSIGNED NOT NULL,
  `usname` varchar(30) DEFAULT NULL,
  `pass` varchar(30) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `usname`, `pass`, `profile_pic`) VALUES
(1, 'Admin', '1234', '../images/avatar/639a5016e92c33.04890837.png');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(10) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `background` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `slideshow_image1` varchar(255) NOT NULL,
  `slideshow_image2` varchar(255) NOT NULL,
  `slideshow_image3` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`id`, `logo`, `background`, `color`, `slideshow_image1`, `slideshow_image2`, `slideshow_image3`) VALUES
(1, 'logo.png', '1.jpg', '#ffffff', 'about1.jpg', 'about2.jpg', 'about3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` varchar(120) DEFAULT NULL,
  `UserName` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblbooking`
--

CREATE TABLE `tblbooking` (
  `ID` int(10) NOT NULL,
  `RoomId` int(5) DEFAULT NULL,
  `BookingNumber` varchar(120) DEFAULT NULL,
  `UserID` int(5) NOT NULL,
  `IDType` varchar(120) DEFAULT NULL,
  `Gender` varchar(50) DEFAULT NULL,
  `Address` mediumtext DEFAULT NULL,
  `CheckinDate` varchar(200) DEFAULT NULL,
  `CheckoutDate` varchar(200) DEFAULT NULL,
  `BookingDate` timestamp NULL DEFAULT current_timestamp(),
  `Remark` varchar(50) DEFAULT NULL,
  `Status` varchar(50) DEFAULT 'Pending',
  `downPay` int(255) NOT NULL,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `ID` int(10) NOT NULL,
  `CategoryName` varchar(120) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `Price` int(5) NOT NULL,
  `Date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`ID`, `CategoryName`, `Description`, `Price`, `Date`) VALUES
(12, 'Deluxe Room', 'extra fancy or of very high quality accommodation, If you upgrade to a deluxe hotel room, it will be bigger, more luxurious, and probably have a great view.', 15999, '2022-12-14 18:28:09'),
(13, 'Luxury Room', 'Luxury room features: High-quality furnishings with opulent, expensive touches, attention to aesthetic detail, a quiet room with fresh air, original art on the walls, windows that open, robes and slippers, adequate storage, hangers, desk, reading chair, safe, good-size flat-screen TV, iPhone/iPod dock, coffee maker', 12999, '2022-12-14 18:29:42'),
(14, 'Standard Room', ' a first-class, but not deluxe, standard of operation, construction and maintenance, including the quality of construction and of the furniture, equipment and finishes.', 7999, '2022-12-14 20:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `tblcontact`
--

CREATE TABLE `tblcontact` (
  `ID` int(10) NOT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Message` mediumtext DEFAULT NULL,
  `EnquiryDate` timestamp NULL DEFAULT current_timestamp(),
  `IsRead` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblfacility`
--

CREATE TABLE `tblfacility` (
  `ID` int(10) NOT NULL,
  `FacilityTitle` varchar(200) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `Image` varchar(200) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblpage`
--

CREATE TABLE `tblpage` (
  `ID` int(10) NOT NULL,
  `PageType` varchar(120) DEFAULT NULL,
  `PageTitle` varchar(200) DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblroom`
--

CREATE TABLE `tblroom` (
  `ID` int(10) NOT NULL,
  `RoomType` int(10) DEFAULT NULL,
  `RoomName` varchar(200) DEFAULT NULL,
  `MaxAdult` int(5) DEFAULT NULL,
  `MaxChild` int(5) DEFAULT NULL,
  `RoomDesc` mediumtext DEFAULT NULL,
  `NoofBed` int(5) DEFAULT NULL,
  `Image` varchar(200) DEFAULT NULL,
  `RoomFacility` varchar(200) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblroom`
--

INSERT INTO `tblroom` (`ID`, `RoomType`, `RoomName`, `MaxAdult`, `MaxChild`, `RoomDesc`, `NoofBed`, `Image`, `RoomFacility`, `CreationDate`) VALUES
(28, 12, 'Deluxe Single Room', 2, 2, 'Elegant and spacious single room with a comfortable bed and modern amenities. Perfect for solo travelers looking for a touch of luxury.', 1, 'image1.jpg', 'Available', '2022-12-16 00:00:00'),
(29, 12, 'Deluxe Double Room', 2, 2, 'Luxurious double room featuring a king-size bed, stylish decor, and stunning city views. Ideal for couples seeking a romantic getaway.', 2, 'image2.jpg', 'Available', '2022-12-16 00:15:00'),
(30, 12, 'Deluxe Triple Room', 3, 2, 'Spacious triple room with three comfortable beds, perfect for a family or group of friends. Modern amenities and a relaxing atmosphere.', 3, 'image4.jpg', 'Available', '2022-12-16 00:30:00'),
(31, 12, 'Executive Suite', 2, 1, 'An executive suite offering a separate living area and bedroom. Elegant furnishings, high-end amenities, and personalized service for a luxurious stay.', 1, 'image3.jpg', 'Available', '2022-12-16 00:45:00'),
(32, 12, 'Presidential Suite', 2, 2, 'Indulge in the ultimate luxury of our presidential suite. Expansive living space, a private balcony, and exclusive services for a truly VIP experience.', 2, 'image5.jpg', 'Available', '2022-12-16 01:00:00'),
(33, 12, 'Accessible Room', 1, 1, 'Thoughtfully designed accessible room with features like wider doorways and grab bars. Comfortable accommodation for guests with special needs.', 1, 'image6.jpg', 'Available', '2022-12-16 01:15:00'),
(34, 13, 'Luxury King Room', 3, 2, 'Experience luxury in our king-sized rooms with premium furnishings and breathtaking views. Perfect for a relaxing and indulgent stay.', 1, 'image7.jpg', 'Available', '2022-12-16 01:30:00'),
(35, 13, 'Luxury Queen Room', 2, 1, 'A royal experience awaits in our luxury queen rooms. Elegant decor, plush bedding, and top-notch amenities for a memorable stay.', 1, 'image8.jpg', 'Available', '2022-12-16 01:45:00'),
(36, 13, 'Grand Suite', 4, 2, 'Stay in our grand suite for a lavish experience. Separate living and sleeping areas, stunning interiors, and personalized service for an unforgettable stay.', 2, 'image9.jpg', 'Available', '2022-12-16 02:00:00'),
(37, 13, 'Family Connecting Rooms', 4, 3, 'Perfect for families, these connecting rooms offer both space and privacy. Comfortable beds, modern amenities, and a welcoming ambiance for a delightful stay.', 2, 'image10.jpg', 'Available', '2022-12-16 02:15:00'),
(38, 13, 'Panoramic View Suite', 2, 1, 'Enjoy breathtaking views in our panoramic view suite. Floor-to-ceiling windows, a private balcony, and luxurious amenities for an elevated stay.', 1, 'image11.jpg', 'Available', '2022-12-16 02:30:00'),
(39, 13, 'Junior Executive Room', 2, 1, 'Ideal for business travelers, the junior executive room offers a comfortable workspace and modern amenities for a productive stay.', 1, 'image12.jpg', 'Available', '2022-12-16 02:45:00'),
(40, 14, 'Standard Single Room', 1, 0, 'A cozy single room with all the essential amenities. Perfect for solo travelers on a budget looking for a comfortable stay.', 1, 'image13.jpg', 'Available', '2022-12-16 03:00:00'),
(41, 14, 'Standard Double Room', 2, 1, 'Affordable and comfortable, our standard double room offers a pleasant stay for couples or solo travelers. Modern amenities for your convenience.', 1, 'image14.jpg', 'Available', '2022-12-16 03:15:00'),
(42, 14, 'Standard Twin Room', 2, 1, 'A budget-friendly option for travelers, the standard twin room features two beds and essential amenities. Ideal for friends or family members.', 2, 'image15.jpg', 'Available', '2022-12-16 03:30:00'),
(43, 14, 'Economy Room', 1, 0, 'Our economy room provides basic accommodation at an affordable price. Suitable for budget-conscious travelers looking for a simple and comfortable stay.', 1, 'image16.jpg', 'Available', '2022-12-16 03:45:00'),
(44, 14, 'Cozy Retreat', 2, 1, 'Escape to a cozy retreat with comfortable furnishings and a warm ambiance. Perfect for a relaxing getaway without breaking the bank.', 1, 'image17.jpg', 'Available', '2022-12-16 04:00:00'),
(45, 14, 'Standard Family Room', 4, 2, 'A family-friendly choice, our standard family room offers space and comfort for a pleasant stay. Suitable for families with children.', 2, 'image18.jpg', 'Available', '2022-12-16 04:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `ID` int(10) NOT NULL,
  `FullName` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `privilege` varchar(255) NOT NULL DEFAULT 'unblocked',
  `code` text NOT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblbooking`
--
ALTER TABLE `tblbooking`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `tblcontact`
--
ALTER TABLE `tblcontact`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblfacility`
--
ALTER TABLE `tblfacility`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpage`
--
ALTER TABLE `tblpage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblroom`
--
ALTER TABLE `tblroom`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `RoomType` (`RoomType`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblbooking`
--
ALTER TABLE `tblbooking`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblcontact`
--
ALTER TABLE `tblcontact`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tblfacility`
--
ALTER TABLE `tblfacility`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblroom`
--
ALTER TABLE `tblroom`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
