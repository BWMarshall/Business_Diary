<!-- Temporary Create USer inputs page to be implemented on Homepage -->
<!DOCTYPE html>
<html>
<head>
    
    <title>Create User</title>
    
  
</head>
<body>
    <!-- Form to collect Create User data - Posts it through to Create User Process -->
    <form action="CreateUserProcess.php" method = "POST"> 
        <!-- Text Inputs -->
        <input type="text" name="Loginname" placeholder="Username"><br>
        <input type="password" name="Password" placeholder="Password"><br>  
        <input type="text" name="Fullname" placeholder="Fullname"><br> 
        <input type="text" name="EmailAddress" placeholder="Email Address"><br>  
        <!--Time Inputs -->
        Email Time:<input type="time" name="EmailTime"><br>
        <!--Email Toggle -->
        Recieve Emails:
        <input type="radio" name="EmailToggle" value=1 checked> Yes
        <input type="radio" name="EmailToggle" value=0 > No <br>
        <!--Role Radio -->
        Role:
        <input type="radio" name="Role" value=0 checked> Employee 
        <input type="radio" name="Role" value=1> Admin<br> 
        <!-- Submit -->
        <input type="submit" value="Create User">  
    </form>  


</body>
</html>