<?php
/// Login Process - takes posted inputs and checks validity 
// Connect to DB
include_once("Connection.php");
echo($_POST['Username']);
echo($_POST['Password']);
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
    echo($row['User_Password']);
    $hashed= $row['User_Password'];
    $attempt= $_POST['Password'];
// Check Password
    if(password_verify($attempt,$hashed)){  
        $_SESSION['Role']=$row['User_Role'];
        $_SESSION['Name']=$_POST['Username'];
        header('Location: Homepage.php');
    }else{
        header('Location: Login.php');
    }
}  

$conn=null;

?>