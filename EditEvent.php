<!DOCTYPE html>
<html>
<head>
   <title>Edit Event</title>
   <!-- Links Bootstrap 3 -->
   <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-inverse fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
        <a class="navbar-brand" >Inlook</a>
        </div>
        <ul class="nav navbar-nav">
        <li class="active"><a href="http://localhost/Coursework/BusinessDiarySystem/Homepage.php#">Home</a></li>
        <li><a href="LogoutProcess.Php">Log Out</a></li>
        </ul>
    </div>
    </nav>

    <?php
        session_start();
        if ($_SESSION["ID"] == NULL){
            header('Location: Login.php');
        }
        include_once("Connection.php");
        //echo($_POST['Event_ID'])."<br>";

        // gets details for selected events
        $sqlA = "SELECT * FROM tbl_events WHERE Event_ID ='".$_POST['Event_ID']."'"; 
        $query = $conn->query($sqlA);
        $arr_result = $query->fetch(PDO::FETCH_ASSOC);
        //print_r($arr_result);
        //echo("<br>");

        // gets particpants for selected event
        $sqlB = "SELECT tbl_users.User_Fullname as UFN, tbl_users.User_ID FROM tbl_usersinevents INNER JOIN tbl_users ON tbl_users.User_ID=tbl_usersinevents.User_ID WHERE Event_ID='".$_POST['Event_ID']."'"; // Gets all events current session user is participating in
        $query = $conn->query($sqlB);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $arr_User[] = $row; 
        }
        //print_r($arr_User);
    ?>


    <script type="text/javascript">
        // Script to hide/show ShowIfchecked div based on Radio ShowCheck
        function ShowHideCheck() {
            if (document.getElementById('ShowCheck').checked) {
                document.getElementById('ShowIfChecked').style.visibility = 'visible';
            }
            else document.getElementById('ShowIfChecked').style.visibility = 'hidden';
        }
    </script>

    <!-- Form for user inputs for editing event-->
    <div class="container-fluid">  
        <form action = "EditEventProcess.php" method = "POST">
                <!-- Text Inputs for Name and Desc -->
                <input name="EventID" type="hidden" value = <?php echo($_POST['Event_ID']);?> >
                Name: <input type="text" name="EventName" value= "<?Php echo($arr_result["Event_Name"])?>"><br>
                Description: <br> <textarea name="EventDesc" rows="4" cols="20" style="resize:none"><?Php echo($arr_result["Event_Description"])?></textarea><br>
                <!-- Radio w/ ShowCheck and HideCheck -->
                Type:
                <input type="radio" name="EventType" value=0 checked onclick="javascript:ShowHideCheck();" id="HideCheck"> Deadline 
                <input type="radio" name="EventType" value=1 onclick="javascript:ShowHideCheck();" id="ShowCheck"> Meeting<br> 
                <!-- Div hidden/Shown based on ShowHideCheck -->
                <div id="ShowIfChecked" style="visibility:hidden">
                    Location:<input type="text" name="EventLocation" value="<?Php echo($arr_result["Event_Location"])?>">
                </div>
                <!-- Time and Date inputs -->
                Date:<input type="date" name="EventDate" value="<?Php echo($arr_result["Event_Date"])?>"><br>
                Time:<input type="time" name="EventTime" value="<?Php echo($arr_result["Event_Time"])?>"><br>
                <!-- Input for Users in events -->
                <?php
                    echo("<br>Current Participants: ");
                        for ($user = 0; $user <= (sizeof($arr_User) - 1); $user++) {
                            echo($arr_User[$user]["UFN"].", ");
                        }
                    echo("<br>");
                ?>
                <select multiple name="Users[]">
                    <?php
                        include_once('Connection.php');
                        $stmt = $conn->prepare("SELECT * FROM Tbl_Users ORDER BY User_Fullname ASC");
                        $stmt->execute();

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo('<option value='.$row["User_ID"].'>'.$row["User_Fullname"].'</option>');
                        }
                    ?>
                </select>
                <br>
                Delete Event:
                <input type="radio" name="EventDelete" value=0 checked> No
                <input type="radio" name="EventDelete" value=1> Yes 
                <br> 
                <input class="btn btn-info" type="submit" value="Edit">   
        </form>
    </div>


</body>
</html>