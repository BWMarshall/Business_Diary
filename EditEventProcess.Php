<?php // Create User Process - creates the event from posted inputs and adds participants
    include_once("Connection.php");

    // Debug Checks
    echo($_POST["EventID"])."<br>";
    echo($_POST["EventName"])."<br>";
    echo($_POST["EventDesc"])."<br>";
    echo($_POST["EventType"])."<br>";
    echo($_POST["EventLocation"])."<br>";
    echo($_POST["EventDate"])."<br>";
    echo($_POST["EventTime"])."<br>";
    echo($_POST["EventDesc"])."<br>";
    print_r($_POST['Users'])."<br>";

    if ($_POST["EventType"] == 0){
        $_POST["EventLocation"] = "Deadline";

    }

    //Deletes all participants
    $stmtA = "DELETE FROM tbl_usersinevents WHERE Event_ID ='".$_POST["EventID"]."'";
    $query = $conn->query($stmtA);

    //Updates Event
    $stmtB = "UPDATE tbl_events 
    SET Event_Name ='".$_POST["EventName"]."', 
    Event_Type ='".$_POST["EventType"]."',
    Event_Location ='".$_POST["EventLocation"]."',
    Event_Time ='".$_POST["EventTime"]."',
    Event_Date ='".$_POST["EventDate"]."', 
    Event_Description ='".$_POST["EventDesc"]."'
    WHERE Event_ID ='".$_POST["EventID"]."'";
    $query = $conn->query($stmtB);


    
    //writes participants and events together in user in events table
    foreach ($_POST["Users"] as $User) {
        $stmtC = $conn->prepare("INSERT INTO tbl_usersinevents 
        (Event_ID, User_ID) VALUES(:EventID, :UserID);");
        $stmtC->bindParam(':EventID', $_POST["EventID"]);
        $stmtC->bindParam(':UserID', $User);
        $stmtC->execute();
        $stmtC->closeCursor();
        echo($User ."Added to ". $_POST["EventID"] ."<br>");
    } 
    
    // Header back to homepage
    header("location:Homepage.php");
?>