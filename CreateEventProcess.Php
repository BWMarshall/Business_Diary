<?php 
    include_once("Connection.php");

    // Debug Checks
    echo($_POST["EventName"])."<br>";
    echo($_POST["EventDesc"])."<br>";
    echo($_POST["EventType"])."<br>";
    echo($_POST["EventLocation"])."<br>";
    echo($_POST["EventDate"])."<br>";
    echo($_POST["EventTime"])."<br>";
    print_r($_POST['Users'])."<br>";


    //Write event to database
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
    echo(" <br> Event Created Successfully <br>");
    


  

    //Finds Event Created
    $stmtA = $conn->prepare("SELECT Event_ID FROM tbl_Events WHERE Event_Name=:EventName AND Event_Type = :EventType AND Event_Description = :EventDesc AND Event_Date = :EventDate AND Event_Time = :EventTime AND Event_Location = :EventLocation");
    $stmtA->bindParam(':EventName', $_POST['EventName']);
    $stmtA->bindParam(':EventDesc', $_POST["EventDesc"]);
    $stmtA->bindParam(':EventType', $_POST["EventType"]);
    $stmtA->bindParam(':EventLocation', $_POST["EventLocation"]);
    $stmtA->bindParam(':EventDate', $_POST["EventDate"]);
    $stmtA->bindParam(':EventTime', $_POST["EventTime"]);
    $stmtA->execute();
    $result = $stmtA->fetchAll(\PDO::FETCH_ASSOC);
    print_r($result);
  

    // foreach ($_POST["Users"] as $User) {
    // $stmtB = $conn->prepare("INSERT INTO tbl_usersinevents 
    // (Event_ID, User_ID VALUES(:EventID, :UserID);");
    // $stmtB->bindParam(':EventID', $Event);
    // $stmtB->bindParam(':UserID', $User);
    // $stmtB->execute();
    // $stmtB->closeCursor();
    // echo($User ."Added to ". $Event ."<br>");
    // } 
    
    // Needs a header when implemented Properly
?>


