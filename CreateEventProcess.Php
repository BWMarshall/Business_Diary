<?php // Create User Process - creates the event from posted inputs and adds participants
    include_once("Connection.php");

    // Debug Checks
    echo($_POST["EventName"])."<br>";
    echo($_POST["EventDesc"])."<br>";
    echo($_POST["EventType"])."<br>";
    echo($_POST["EventLocation"])."<br>";
    echo($_POST["EventDate"])."<br>";
    echo($_POST["EventTime"])."<br>";
    print_r($_POST['Users'])."<br>";

    if ($_POST["EventType"] == 0){
        $_POST["EventLocation"] = "Deadline";

    }
    //Write event to events table
    $stmt = $conn->prepare("INSERT INTO tbl_Events 
    (Event_ID, Event_Name,Event_Type, Event_Description, Event_Date, Event_Time, Event_Location) VALUES
    (NULL, :EventName, :EventType, :EventDesc, :EventDate, :EventTime, :EventLocation);");
    $stmt->bindParam(':EventName', $_POST["EventName"]);
    $stmt->bindParam(':EventDesc', $_POST["EventDesc"]);
    $stmt->bindParam(':EventType', $_POST["EventType"]);
    $stmt->bindParam(':EventLocation', $_POST["EventLocation"]);
    $stmt->bindParam(':EventDate', $_POST["EventDate"]);
    $stmt->bindParam(':EventTime', $_POST["EventTime"]);
    $stmt->execute();  
    $stmt->closeCursor();
    $id = $conn->lastInsertId();
    echo(" <br> Event Created Successfully <br>");
    echo($id."<br>");
    
    //writes participants and events together in user in events table
    foreach ($_POST["Users"] as $User) {
    $stmtB = $conn->prepare("INSERT INTO tbl_usersinevents 
    (Event_ID, User_ID) VALUES(:EventID, :UserID);");
    $stmtB->bindParam(':EventID', $id);
    $stmtB->bindParam(':UserID', $User);
    $stmtB->execute();
    $stmtB->closeCursor();
    echo($User ."Added to ". $id ."<br>");
    } 
    
    // Needs a header when implemented Properly
?>


