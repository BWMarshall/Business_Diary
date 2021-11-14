<!-- Login page - for recieving users inputs then posting through to login Process  -->
<!DOCTYPE html>
<html>
<head>
   <title>Login</title>
   <!-- Links Bootstrap 3 -->
   <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <h2>Inlook</h2>
            <!--Login Input and post -->
            <form action = "LoginProcess.php" method = "POST">
                <div> 
                    <input  type="text" class="form-control" name="Username" placeholder="Username">
                </div>
                <div>
                    <input id="Password" type="password" class="form-control" name="Password" placeholder="Password">
                </div>
                <div>
                    <button type="submit btn-default">Login</button>
                </div>
            </form>
        </div>
    </div>
            

</body>
</html>