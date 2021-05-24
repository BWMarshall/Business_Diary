<?php
$servername = 'localhost';
$username = 'root';
$password= '';
try {
 $conn = new PDO("mysql:host=$servername", $username, $password);
 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 $sql = "CREATE DATABASE IF NOT EXISTS BusinessDiary";
 $conn->exec($sql);
 $sql = "USE BusinessDiary";
 $conn->exec($sql);
 echo "DB created successfully";
}
catch(PDOException $e) {
 echo $sql . "<br>" . $e->getMessage();
}


$stmt = $conn->prepare("DROP TABLE IF EXISTS Tbl_Events;
CREATE TABLE Tbl_Events
(Event_ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Event_Type TINYINT(1) NOT NULL,
Event_Name VARCHAR(20) NOT NULL,
Event_Location VARCHAR(4),
Event_Time TIME(0) NOT NULL,
Event_Date DATE NOT NULL,
Event_Description TEXT(256))");
$stmt->execute();
$stmt->closeCursor();



$stmt = $conn->prepare("DROP TABLE IF EXISTS Tbl_Users;
CREATE TABLE Tbl_Users 
(User_ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
User_Loginname VARCHAR(20) NOT NULL,
User_Password VARCHAR(200) NOT NULL,
User_Fullname VARCHAR(20) NOT NULL,
Email_Address VARCHAR(50) NOT NULL,
Email_Time Time(0) NOT NULL,
Email_Toggle BOOL NOT NULL,
User_Role TINYINT(1))");
$stmt->execute();
$stmt->closeCursor();



$stmt = $conn->prepare("DROP TABLE IF EXISTS Tbl_Usersinevents;
CREATE TABLE Tbl_Usersinevents
(User_ID INT(6),
Event_ID INT(6),
Event_User_Desc text(256),
PRIMARY KEY(User_ID,Event_ID))");
$stmt->execute();
$stmt->closeCursor();


$stmt = $conn->prepare("INSERT INTO `tbl_users` (`User_ID`, `User_Loginname`, `User_Password`, `User_Fullname`, `Email_Address`, `Email_Time`, `Email_Toggle`, `User_Role`) VALUES
 (NULL, 'Admin', 'Admin', 'Admin', 'Admin@example.com', '00:00:00', '0', '1');")
 echo("Admin User created")



?>