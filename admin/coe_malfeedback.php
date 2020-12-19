<?php

//exam.php 
require_once '../include/db.php';

include('../include/db.php');
include('header.php');
if (isset($_REQUEST['id'])) {
    $fid = intval($_GET['id']);
    $remark = $_POST["remark"];
    $status = $_POST["status"];
    $result = mysqli_query($db, "update feedback_table set feed_status='$status',feed_remark='$remark' where f_id='$fid';");
}
?>
<br><br>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-9">
                <h3 class="panel-title">Mal-Feedback Table</h3>
            </div>
            <div class="col-md-3" align="right">
                <!-- <button type="button" id="add_button" class="btn btn-info btn-sm">Add</button> -->
            </div>
        </div>
    </div>
    <div class="card-body">
        <span id="message_operation"></span>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="exam_data_table">


                <thead>
                    <tr>
                        <th>Feedback ID</th>
                        <th>Exam ID</th>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Department</th>
                        <th>Reason</th>
                        <th>Feedback</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $exam->query = "SELECT malpractice_feedback.mfeed_id, malpractice_feedback.exam_id,malpractice_feedback.user_id, user_table.user_name,user_table.user_course , malpractice_feedback.reason, malpractice_feedback.feedback FROM malpractice_feedback LEFT JOIN user_table ON malpractice_feedback.user_id = user_table.user_id  ";

                    $result = $exam->query_result();

                    foreach ($result as $row) {
                    ?>
                        <tr>
                            <td><?php echo $row['mfeed_id']; ?></td>
                            <td><?php echo $row['exam_id']; ?></td>
                            <td><?php echo $row['user_id']; ?></td>
                            <td><?php echo $row['user_name']; ?></td>
                            <td><?php echo $row['user_course']; ?></td>
                            <td><?php echo $row['reason']; ?></td>
                            <td><?php echo $row['feedback']; ?></td>
                            <!-- <td><div class="badge badge-success text-wrap font-weight-bold" style="width: 8rem;height: 25px;font-size: 18px;">Solved</div></td>  -->
                        </tr>
                    <?php }   ?>
                </tbody>

                <div class="modal" id="formModal">
                    <div class="modal-dialog modal-lg">
                        <form method="post" id="staff_feedback">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title" id="modal_title"></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-4 text-right">Feedback ID:<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="<?php echo $row['f_id']; ?>" value="<?php echo $row['f_id']; ?>" name="feedid" id="online_exam_title" class="form-control" disabled />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-4 text-right">Feeback Remark <span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <textarea type="text" row="15" cols="50" name="remark" id="online_exam_title" class="form-control"></textarea>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-4 text-right">Feedback Status <span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <select name="status" id="online_exam_duration" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="solved">Solved</option>
                                                        <option value="declined">Declined</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Modal footer -->
                                        <div class="modal-footer">


                                            <button align="center" name="Done" type="submit" id="button_action" class="btn success btn-sm">Done</a></button>

                                            <button type="button" class="btn danger btn-sm" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                        </form>

                    </div>
                </div>

            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        var dataTable = $('#exam_data_table').DataTable({

        });

    });
</script>

<script>
    $(document).ready(function() {



        function reset_form() {
            $('#modal_title').text('Feedback Status');
            $('#button_action').val('Done');
            $('#action').val('Add');

        }

        $('#add_button').click(function() {
            reset_form();
            $('#formModal').modal('show');
            $('#message_operation').html('');
        });



    });
</script>