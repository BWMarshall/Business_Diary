<?php
include_once("Connection.php");
echo($_POST['Username']);
echo($_POST['Password']);
echo($hashed_password);
array_map("htmlspecialchars", $_POST);

$stmt = $conn->prepare("SELECT * FROM tbl_users WHERE User_Loginname =:username");
$stmt->bindParam(':username', $_POST['Username']);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
    echo($row['User_Password']);
    $hashed= $row['User_Password'];
    $attempt= $_POST['Password'];
    if(password_verify($attempt,$hashed)){  
        $_SESSION['Role']=$row['User_Role'];
        $_SESSION['Name']=$_POST['Username'];
        header('Location:  Homepage.php');
    }else{
        header('Location: Login.php');
    }
}
$conn=null;
?>