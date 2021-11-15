<!DOCTYPE html>
<html>
    <head>
        <title>View Admin</title>
        <!-- Links Bootstrap 3 -->
        <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        
        <style>
            /* Popup container  */
            .popup {
                position: relative;
                display: inline-block;
                cursor: pointer;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            /* Popup text */
            .popup .popuptext {
                visibility: hidden;
                width: 160px;
                background-color: #555;
                color: #fff;
                text-align: center;
                border-radius: 6px;
                padding: 8px 0;
                position: absolute;
                z-index: 1;
                bottom: 125%;
                left: 50%;
                margin-left: -80px;
            }

            /* Popup arrow */
            .popup .popuptext::after {
                content: "";
                position: absolute;
                top: 100%;
                left: 50%;
                margin-left: -5px;
                border-width: 5px;
                border-style: solid;
                border-color: #555 transparent transparent transparent;
            }

            /* Toggle this class - hide and show the popup */
            .popup .show {
                visibility: visible;
            }
        </style>
    </head>
<body>   
<?php //Loads and sorts all event of current user into arr_events
    // Connects to DB and starts session---------------
    session_start();
    if ($_SESSION["ID"] == NULL){
        header('Location: Login.php');
    } else if ($_SESSION["Role"] == 0){
        header('Location: Homepage.php');
    }

    include_once("Connection.php");
    
    //Creates arr_events -> 2d array (0-4 = mon-fri)
    $arr_events = array(
        array(),array(),array(),array(),array()
    );

    
    //Gets Current Date and Time------------------------
    date_default_timezone_set("Europe/London");
    $current_date = "2021-09-06";//date("Y/m/d");
    $current_time =  date("h:ia");
    $current_day =    "m";//date('w');
    //echo($current_date )."<br>";
    //echo($current_time)."<br>";
    //echo($current_day)."<br>";
    //print_r($_SESSION);
    //echo '<br/><br/>';

    //Calculates which dates are in current week------------------------------
    $week = date("W", strtotime($current_date)); // get week   
    $y =    date("Y", strtotime($current_date)); // get year
    $week_start =  date('d-m-Y',strtotime($y."W".$week)); 
    $week_finish = date("d-m-Y",strtotime("+4 day", strtotime($week_start)));
    //echo($week_start)."<br>";
    //echo($week_finish)."<br><br>";

    //Queries DB for all events selected user is a participant then adds dates in current week to events array.--------------
    $sqlA = "SELECT Event_ID FROM tbl_usersinevents WHERE User_ID ='".$_POST["User"]."'";
    $result = $conn->query($sqlA);
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $sqlB = "SELECT * FROM tbl_events WHERE Event_ID ='".$row["Event_ID"]."'"; // Gets all events current selected user is participating in
            $query = $conn->query($sqlB);
            $arr_result = $query->fetch(PDO::FETCH_ASSOC);
            $Event_Date = ($arr_result["Event_Date"]);
            $Event_Timestamp = strtotime($Event_Date);
            //echo($Event_Date)."<br>";
            if ($Event_Timestamp >= strtotime($week_start) and $Event_Date <= strtotime($week_finish)) { //Places Events in Current week into arr_events
                $dayOfWeek = date("w", strtotime($Event_Date));
                //echo($dayOfWeek)."<br>";
                array_push($arr_events[($dayOfWeek - 1)], $arr_result);
            }
        }
    }  

    
     //Sorts Each days events by time
     for ($Day = 0; $Day <= (sizeof($arr_events) - 1); $Day++){ 
        for($i=0;$i<count($arr_events[$Day]);$i++){
            $val = $arr_events[$Day][$i];
            $j = $i-1;
            while($j>=0 && $arr_events[$Day][$j]["Event_Time"] > $val["Event_Time"]){
               $arr_events[$Day][$j+1] = $arr_events[$Day][$j];
               $j--;
            }
            $arr_events[$Day][$j+1] = $val;
         }
    }
?>


<!-- Navbar -->
<nav class="navbar navbar-inverse fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
        <a class="navbar-brand" >Inlook</a>
        </div>
        <ul class="nav navbar-nav">
        <li><a href="http://localhost/Coursework/BusinessDiarySystem/Homepage.php#">Home</a></li>
        <li class="active"><a href="AdminSelectModal" data-toggle="modal" data-target="#AdminSelectModal"><?php if($_SESSION["Role"]==1)echo("Admin");?></a></li>
        <li><a href="LogoutProcess.Php">Log Out</a></li>
        </ul>
    </div>
    </nav>


<?php //Preparing to display the diary
    $arr_daynames = ["Mon","Tues","Wed","Thu","Fri"];
    //print_r($arr_daynames);
    $sqlC = "SELECT User_Fullname FROM tbl_users WHERE User_ID = '".$_POST['User']."'";
    $query = $conn->query($sqlC);
    $selected_user = $query->fetch(PDO::FETCH_ASSOC);
?>

<div class="container-fluid">
    <h3> <?php echo($selected_user["User_Fullname"]); ?></h3>
    <table class="table table-bordered table-striped"> <!-- Displays the Diary -->
        <?php for ($i = 0; $i <= 4; $i++): ?> 
            <tr>
                <th><?php echo($arr_daynames[$i]) ?></th>
                    <?php foreach ($arr_events[$i] as $Event) :?>
                        <td>
                            <div class="popup" onclick="togglepopup(<?php echo($Event['Event_ID']) ?>)"><?php echo($Event['Event_Name']. "<br>". $Event["Event_Time"]); ?>
                                <span class="popuptext " id="<?php echo($Event['Event_ID']) ?>"> <!-- Pop-up Content -->
                                    <?php echo($Event["Event_Name"]. "<br>". $Event["Event_Date"]. " " . $Event["Event_Time"]. "<br>". $Event["Event_Location"]. "<br>". $Event["Event_Description"]. "<br>"); ?>
                                </span>
                            </div>    
                        </td>
                    <?php endforeach;?>
            </tr>
        <?php endfor;?>
    </table>
</div>

<script> //Toggles Pop-up Visability
    // When the user clicks on div, open the popup
    function togglepopup(Event_ID) {
    var popup = document.getElementById(Event_ID);
        popup.classList.toggle("show");
    }
</script>
    

<!-- Admin Select Modal -->
<div id="AdminSelectModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Admin Select</h4>
      </div>
      <div class="modal-body">
        <h5> Select diary to view</h5>
        <form action="AdminView.php" method = "POST">
            <select name="User">
                <?php
                    include_once('Connection.php');
                    $stmt = $conn->prepare("SELECT * FROM Tbl_Users ORDER BY User_Fullname ASC");
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo('<option value='.$row["User_ID"].'>'.$row["User_Fullname"].'</option>');
                    }
                ?>
            </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input class="btn btn-info" type="submit" value="View">
      </div>
    </div>

  </div>
</div>

</body>
</html>