<!-- Temporary Create Events inputs page to be implemented on Homepage -->
<!DOCTYPE html>
<html>
<head>
    <title>Create Event</title>

 
<script type="text/javascript">
// Script to hide/show ShowIfchecked div based on Radio ShowCheck
function ShowHideCheck() {
    if (document.getElementById('ShowCheck').checked) {
        document.getElementById('ShowIfChecked').style.visibility = 'visible';
    }
    else document.getElementById('ShowIfChecked').style.visibility = 'hidden';
}
</script>


</head>
<body>    
    <!-- Form to collect Create User data - Posts it through to Create Event Process -->
    <form action="CreateEventProcess.php" method = "POST"> 
        <!-- Text Inputs for Name and Desc -->
        <input type="text" name="EventName" placeholder="Event name"><br>
        <textarea name="EventDesc" rows="4" cols="20" style="resize:none" placeholder="Brief Description"></textarea><br>
        
        <!-- Radio w/ ShowCheck and HideCheck -->
        Type:
        <input type="radio" name="EventType" value=0 checked onclick="javascript:ShowHideCheck();" id="HideCheck"> Deadline 
        <input type="radio" name="EventType" value=1 onclick="javascript:ShowHideCheck();" id="ShowCheck"> Meeting<br> 
        <!-- Div hidden/Shown based on ShowHideCheck -->
        <div id="ShowIfChecked" style="visibility:hidden">
            Location:<input type="text" name="EventLocation" placeholder="Meeting Link?">
        </div>
        
        <!-- Time and Date inputs -->
        Date:<input type="date" name="EventDate"><br>
        Time:<input type="time" name="EventTime"><br>
        
        <!-- Input for Users in events -->
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
        
        <input type="submit" value="Create Event"> 
    </form>  


        
        
       
   

    
   




</body>
</html>
