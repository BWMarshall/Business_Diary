<?php
/// Login Process - takes posted inputs and checks validity 
// Connect to DB
session_start();
include_once("Connection.php");
echo($_POST['Username'])."<br>";
echo($_POST['Password'])."<br>";
array_map("htmlspecialchars", $_POST);

//Query with posted Username
$stmt = $conn->prepare("SELECT * FROM tbl_users WHERE User_Loginname =:username");
$stmt->bindParam(':username', $_POST['Username']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
// Check if user exists
if (!$row) {
    header('Location: Login.php');
} else {
    echo($row['User_Password'])."<br>";
    $hashed= $row['User_Password'];
    $attempt= $_POST['Password'];
// Check Password - Directs to Homepage if valid, Directs to Login if invalid
    if(password_verify($attempt,$hashed)){  
        $_SESSION['Role']=$row['User_Role'];
        $_SESSION['Username']=$_POST['Username'];
        $_SESSION['ID'] = $row['User_ID'];
        print_r($_SESSION)."<br>";
        header('Location: Homepage.php');
    }else{
        header('Location: Login.php');
    }
}  

$conn=null;

?>