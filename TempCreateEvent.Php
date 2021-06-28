<!-- Temporary Create Events inputs page to be implemented on Homepage -->
<!DOCTYPE html>
<html>
<head>
    <title>Create Event</title>
</head>
<body>
    <!-- Form to collect Create User data - Posts it through to Create Event Process -->
    <form action="CreateEventProcess.php" method = "POST"> 
        <input type="text" name="EventName" placeholder="Event name"><br>
        <textarea name="EventDesc" rows="4" cols="20" style="resize:none" placeholder="Brief Description"></textarea><br>
        Type:
        <input type="radio" name="EventType" value=0 checked> Deadline 
        <input type="radio" name="EventType" value=1> Meeting<br> 
        Date:<input type="date" name="EmailDate"><br>
        Time:<input type="time" name="EmailTime"><br>
        Location:<input type="text" name="EventLocation" placeholder="Meeting Link?"><br>
        <input type="submit" value="Create Event">  
    </form>  


</body>
</html>
