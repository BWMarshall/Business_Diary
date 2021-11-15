<?php 
/// Logout - resets session variables and directs to Login Page
 //Starts session and validates User---------------
 session_start();
 if ($_SESSION["ID"] == NULL){
     header('Location: Login.php');
 }

 $_SESSION['ID'] = NULL;
 $_SESSION['Role'] = NULL;
 $_SESSION['Username'] = NULL;

 header('Location: Login.php');

?>