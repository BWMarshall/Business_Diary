<?php
include_once("Connection.php");

//Gets Current Date and Time--------------------------------
date_default_timezone_set("Europe/London");
$current_date = "2021-09-06";//date("Y/m/d");
$current_time =  "16:30";//date("G:i");
//echo($current_time)."<br>";
$current_time = "".$current_time.":00";
//echo($current_time)."<br>";

//Queries the DB for any users needing to be sent emails at the current time then adds them to emailtobesent array----------
$arr_emailstosend = [];
$sqlA = "SELECT User_ID,User_Fullname,Email_Address,Email_Time FROM tbl_users WHERE Email_Time = '".$current_time."' AND Email_Toggle = '1'";
$result = $conn->query($sqlA);
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        array_push($arr_emailstosend,$row);
    }
}
//print_r($arr_emailstosend);
//echo("<br>");

//Links in email library---------------------------------------
require_once("PHPMailer/PHPMailerAutoLoad.php");

foreach ($arr_emailstosend as $User) {
    //Queries DB for all events user is a participant then adds events in current day to events array.--------------
    $arr_events = [];
    $sqlA = "SELECT Event_ID FROM tbl_usersinevents WHERE User_ID ='".$User["User_ID"]."'";
    $result = $conn->query($sqlA);
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $sqlB = "SELECT * FROM tbl_events WHERE Event_ID ='".$row["Event_ID"]."'"; 
            $query = $conn->query($sqlB);
            $arr_result = $query->fetch(PDO::FETCH_ASSOC);
            $Event_Date = ($arr_result["Event_Date"]);
            $Event_Timestamp = strtotime($Event_Date);
            //echo($Event_Date)."<br>";
            if ($Event_Timestamp == strtotime($current_date)) { //pushes events for the day onto the events array
                array_push($arr_events, $arr_result);
            }
        }
    }
    //print_r($arr_events);
    //echo("<br>");


    //Creates the content for the email------------------------------------
    $table_content = "";
    foreach ($arr_events as $event){
            $table_content = $table_content . "
            <tr> 
                <td>".$event["Event_Name"]."</td> 
                <td>".$event["Event_Time"]."</td> 
                <td>".$event["Event_Description"]."</td> 
            </tr>";
    }
    //echo($table_content);


    //Carries out the mail Php function------------------------------
    // Smtp settings - change when uploaded to server
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tsl1.3';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '587';
    $mail->isHTML();
    $mail->Username = 'mailer.marshall@gmail.com';
    $mail->Password = 'MailerPword123';
    
    //Email Contents
    $mail->Subject = "Diary for ".$current_date."";
    $mail->Body = '<html>
    <body>
      <p> Events on '.$current_date.'</p>
      <table>
        <tr>
            <th>Name</th><th>Time</th><th>Description</th>
        </tr>
         '.$table_content.'
      </table>
    </body>
    </html>';
    //Recipients
    $mail->AddAddress($User["Email_Address"]);
    
    $mail->Send();
    echo("Email Successfully sent to ".$User["Email_Address"]."<br>");



}

?>