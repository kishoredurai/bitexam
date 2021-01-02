<?php

//login.php

include('../master/Examination.php');
$exam = new Examination;

$exam->user_session_private();

include('../include/user_header.php');

require_once '../include/db.php';

include('../include/db.php');


if (isset($_POST['feed'])) {

    $alert='swal("Good job!", "You clicked the button!", "success");';
        echo "<script type='text/javascript'>'$alert'</script>";
        
        sleep(3);

    $id = $_SESSION['user_id'];
    $type = $_POST['type'];
    $feedback = $_POST['feedback'];
    $profilename = $_FILES["f_image"]['name'];
    $profiletmpname = $_FILES["f_image"]['tmp_name'];
//$profilename=$profiletmpname.$id;

move_uploaded_file($profiletmpname, '../feedback_image/'.$profilename);

        $result = mysqli_query($db, "INSERT INTO `feedback_table`(`user_id`, `feed_type`, `feed`,`feed_image` ) values ('$id','$type','$feedback','$profilename');");

        

        echo "<script>window.location.href='feedback.php'</script>"; 

    } 
?>
<br><Br><br>
<link href="../style/button.css" rel="stylesheet" type="text/css">

<div class="container">

    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6" style="margin-top:50px;">


            <span id="message">
              
            </span>
            <div class="card border border-success">
                <div class="card-header">Feedback Add
                </div>
                <!-- <div class="card-header" style="font-family:comic sans MS;color:blue;font-size:larger;"><center>Student Login</center></div> -->
                <div class="card-body">
                    <form method="post" role="form" enctype="multipart/form-data" id="feedback_add">
                        <div class="form-group">
                            <label for="sel1"><b>Feedback TO :</b></label>
                            <select class="form-control" name="type" id="sel1">
                                <option value="Administrator">Administrator</option>
                                <option value="COE">Controller of Examination</option>
                                <option value="Faculty">Faculty</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="top:5px;"><b>Feedback Area :</b></label>
                            <div style="margin-bottom: 25px;top:5px" class="input-group">
                                <textarea class="form-control" name="feedback" rows="3" id="comment" required></textarea>

                            </div>
                        </div>
                        <div class="form-group ">
                    <label>Select Proof Image</label>
                    <input type="file" accept="image/*"  name="f_image" id="user_image" />
                  </div>
                        <div class="form-group" align="center">
                            <br>

                            <input type="submit" name="feed" id="user_login" class="btn success" value=" Done " />&nbsp;
                            <a class="btn blue" href="feedback.php">Back</a>
                        </div>
                    </form>



                </div>
            </div>
        </div>
        <div class="col-md-3">

        </div>
    </div>
</div>
<style>

</style>
</body>

</html>

<script>