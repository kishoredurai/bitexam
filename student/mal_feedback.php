<?php



include('../master/Examination.php');
$exam = new Examination;

$exam->user_session_private();

include('../include/user_header.php');

require_once '../include/db.php';

include('../include/db.php');

$examid=intval($_GET['examid']);

if(isset($_POST['change']))
{ 

$id = $_SESSION['user_id'];
$reason=$_POST['reason'];

$result = mysqli_query($db,"Insert into `malpractice_feedback`(user_id,exam_id,feedback) VALUES ('$id','$examid','$reason');");

echo '<script>alert("Feedback Updated")</script>';

echo "<script>window.location.href='index.php'</script>"; 

}


?>


<link href="../style/button.css" rel="stylesheet" type="text/css">
<hr>
  <div class="container">

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
                <form method="post" id="user_login_form">
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


