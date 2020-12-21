<?php



require_once '../include/db.php';

include('../include/db.php');
include('header.php');

$fid = intval($_GET['examid']);
$admin_id = $_SESSION["admin_id"];

if (isset($_POST['change'])) {

    $remark = $_POST["remark"];
    $status = $_POST["status"];
    $result = mysqli_query($db, "update feedback_table set feed_remark='$remark',feed_status='$status',staff_id='$admin_id' where f_id='$fid';");
    echo '<script>alert("Feedback Changed")</script>';
    echo "<script>window.location.href='staff_feedback.php'</script>";
}
?>
<br><br>
<div class="container">
    <h1 style="align-content: center;font-size:50px;font-family:cursive;" align="center">Exam Feedback</h1><br>

    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6" style="margin-top:50px;">


            <div class="card border border-success">
                <div class="card-header">Exam Feedback
                </div>
                <!-- <div class="card-header" style="font-family:comic sans MS;color:blue;font-size:larger;"><center>Student Login</center></div> -->
                <div class="modal-body">
                    <form method="post" id="feedback_add">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Feedback ID:<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" placeholder="<?php echo $fid; ?>" name="feedid" id="online_exam_title" class="form-control" disabled />

                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 text-right">Feeback Remark : <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <textarea type="text" row="15" cols="50" name="remark" id="online_exam_title" class="form-control"></textarea>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 text-right">Feedback Status : <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <select name="status" id="online_exam_duration" class="form-control">
                                            <option value="">Select</option>
                                            <option value="solved">Solved</option>
                                            <option value="declined">Declined</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" align="center">
                                <br>
                                <input type="submit" name="change" id="user_login" class="btn success" value=" Update " />&nbsp;
                                <a class="btn blue" href="staff_feedback.php">Back</a>
                            </div>
                    </form>



                </div>
            </div>
        </div>
        <div class="col-md-3">

        </div>
    </div>
</div>