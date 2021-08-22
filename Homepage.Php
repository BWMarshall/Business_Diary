<!-- Homepage for website - displays diary and provides navigation around site - main landind page-->
<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
</head>

<body>    
<?php //Displays Diary
    // Connects to DB and starts session---------------
    session_start();
    include_once("Connection.php");
    
    //Creates arr_events -> 2d array (0-4 = mon-fri)
    $arr_events = array(
        array(),array(),array(),array(),array()
    );

    
    //Gets Current Date and Time------------------------
    date_default_timezone_set("Europe/London");
    $current_date = "2021-07-27"; //date("Y/m/d");
    $current_time = date("h:ia");
    $current_day = 2;//date('w');
    echo($current_date )."<br>";
    echo($current_time)."<br>";
    echo($current_day)."<br>";
    print_r($_SESSION);
    echo '<br/><br/>';

    //Calculates which dates are in current week------------------------------
    $week = date("W", strtotime($current_date)); // get week   
    $y =    date("Y", strtotime($current_date)); // get year
    $week_start =  date('d-m-Y',strtotime($y."W".$week)); 
    $week_finish = date("d-m-Y",strtotime("+4 day", strtotime($week_start)));
    echo($week_start)."<br>";
    echo($week_finish)."<br><br>";

    //Queries DB for all events session user is a participant then adds dates in current week to events array.--------------
    $sqlA = "SELECT Event_ID FROM tbl_usersinevents WHERE User_ID ='".$_SESSION["ID"]."'";
    $result = $conn->query($sqlA);
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $sqlB = "SELECT * FROM tbl_events WHERE Event_ID ='".$row["Event_ID"]."'"; // Gets all events current session user is participating in
            $query = $conn->query($sqlB);
            $arr_result = $query->fetch(PDO::FETCH_ASSOC);
            $Event_Date = ($arr_result["Event_Date"]);
            $Event_Timestamp = strtotime($Event_Date);
            echo($Event_Date)."<br>";
            if ($Event_Timestamp >= strtotime($week_start) and $Event_Date <= strtotime($week_finish)) { //Places Events in Current week into arr_events
                $dayOfWeek = date("w", strtotime($Event_Date));
                echo($dayOfWeek)."<br>";
                array_push($arr_events[($dayOfWeek - 1)], $arr_result);
            }
        }
    }
    print_r($arr_events);
    echo '<br/>';
    foreach($arr_events[2] as &$value) {
        asort($value, SORT_TIME);
    }
?>

<table>
    <tr>
        <th>Mon</th>
            <?php foreach ($arr_events[0] as $Event) :?>
                    <td><?php echo($Event["Event_Name"]); ?></td>
                    <td><?php echo($Event["Event_Time"]); ?></td>
            <?php endforeach;?>
    </tr>
    <tr>
        <th>Tue</th>
        <?php foreach ($arr_events[1] as $Event) :?>
                    <td><?php echo($Event["Event_Name"]); ?></td>
                    <td><?php echo($Event["Event_Time"]); ?></td>
            <?php endforeach;?>
    </tr>
    <tr>
        <th>Wed</th>
        <?php foreach ($arr_events[2] as $Event) :?>
                    <td><?php echo($Event["Event_Name"]); ?></td>
                    <td><?php echo($Event["Event_Time"]); ?></td>
            <?php endforeach;?>
    </tr>
    <tr>
        <th>Thu</th>
        <?php foreach ($arr_events[3] as $Event) :?>
                    <td><?php echo($Event["Event_Name"]); ?></td>
                    <td><?php echo($Event["Event_Time"]); ?></td>
            <?php endforeach;?>
    </tr>
    <tr>
        <th>Fri</th>
        <?php foreach ($arr_events[4] as $Event) :?>
                    <td><?php echo($Event["Event_Name"]); ?></td>
                    <td><?php echo($Event["Event_Time"]); ?></td>
            <?php endforeach;?>
    </tr>
</table>


</body>
</html>