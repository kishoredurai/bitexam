<?php


include('../master/Examination.php');

$exam = new Examination;

include('../include/user_header.php');

include('../include/db.php');
?>
<?php
require_once '../include/db.php';

$id = $_SESSION['user_id'];

$sql = "SELECT COUNT(*) as cnt from feedback_table where f_id='$id' ;";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$row_comp = $row['cnt'];

?>
<body oncontextmenu="return false;">
<div class="containter" >
	<br />
	<br><br> <br><br><!-- <meta http-equiv="refresh" content="10"> -->


	<?php
	if (isset($_SESSION["user_id"])) {


		if (isset($_SESSION['user_id'])) {


			$exam->query = "
		  SELECT * FROM user_table 
		  WHERE user_id = '" . $_SESSION['user_id'] . "'
		  ";

			$result = $exam->query_result();
			foreach ($result as $row)

	?>
			<h1 style="align-content: center;font-size:60px;font-family:Cursive;" align="center"><?php echo $row["user_name"]; ?> Dashboard</h1><br>
		<?php }  ?>
		<br>
</div>

<br><br>



<script>
	var params = [
		'height=' + screen.height,
		'width=' + screen.width,
		'fullscreen=yes' // only works in IE, but here for completeness
	].join(',');
</script>
<div class="container">

	<div class="row">
		<div class="col-sm-12">
			<div class="card border border-success">
				<div class="card-header" style="font-family:monospace;font-size:20px;">
					<center> View Your Exam </center>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<select name="exam_list" id="exam_list" class="form-control input-lg">
							<option value="">Select Exam</option>
							<?php
							$user_id = $_SESSION['user_id'];
							echo $exam->Fill_exam_list($user_id);

							?>
						</select>
						<br />
						<span id="exam_details"></span>
					</div>

				</div>
			</div>
		</div>

	</div>
</div>





















<script>
	$(document).ready(function() {

		$('#exam_list').parsley();

		var exam_id = '';

		$('#exam_list').change(function() {

			$('#exam_list').attr('required', 'required');

			if ($('#exam_list').parsley().validate()) {
				exam_id = $('#exam_list').val();
				$.ajax({
					url: "../user_ajax_action.php",
					method: "POST",
					data: {
						action: 'fetch_exam',
						page: 'index',
						exam_id: exam_id
					},
					success: function(data) {
						$('#exam_details').html(data);
					}
				});
			}
		});

		$(document).on('click', '#enroll_button', function() {
			exam_id = $('#enroll_button').data('exam_id');
			$.ajax({
				url: "../user_ajax_action.php",
				method: "POST",
				data: {
					action: 'enroll_exam',
					page: 'index',
					exam_id: exam_id
				},
				beforeSend: function() {
					$('#enroll_button').attr('disabled', 'disabled');
					$('#enroll_button').text('please wait');
				},
				success: function() {
					$('#enroll_button').attr('disabled', false);
					$('#enroll_button').removeClass('btn-warning');
					$('#enroll_button').addClass('btn-success');
					$('#enroll_button').attr('disabled', 'disabled');
					$('#enroll_button').text('Enroll success');
					window.location.href = 'enroll_exam.php';
				}
			});
		});

	});
</script>
<?php
	} else {
		echo "<script>window.location.href='../login.php'</script>";
	}

?>

<br />
<br />
<br />
<br />
<br />
<br />
</div>
</div>
</body>




</html>