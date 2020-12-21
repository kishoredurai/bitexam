<?php
    include('master/Examination.php');

    $exam = new Examination;

    $exam->user_session_public();

if (!isset($_GET['token'])) {
    $res['err'] = 'Token not found!';
    die(json_encode($res));
}

function verifyToken($token): string
{
    try {
        $js = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v2/tokeninfo?id_token=' . $token), true);
        $email = $js["email"];
        return $email;
    } catch (Exception $e) {
        die($e);
    }
    return null;
}

$mail = verifyToken($_GET['token']);

//echo 'logged in as ' . $mail;

$exam->data = array(
    ':user_email_address'	=>	$mail
);

$exam->query = "SELECT * FROM user_table WHERE user_email_address = :user_email_address	";


$total_row = $exam->total_row();

if($total_row > 0)
{
				
$result = $exam->query_result();

foreach($result as $row)
{
    $_SESSION['user_id'] = $row['user_id'];
    $output = array(
        'success'	=>	true
    );
    echo "<script>window.location.href='student/index.php'</script>"; 
}
}




/// staff user checking




$exam->query = "SELECT * FROM admin_table WHERE admin_email_address = :user_email_address	";

$total_rows = $exam->total_row();

if($total_rows > 0)
{
				
$result = $exam->query_result();

foreach($result as $row)
{
    $_SESSION['admin_id'] = $row['admin_id'];
    $output = array(
        'success'	=>	true
    );
    echo "<script>window.location.href='master/index.php'</script>"; 
}
}
else
{
    echo "<script type='text/javascript'>swal('Email ID Does not exsist');</script>";

    echo "<script>window.location.href='login.php'</script>"; 
}