<?php



include('../master/Examination.php');
$exam = new Examination;

$exam->user_session_private();

include('../include/user_header.php');

require_once '../include/db.php';

include('../include/db.php');

$id = $_SESSION['user_id'];
$examid=intval($_GET['examid']);
$user_id="";
$exam->query ="Select * from malpractice_feedback where exam_id = '$examid';";
$results = $exam->query_result();
foreach($results as $rows)
{
    $user_id=$rows["user_id"];
    
}

if($user_id==$id)
{
    echo '<script>alert("Feedback Already Updated")</script>';

    echo "<script>window.location.href='enroll_exam.php'</script>";  
}

if(isset($_POST['change']))
{ 


$reason=$_POST['Reason'];

$result = mysqli_query($db,"Insert into `malpractice_feedback`(user_id,exam_id,feedback) VALUES ('$id','$examid','$reason');");

echo '<script>alert("Feedback Updated")</script>';

echo "<script>window.location.href='enroll_exam.php'</script>"; 

}


?>


<link href="../style/button.css" rel="stylesheet" type="text/css">


<br>
  <div class="container">
  <h1 style="align-content: center;font-size:50px;font-family:cursive;" align="center">Exam Feedback</h1><br>

      <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6" style="margin-top:50px;">
          

            <span id="message">
            </span>
            <div class="card border border-success">
            <div class="card-header">Exam Feedback
                       </div>
              <!-- <div class="card-header" style="font-family:comic sans MS;color:blue;font-size:larger;"><center>Student Login</center></div> -->
              <div class="card-body">
                <form method="post" id="mal_feedback">
                  <div class="form-group">
                    <label style="top:5px;">Exam ID : </label>
                    <div style="margin-bottom: 25px;top:5px" class="input-group" >
                                        <input class="form-control"  type="text"  placeholder="<?php echo $examid ?>" disabled> 
                                                                      
                                    </div>                           
                    </div>
                  <div class="form-group">
                    <label>Reason for malpractice : </label>
                    <div style="margin-bottom: 15px" class="input-group">
                                        <textarea requiredtype="text" rows="5" cols="10" class="form-control" name="Reason" placeholder="Please Enter Reason"></textarea>
                                    </div>
                                    
                  </div>
                  
                  <div class="form-group" align="center">
                    <br>
                    <input type="submit" name="change" id="user_login" class="btn success" value=" Update " />&nbsp;
                    <a class="btn blue" href="index.php">Back</a>
                  </div>
                </form>
               
                  
                
              </div>
            </div>
        </div>
        <div class="col-md-3">

        </div>
      </div>
  </div>

</body>
</html>


