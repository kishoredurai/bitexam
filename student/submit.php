<?php

include('../master/Examination.php');

$exam = new Examination;

$exam->user_session_private();

include('../include/db.php');
require_once '../include/db.php';

if(intval($_GET['del']))
{
$examid=intval($_GET['del']);
$id = $_SESSION['user_id'];          
$exam->query ="Select * from user_table where user_id= '$id';";
$results = $exam->query_result();
foreach($results as $rows)
{
    $receiver_email=$rows["user_email_address"];
    $user_name=$rows["user_name"];
}

$subject="Online Examination Application";

$body = '<html><body><head>       
    <meta name="viewport" content="width=device-width, initial-scale=1"></head>
    <center><img src="https://img.collegedekhocdn.com/media/img/institute/logo/BIT-Tamilnadu-logo_1.png" width="750" height="160" ></center><br>
    <h3 style="font-size:180%;color:black;">Dear <b>'.$user_name.',</b></h3><p style="font-size:150%;"> Your Exam has been logged out as you have violated the rules for the online examination. Kindly provide the reason for violation in the <a href="http://localhost/bitexam/student/mal_feedback.php?examid='.$examid.'">link</a> </p>
    <p style="font-size:150%;color:black;"><b>Thank you,</b></p>
	<p style="font-size:150%;color:black;">BIT Online Examination System</p>
    </body></html>';

$sql= "UPDATE user_exam_enroll_table SET exam_status='Completed',attendance_status='Present' ,remark='tabswitching',exam_outtime=CURRENT_TIMESTAMP() WHERE user_id = $id and exam_id= $examid;";
$result = mysqli_query($db, $sql);
echo "<script>window.location.href='index.php'</script>";  

$exam->send_email($receiver_email,$subject,$body);
}


if(intval($_GET['id']))
{	
$examid=intval($_GET['id']);
$id = $_SESSION['user_id'];
$sql= "UPDATE user_exam_enroll_table SET exam_status='Completed',attendance_status='Present',remark='submitted',exam_outtime=CURRENT_TIMESTAMP() WHERE user_id = $id and exam_id= $examid;";
$result = mysqli_query($db, $sql);
}

echo "<script>window.location.href='index.php'</script>";  
?>
