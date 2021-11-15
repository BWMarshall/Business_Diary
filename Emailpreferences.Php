<?php //Updates the user's email preferences
//Starts session and validates User---------------
session_start();
if ($_SESSION["ID"] == NULL){
    header('Location: Login.php');
}
include_once("Connection.php");

// Updates DB with posted values
$stmtA = "UPDATE tbl_users 
    SET Email_Toggle ='".$_POST["EmailToggle"]."', 
    Email_Time ='".$_POST["EmailTime"]."'
    WHERE User_ID ='".$_SESSION["ID"]."'";
    $query = $conn->query($stmtA);

echo("Preferences Updated");

header('Location: Homepage.php');

?>



