<!-- Login page - for recieving users inputs then posting through to login Process  -->
<!DOCTYPE html>
<html>
<head>
   <title>Login</title>
</head>
<body>
<h1>Log In</h1> 

<br>
<!--Login Input and post -->
<form action = "LoginProcess.php" method = "POST">
    <div class="input-group">
        <input  type="text" class="form-control" name="Username" placeholder="Username">
    </div>
    <div class="input-group">
        <input id="Password" type="password" class="form-control" name="Password" placeholder="Password">
    </div>
    <br>
    <button type="submit">Login</button>
</form>
           

</body>
</html>