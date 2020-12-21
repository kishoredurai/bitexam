<?php

//login.php

include('../master/Examination.php');
$exam = new Examination;

$exam->user_session_private();
include('../include/db.php');
include('../include/user_header.php');
require_once '../include/db.php';

if (isset($_REQUEST['del'])) {
	$userid = intval($_GET['del']);
	$sql = "DELETE FROM feedback_table WHERE f_id = '$userid';";
	$result = mysqli_query($db, $sql);
}
?>
<br>

<body oncontextmenu="return false;">

<br><Br><br>
<h1 style="align-content: center;font-size:50px;font-family:cursive;" align="center">Feedback</h1><br>

<div class="card border border-success">
	<div class="card-header" style="font-family:Times;">Feedback List
		<div style="float:right; font-size: 50%; position: relative;"><a class="btn info" href="feedback_add.php">Submit Feedback</a></div>
	</div>

	<div class="card-body">
		<div class="card-body">
			<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover" id="exam_data_table">
					<thead>
						<tr>
							<th>Id</th>
							<th>Feedback Type</th>
							<th>Feedback</th>
							<th>Feedback Status</th>
							<th>Feedback Remark</th>
							<th>Feed applied Date and Time</th>
							<th>Feedback Image</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
						<?php
						require_once '../include/db.php';

						$id = $_SESSION['user_id'];

						$sql = "SELECT * from feedback_table where user_id='$id' ;";
						$result = mysqli_query($db, $sql);
						$cnt = 1;

						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>

								<tr>
									<td><?php echo $row['f_id']; ?></td>
									<td><?php echo $row['feed_type']; ?></td>
									<td><?php echo $row['feed']; ?></td>
									<td><?php 
									if($row["feed_status"] == 'Pending')
									{?><span class="badge badge-danger">Pending</span>
									<?php } else { ?>
									<span class="badge badge-success">Solved</span>
									<?php } ?></td>
									<td><?php echo $row['feed_remark']; ?></td>
									<td><?php echo $row['feed_timestamp']; ?></td>
									<td>
										<?php if ($row['feed_image'] != NULL) { ?>
											<img src="../feedback_image/<?php echo $row['feed_image']; ?>" class="img-thumbnail" width="150" /></td><?php } else { ?>
									<div class="badge badge-danger text-wrap font-weight-bold" style="width: 8rem;height: 25px;font-size: 18px;"> No Image </div>
								<?php	}
																																				if ($row['feed_status'] == "Pending") { ?>
									<td><a class="btn warning" href="feedback.php?del=<?php echo $row['f_id']; ?>">Delete</a></td><?php } else { ?>
									<td>
										<div class="badge badge-success text-wrap font-weight-bold" style="width: 8rem;height: 25px;font-size: 18px;">Solved</div>
									</td>

								</tr>

					<?php	}
																																			}
																																		} ?>
					</tbody>

				</table>
			</div>

		</div>
	</div>
</div>
<script>
$(document).ready(function(){

var dataTable = $('#exam_data_table').DataTable({
	
});

});

</script>
</body>

</html>