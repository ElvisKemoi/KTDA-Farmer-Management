-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2025 at 11:14 AM
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
-- Database: `fertilizer_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `agricultural_officer`
--

CREATE TABLE `agricultural_officer` (
  `OfficerID` char(4) NOT NULL,
  `CenterID` char(4) NOT NULL,
  `FName` varchar(20) NOT NULL,
  `LName` varchar(20) NOT NULL,
  `TelNo` char(10) NOT NULL,
  `Password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agricultural_officer`
--

INSERT INTO `agricultural_officer` (`OfficerID`, `CenterID`, `FName`, `LName`, `TelNo`, `Password`) VALUES
('A001', 'SC01', 'Brian', 'Mwangi', '0912258478', 'abcd1234'),
('A002', 'SC02', 'Sharon', 'Achieng', '0704455698', '123xyz'),
('A003', 'SC01', 'Kelvin', 'Atieno', '0777586145', '#170#');

-- --------------------------------------------------------

--
-- Table structure for table `clerk`
--

CREATE TABLE `clerk` (
  `ClerkID` char(4) NOT NULL,
  `Address` int(11) NOT NULL,
  `CenterID` char(4) NOT NULL,
  `FName` varchar(20) NOT NULL,
  `LName` varchar(20) NOT NULL,
  `TelNo` char(10) NOT NULL,
  `Password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clerk`
--

INSERT INTO `clerk` (`ClerkID`, `Address`, `CenterID`, `FName`, `LName`, `TelNo`, `Password`) VALUES
('C001', 0, 'SC01', 'John', 'Doe', '0712345678', 'password123'),
('C002', 0, 'SC02', 'Jane', 'Smith', '0723456789', 'password456');

-- --------------------------------------------------------

--
-- Table structure for table `cultivation`
--

CREATE TABLE `cultivation` (
  `LandID` char(4) NOT NULL,
  `FarmerID` char(4) NOT NULL,
  `OfficerID` char(4) NOT NULL,
  `CropName` varchar(30) NOT NULL,
  `LandArea` decimal(8,3) NOT NULL,
  `Month` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cultivation`
--

INSERT INTO `cultivation` (`LandID`, `FarmerID`, `OfficerID`, `CropName`, `LandArea`, `Month`) VALUES
('L001', 'F001', 'A002', 'Tea', 2.560, 'January'),
('L002', 'F002', 'A003', 'Tea', 4.250, 'March'),
('L003', 'F002', 'A003', 'Tea', 5.500, 'February'),
('L004', 'F003', 'A002', 'Tea', 1.850, 'March'),
('L005', 'F001', 'A001', 'Tea', 4.800, 'January'),
('L006', 'F005', 'A001', 'Tea', 3.250, 'January'),
('L007', 'F005', 'A001', 'Tea', 0.950, 'January'),
('L008', 'F002', 'A001', 'Tea', 3.250, 'April'),
('L009', 'F003', 'A001', 'Tea', 2.300, 'February'),
('L010', 'F004', 'A001', 'Tea', 1.200, 'January');

-- --------------------------------------------------------

--
-- Table structure for table `farmer`
--

CREATE TABLE `farmer` (
  `FarmerID` char(4) NOT NULL,
  `FName` varchar(20) NOT NULL,
  `LName` varchar(20) NOT NULL,
  `Address` varchar(200) NOT NULL,
  `TelNo` char(10) NOT NULL,
  `NIC` varchar(12) NOT NULL,
  `Password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmer`
--

INSERT INTO `farmer` (`FarmerID`, `FName`, `LName`, `Address`, `TelNo`, `NIC`, `Password`) VALUES
('F001', 'Faith', 'Njeri', 'No.20, Walana, Panadura', '0912245896', '962291465V', 'abcd1234'),
('F002', 'Samuel', 'Kipchumba', 'No. 200, Thalpitiya, Wadduwa', '0712512500', '875612458V', 'abcd1234'),
('F003', 'Cynthia', 'Wambui', 'No. 100, Horawala, Matugama', '0777458963', '625645789V', 'abcd1234'),
('F004', 'Daniel', 'Mutumba', 'No. 10, Ginigama, Galle', '0762211456', '123456789456', 'abcd1234'),
('F005', 'Grace', 'Chebet', 'N0. 34, Ginthota, Aluthgama', '0701234568', '784596154V', 'abcd1234');

-- --------------------------------------------------------

--
-- Table structure for table `farmertasks`
--

CREATE TABLE `farmertasks` (
  `TaskID` int(11) NOT NULL,
  `FarmerID` varchar(10) NOT NULL,
  `TaskTitle` varchar(255) NOT NULL,
  `TaskDescription` text DEFAULT NULL,
  `TaskDate` date NOT NULL,
  `TaskStatus` enum('Pending','Completed') DEFAULT 'Pending',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmertasks`
--

INSERT INTO `farmertasks` (`TaskID`, `FarmerID`, `TaskTitle`, `TaskDescription`, `TaskDate`, `TaskStatus`, `CreatedAt`) VALUES
(4, 'F001', 'yrytylyutrye', 'yrtytyq98ptfcre87', '2025-04-04', 'Pending', '2025-03-31 09:08:20');

-- --------------------------------------------------------

--
-- Table structure for table `fertilizer`
--

CREATE TABLE `fertilizer` (
  `FertilizerID` char(4) NOT NULL,
  `Description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fertilizer`
--

INSERT INTO `fertilizer` (`FertilizerID`, `Description`) VALUES
('M001', 'Urea'),
('M002', 'Sulphate of Ammonia'),
('M003', 'Sodium Nitrate'),
('M004', 'Triple Superphosphate'),
('M005', 'Ammonium Phosphate'),
('M006', 'Eppawala Rock Phosphate'),
('M007', 'Muriate of Potash'),
('M008', 'Dolamite');

-- --------------------------------------------------------

--
-- Table structure for table `fertilizerpickupschedules`
--

CREATE TABLE `fertilizerpickupschedules` (
  `ID` int(11) NOT NULL,
  `ScheduleDate` date NOT NULL,
  `PickupSlot` int(11) NOT NULL,
  `FertilizerType` varchar(100) NOT NULL,
  `MaxCapacity` int(11) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fertilizerpickupschedules`
--

INSERT INTO `fertilizerpickupschedules` (`ID`, `ScheduleDate`, `PickupSlot`, `FertilizerType`, `MaxCapacity`, `CreatedAt`) VALUES
(1, '2025-04-03', 1, 'Urea', 500, '2025-03-28 11:40:21');

-- --------------------------------------------------------

--
-- Table structure for table `fertilizerrequest`
--

CREATE TABLE `fertilizerrequest` (
  `requestId` int(11) NOT NULL,
  `farmerId` char(4) NOT NULL,
  `landId` char(4) NOT NULL,
  `fertilizerId` char(4) NOT NULL,
  `amountRequested` decimal(10,2) NOT NULL,
  `requestDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fertilizerrequest`
--

INSERT INTO `fertilizerrequest` (`requestId`, `farmerId`, `landId`, `fertilizerId`, `amountRequested`, `requestDate`) VALUES
(1, 'F001', 'L001', 'M004', 20.00, '2025-03-30 21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `LoanID` int(11) NOT NULL,
  `FarmerID` varchar(10) DEFAULT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `ApplicationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`LoanID`, `FarmerID`, `Amount`, `Status`, `ApplicationDate`) VALUES
(1, 'F001', 50000.00, 'Pending', '2025-03-27 21:00:00'),
(2, 'F001', 50000.00, 'Pending', '2025-03-27 21:00:00'),
(3, 'F001', 2000.00, 'Pending', '2025-03-27 21:00:00'),
(4, 'F001', 2000.00, 'Pending', '2025-03-27 21:00:00'),
(5, 'F001', 7500.00, 'Pending', '2025-03-30 21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `produce`
--

CREATE TABLE `produce` (
  `ProduceID` int(11) NOT NULL,
  `FarmerID` char(4) NOT NULL,
  `ClerkID` char(4) NOT NULL,
  `Quantity` decimal(8,2) NOT NULL,
  `DateRecorded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produce`
--

INSERT INTO `produce` (`ProduceID`, `FarmerID`, `ClerkID`, `Quantity`, `DateRecorded`) VALUES
(1, 'F001', 'C001', 55.00, '2025-03-28'),
(2, 'F001', 'C001', 55.00, '2025-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `questionnaireresponses`
--

CREATE TABLE `questionnaireresponses` (
  `ResponseID` int(11) NOT NULL,
  `FarmerID` varchar(10) NOT NULL,
  `TemplateID` int(11) NOT NULL,
  `SubmissionDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questionnaireresponses`
--

INSERT INTO `questionnaireresponses` (`ResponseID`, `FarmerID`, `TemplateID`, `SubmissionDate`) VALUES
(1, 'F001', 1, '2025-03-28 04:15:20'),
(2, 'F001', 1, '2025-03-28 04:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `questionnairetemplates`
--

CREATE TABLE `questionnairetemplates` (
  `TemplateID` int(11) NOT NULL,
  `TemplateName` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `CreatedDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questionnairetemplates`
--

INSERT INTO `questionnairetemplates` (`TemplateID`, `TemplateName`, `Description`, `CreatedDate`) VALUES
(1, 'Pesticide Affecting Farms In Negative ways', 'This questionare aims to prove if the existing pesticides in our store have actually been woorking or its all just a hype from the farmers. ', '2025-03-28 04:07:39'),
(2, 'Fertilizer Follow up', 'this is to follow up on the fertilizers given to farmers last week during the annual Event', '2025-03-28 10:54:43');

-- --------------------------------------------------------

--
-- Table structure for table `questionoptions`
--

CREATE TABLE `questionoptions` (
  `OptionID` int(11) NOT NULL,
  `QuestionID` int(11) DEFAULT NULL,
  `OptionText` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questionresponses`
--

CREATE TABLE `questionresponses` (
  `ResponseDetailID` int(11) NOT NULL,
  `ResponseID` int(11) DEFAULT NULL,
  `QuestionID` int(11) DEFAULT NULL,
  `ResponseText` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questionresponses`
--

INSERT INTO `questionresponses` (`ResponseDetailID`, `ResponseID`, `QuestionID`, `ResponseText`) VALUES
(1, 1, 1, 'Due to expire soon'),
(2, 1, 2, 'Nakuru'),
(3, 1, 3, 'Not Really'),
(4, 1, 4, 'WeeveKiller '),
(5, 1, 5, 'Make the pesticides more available as our products are dying due to delays in the pesticides allocation'),
(6, 2, 1, 'Due to expire soon'),
(7, 2, 2, 'Nakuru'),
(8, 2, 3, 'Not Really'),
(9, 2, 4, 'WeeveKiller '),
(10, 2, 5, 'Make the pesticides more available as our products are dying due to delays in the pesticides allocation');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `QuestionID` int(11) NOT NULL,
  `TemplateID` int(11) DEFAULT NULL,
  `QuestionText` text NOT NULL,
  `QuestionType` enum('Text','Number','Date','MultipleChoice') NOT NULL,
  `Required` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`QuestionID`, `TemplateID`, `QuestionText`, `QuestionType`, `Required`) VALUES
(1, 1, 'Are the Pesticides expired or due to expire soon?', 'Text', 1),
(2, 1, 'Which areas do you suggest on our pesticide program?', 'Text', 1),
(3, 1, 'Has the pesticide worked for you s a farmer?', 'Text', 1),
(4, 1, 'Which pesticide did you find most appropriate?', 'Text', 1),
(5, 1, 'Any suggestion on improvement of our program?', 'Text', 1),
(6, 2, 'Which Fertilizer Did you get?', 'Text', 1),
(7, 2, 'How many Kgs did you get?', 'Text', 1),
(8, 2, 'Did you get the exact Kgs you requested for?', 'Text', 1),
(9, 2, 'Did the fertilizers work as intended?', 'Text', 1);

-- --------------------------------------------------------

--
-- Table structure for table `receives`
--

CREATE TABLE `receives` (
  `ReceiveID` int(11) NOT NULL,
  `LandID` char(4) NOT NULL,
  `FertilizerID` char(4) NOT NULL,
  `IssueDate` date DEFAULT NULL,
  `Amount` decimal(8,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receives`
--

INSERT INTO `receives` (`ReceiveID`, `LandID`, `FertilizerID`, `IssueDate`, `Amount`) VALUES
(1, 'L001', 'M001', '2020-01-20', 5.000),
(2, 'L001', 'M004', '2020-01-03', 3.000),
(3, 'L002', 'M007', '2020-03-02', 5.000),
(4, 'L003', 'M001', '2020-02-15', 2.500),
(5, 'L003', 'M006', '2020-02-15', 1.500),
(6, 'L004', 'M004', '2020-04-05', 5.000),
(7, 'L006', 'M008', '2020-01-30', 2.000);

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `FertilizerID` char(4) NOT NULL,
  `CenterID` char(4) NOT NULL,
  `QtyOnHand` decimal(8,3) NOT NULL,
  `StoredDate` date DEFAULT NULL,
  `ExpireDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`FertilizerID`, `CenterID`, `QtyOnHand`, `StoredDate`, `ExpireDate`) VALUES
('M001', 'SC01', 75.000, '2020-01-07', '2021-01-07'),
('M001', 'SC02', 120.000, '2020-01-07', '2021-01-07'),
('M002', 'SC01', 60.000, '2020-03-20', '2021-03-20'),
('M002', 'SC02', 80.000, '2020-01-07', '2021-01-07'),
('M003', 'SC01', 40.000, '2019-09-02', '2020-09-02'),
('M004', 'SC01', 30.000, '2019-11-17', '2021-05-17'),
('M006', 'SC02', 65.000, '2020-01-07', '2021-07-07'),
('M007', 'SC02', 95.000, '2020-01-07', '2021-07-07'),
('M008', 'SC01', 100.000, '2019-02-09', '2021-02-09'),
('M008', 'SC02', 50.000, '2020-01-07', '2022-01-07');

-- --------------------------------------------------------

--
-- Table structure for table `supply_center`
--

CREATE TABLE `supply_center` (
  `CenterID` char(4) NOT NULL,
  `Division` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supply_center`
--

INSERT INTO `supply_center` (`CenterID`, `Division`) VALUES
('SC01', 'Aluthgama South'),
('SC02', 'Panadura'),
('SC03', 'Wadduwa North'),
('SC04', 'Galle Baddegama'),
('SC05', 'Galle Neluwa');

-- --------------------------------------------------------

--
-- Table structure for table `teapickupschedules`
--

CREATE TABLE `teapickupschedules` (
  `ID` int(11) NOT NULL,
  `Venue` varchar(50) NOT NULL,
  `MorningTime` varchar(10) NOT NULL,
  `EveningTime` varchar(10) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teapickupschedules`
--

INSERT INTO `teapickupschedules` (`ID`, `Venue`, `MorningTime`, `EveningTime`, `CreatedAt`) VALUES
(1, 'Kinda', '10:00 AM', '05:30 PM', '2025-03-28 12:23:44'),
(3, 'Nai', '12:00 PM', '07:30 PM', '2025-03-28 12:23:44'),
(4, 'Kiro', '10:30 AM', '05:00 PM', '2025-03-28 12:23:44'),
(5, 'Gikoe', '11:30 AM', '06:00 PM', '2025-03-28 12:23:44'),
(6, 'Westy', '10:20', '19:00', '2025-03-28 12:27:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agricultural_officer`
--
ALTER TABLE `agricultural_officer`
  ADD PRIMARY KEY (`OfficerID`),
  ADD KEY `CenterID` (`CenterID`);

--
-- Indexes for table `clerk`
--
ALTER TABLE `clerk`
  ADD PRIMARY KEY (`ClerkID`),
  ADD KEY `CenterID` (`CenterID`);

--
-- Indexes for table `cultivation`
--
ALTER TABLE `cultivation`
  ADD PRIMARY KEY (`LandID`),
  ADD KEY `FarmerID` (`FarmerID`),
  ADD KEY `OfficerID` (`OfficerID`);

--
-- Indexes for table `farmer`
--
ALTER TABLE `farmer`
  ADD PRIMARY KEY (`FarmerID`);

--
-- Indexes for table `farmertasks`
--
ALTER TABLE `farmertasks`
  ADD PRIMARY KEY (`TaskID`),
  ADD KEY `FarmerID` (`FarmerID`);

--
-- Indexes for table `fertilizer`
--
ALTER TABLE `fertilizer`
  ADD PRIMARY KEY (`FertilizerID`);

--
-- Indexes for table `fertilizerpickupschedules`
--
ALTER TABLE `fertilizerpickupschedules`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `fertilizerrequest`
--
ALTER TABLE `fertilizerrequest`
  ADD PRIMARY KEY (`requestId`),
  ADD KEY `fk_fertilizer_request_farmer` (`farmerId`),
  ADD KEY `fk_fertilizer_request_land` (`landId`),
  ADD KEY `fk_fertilizer_request_fertilizer` (`fertilizerId`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`LoanID`),
  ADD KEY `FarmerID` (`FarmerID`);

--
-- Indexes for table `produce`
--
ALTER TABLE `produce`
  ADD PRIMARY KEY (`ProduceID`),
  ADD KEY `FarmerID` (`FarmerID`),
  ADD KEY `ClerkID` (`ClerkID`);

--
-- Indexes for table `questionnaireresponses`
--
ALTER TABLE `questionnaireresponses`
  ADD PRIMARY KEY (`ResponseID`),
  ADD KEY `FarmerID` (`FarmerID`),
  ADD KEY `TemplateID` (`TemplateID`);

--
-- Indexes for table `questionnairetemplates`
--
ALTER TABLE `questionnairetemplates`
  ADD PRIMARY KEY (`TemplateID`);

--
-- Indexes for table `questionoptions`
--
ALTER TABLE `questionoptions`
  ADD PRIMARY KEY (`OptionID`),
  ADD KEY `QuestionID` (`QuestionID`);

--
-- Indexes for table `questionresponses`
--
ALTER TABLE `questionresponses`
  ADD PRIMARY KEY (`ResponseDetailID`),
  ADD KEY `ResponseID` (`ResponseID`),
  ADD KEY `QuestionID` (`QuestionID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`QuestionID`),
  ADD KEY `TemplateID` (`TemplateID`);

--
-- Indexes for table `receives`
--
ALTER TABLE `receives`
  ADD PRIMARY KEY (`ReceiveID`),
  ADD KEY `LandID` (`LandID`),
  ADD KEY `FertilizerID` (`FertilizerID`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`FertilizerID`,`CenterID`),
  ADD KEY `CenterID` (`CenterID`);

--
-- Indexes for table `supply_center`
--
ALTER TABLE `supply_center`
  ADD PRIMARY KEY (`CenterID`);

--
-- Indexes for table `teapickupschedules`
--
ALTER TABLE `teapickupschedules`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Venue` (`Venue`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `farmertasks`
--
ALTER TABLE `farmertasks`
  MODIFY `TaskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fertilizerpickupschedules`
--
ALTER TABLE `fertilizerpickupschedules`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fertilizerrequest`
--
ALTER TABLE `fertilizerrequest`
  MODIFY `requestId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `LoanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produce`
--
ALTER TABLE `produce`
  MODIFY `ProduceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `questionnaireresponses`
--
ALTER TABLE `questionnaireresponses`
  MODIFY `ResponseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `questionnairetemplates`
--
ALTER TABLE `questionnairetemplates`
  MODIFY `TemplateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `questionoptions`
--
ALTER TABLE `questionoptions`
  MODIFY `OptionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questionresponses`
--
ALTER TABLE `questionresponses`
  MODIFY `ResponseDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `QuestionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `receives`
--
ALTER TABLE `receives`
  MODIFY `ReceiveID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `teapickupschedules`
--
ALTER TABLE `teapickupschedules`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agricultural_officer`
--
ALTER TABLE `agricultural_officer`
  ADD CONSTRAINT `agricultural_officer_ibfk_1` FOREIGN KEY (`CenterID`) REFERENCES `supply_center` (`CenterID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `clerk`
--
ALTER TABLE `clerk`
  ADD CONSTRAINT `clerk_ibfk_1` FOREIGN KEY (`CenterID`) REFERENCES `supply_center` (`CenterID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cultivation`
--
ALTER TABLE `cultivation`
  ADD CONSTRAINT `cultivation_ibfk_1` FOREIGN KEY (`FarmerID`) REFERENCES `farmer` (`FarmerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cultivation_ibfk_2` FOREIGN KEY (`OfficerID`) REFERENCES `agricultural_officer` (`OfficerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `farmertasks`
--
ALTER TABLE `farmertasks`
  ADD CONSTRAINT `farmertasks_ibfk_1` FOREIGN KEY (`FarmerID`) REFERENCES `farmer` (`FarmerID`);

--
-- Constraints for table `fertilizerrequest`
--
ALTER TABLE `fertilizerrequest`
  ADD CONSTRAINT `fk_fertilizer_request_farmer` FOREIGN KEY (`farmerId`) REFERENCES `farmer` (`FarmerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fertilizer_request_fertilizer` FOREIGN KEY (`fertilizerId`) REFERENCES `fertilizer` (`FertilizerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fertilizer_request_land` FOREIGN KEY (`landId`) REFERENCES `cultivation` (`LandID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`FarmerID`) REFERENCES `farmer` (`FarmerID`) ON DELETE CASCADE;

--
-- Constraints for table `produce`
--
ALTER TABLE `produce`
  ADD CONSTRAINT `produce_ibfk_1` FOREIGN KEY (`FarmerID`) REFERENCES `farmer` (`FarmerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produce_ibfk_2` FOREIGN KEY (`ClerkID`) REFERENCES `clerk` (`ClerkID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questionnaireresponses`
--
ALTER TABLE `questionnaireresponses`
  ADD CONSTRAINT `questionnaireresponses_ibfk_1` FOREIGN KEY (`FarmerID`) REFERENCES `farmer` (`FarmerID`),
  ADD CONSTRAINT `questionnaireresponses_ibfk_2` FOREIGN KEY (`TemplateID`) REFERENCES `questionnairetemplates` (`TemplateID`);

--
-- Constraints for table `questionoptions`
--
ALTER TABLE `questionoptions`
  ADD CONSTRAINT `questionoptions_ibfk_1` FOREIGN KEY (`QuestionID`) REFERENCES `questions` (`QuestionID`);

--
-- Constraints for table `questionresponses`
--
ALTER TABLE `questionresponses`
  ADD CONSTRAINT `questionresponses_ibfk_1` FOREIGN KEY (`ResponseID`) REFERENCES `questionnaireresponses` (`ResponseID`),
  ADD CONSTRAINT `questionresponses_ibfk_2` FOREIGN KEY (`QuestionID`) REFERENCES `questions` (`QuestionID`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`TemplateID`) REFERENCES `questionnairetemplates` (`TemplateID`);

--
-- Constraints for table `receives`
--
ALTER TABLE `receives`
  ADD CONSTRAINT `receives_ibfk_1` FOREIGN KEY (`LandID`) REFERENCES `cultivation` (`LandID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `receives_ibfk_2` FOREIGN KEY (`FertilizerID`) REFERENCES `fertilizer` (`FertilizerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_ibfk_1` FOREIGN KEY (`FertilizerID`) REFERENCES `fertilizer` (`FertilizerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stores_ibfk_2` FOREIGN KEY (`CenterID`) REFERENCES `supply_center` (`CenterID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
