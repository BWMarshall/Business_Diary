<?Php
session_start();
if ($_SESSION["ID"] == NULL){
    header('Location: Login.php');
}
//Create User Process - Runs SQL code to create a new users from posted values
include_once("Connection.php");

/* 
Debug posting checks
echo $_POST["Loginname"]."<br>"; 
echo $_POST["Password"]."<br>"; 
echo $_POST["Fullname"]."<br>"; 
echo $_POST["EmailAddress"]."<br>"; 
echo $_POST["EmailTime"]."<br>"; 
echo $_POST["EmailToggle"]."<br>"; 
echo $_POST["Role"]."<br>";
*/

//Hashes Password
$password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
echo $password; 

// Runs Sql Code
array_map("htmlspecialchars", $_POST);
$stmt = $conn->prepare("INSERT INTO tbl_users 
(User_ID, User_Loginname,User_Password, User_Fullname, Email_Address, Email_Time, Email_Toggle, User_Role) VALUES
(NULL, :Loginname, :Password, :Fullname, :EmailAddress, :EmailTime, :EmailToggle, :Role);");
 $stmt->bindParam(':Loginname', $_POST["Loginname"]);
 $stmt->bindParam(':Password', $password);
 $stmt->bindParam(':Fullname', $_POST["Fullname"]);
 $stmt->bindParam(':EmailAddress', $_POST["EmailAddress"]);
 $stmt->bindParam(':EmailTime', $_POST["EmailTime"]);
 $stmt->bindParam(':EmailToggle', $_POST["EmailToggle"]);
 $stmt->bindParam(':Role', $_POST["Role"]);
 $stmt->execute();
 $stmt->closeCursor();
 echo(" <br> User Created Successfully");

 // Header back to homepage
 header("location:Homepage.php");
?>
