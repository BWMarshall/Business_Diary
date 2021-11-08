<?php
include_once("Connection.php");
date_default_timezone_set("Europe/London");
$current_date = "2021-09-06";//date("Y/m/d");
$current_time =  "16:30";//date("G:i");
echo($current_time)."<br>";
$current_time = "".$current_time.":00";
echo($current_time)."<br>";

$arr_emailstosend = [];

$sqlA = "SELECT User_ID,User_Fullname,Email_Address,Email_Time FROM tbl_users WHERE Email_Time = '".$current_time."' AND Email_Toggle = '1'";
$result = $conn->query($sqlA);
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        array_push($arr_emailstosend,$row);
    }
}
print_r($arr_emailstosend);
echo("<br>");

require_once("PHPMailer/PHPMailerAutoLoad.php");

foreach ($arr_emailstosend as $User) {
    //Queries DB for all events  user is a participant then adds dates in current day to events array.--------------
    $arr_events = [];
    $sqlA = "SELECT Event_ID FROM tbl_usersinevents WHERE User_ID ='".$User["User_ID"]."'";
    $result = $conn->query($sqlA);
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $sqlB = "SELECT * FROM tbl_events WHERE Event_ID ='".$row["Event_ID"]."'"; // Gets all events current session user is participating in
            $query = $conn->query($sqlB);
            $arr_result = $query->fetch(PDO::FETCH_ASSOC);
            $Event_Date = ($arr_result["Event_Date"]);
            $Event_Timestamp = strtotime($Event_Date);
            //echo($Event_Date)."<br>";
            if ($Event_Timestamp == strtotime($current_date)) { //Places Events in Current week into arr_events
                array_push($arr_events, $arr_result);
            }
        }
    }
    print_r($arr_events);
    echo("<br>");


    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tsl1.3';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '587';
    $mail->isHTML();
    $mail->Username = 'mailer.marshall@gmail.com';
    $mail->Password = 'MailerPword123';
    //$mail->SetFrom() = 'no-reply@inlook.com';
    $mail->Subject = 'Test';
    $mail->Body = 'Test Message';
    $mail->AddAddress("marshall.bw@oundleschool.org.uk");

    $mail->Send();





}
?>