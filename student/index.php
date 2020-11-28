<?php

//index.php // source code modified by jacksonsilass@gmail.com +255 763169695 from weblessons

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
<div class="containter">
	<br />



<?php
if (isset($_SESSION["user_id"])) {

?>
	<h1 style="align-content: center;font-size:60px;font-family:Cursive;" align="center">Student Dashboard</h1><br>

<br>
</div>

	<br><br>




	<div class="container">

		<div class="row">
			<div class="col-sm-12">
				<div class="card border border-success">
					<div class="card-header" style="font-family:monospace;font-size:20px;">
						<center>Enroll Exam</center>
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
						$('#enroll_button').text('Enroll success');
						window.location.href='enroll_exam.php';
					}
				});
			});

		});
	</script>
<?php
} else { 		    echo "<script>window.location.href='login.php'</script>"; 


?>
	<!-- <div align="center">
		<p><a href="register.php" class="btn btn-warning btn-lg">Register</a></p>
		<p><a href="login.php" class="btn btn-dark btn-lg">Login</a></p>
	</div> -->
<?php
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

<style>
	.shape {
		border-style: solid;
		border-width: 0 70px 40px 0;
		float: right;
		height: 0px;
		width: 0px;
		-ms-transform: rotate(360deg);
		/* IE 9 */
		-o-transform: rotate(360deg);
		/* Opera 10.5 */
		-webkit-transform: rotate(360deg);
		/* Safari and Chrome */
		transform: rotate(360deg);
	}

	.offer {
		background: #fff;
		border: 1px solid #ddd;
		box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
		margin: 15px 0;
		overflow: hidden;
	}

	.offer:hover {
		-webkit-transform: scale(1.1);
		-moz-transform: scale(1.1);
		-ms-transform: scale(1.1);
		-o-transform: scale(1.1);
		transform: rotate scale(1.1);
		-webkit-transition: all 0.4s ease-in-out;
		-moz-transition: all 0.4s ease-in-out;
		-o-transition: all 0.4s ease-in-out;
		transition: all 0.4s ease-in-out;
	}

	.shape {
		border-color: rgba(255, 255, 255, 0) #d9534f rgba(255, 255, 255, 0) rgba(255, 255, 255, 0);
	}

	.offer-radius {
		border-radius: 7px;
	}

	.offer-danger {
		border-color: #d9534f;
	}

	.offer-danger .shape {
		border-color: transparent #d9534f transparent transparent;
	}

	.offer-success {
		border-color: #5cb85c;
	}

	.offer-success .shape {
		border-color: transparent #5cb85c transparent transparent;
	}

	.offer-default {
		border-color: #999999;
	}

	.offer-default .shape {
		border-color: transparent #999999 transparent transparent;
	}

	.offer-primary {
		border-color: #428bca;
	}

	.offer-primary .shape {
		border-color: transparent #428bca transparent transparent;
	}

	.offer-info {
		border-color: #5bc0de;
	}

	.offer-info .shape {
		border-color: transparent #5bc0de transparent transparent;
	}

	.offer-warning {
		border-color: #f0ad4e;
	}

	.offer-warning .shape {
		border-color: transparent #f0ad4e transparent transparent;
	}

	.shape-text {
		color: #fff;
		font-size: 12px;
		font-weight: bold;
		position: relative;
		right: -40px;
		top: 2px;
		white-space: nowrap;
		-ms-transform: rotate(30deg);
		/* IE 9 */
		-o-transform: rotate(360deg);
		/* Opera 10.5 */
		-webkit-transform: rotate(30deg);
		/* Safari and Chrome */
		transform: rotate(30deg);
	}

	.offer-content {
		padding: 0 20px 10px;
	}

	@media (min-width: 487px) {
		.container {
			max-width: 750px;
		}

		.col-sm-6 {
			width: 50%;
		}
	}

	@media (min-width: 900px) {
		.container {
			max-width: 970px;
		}

		.col-md-4 {
			width: 33.33333333333333%;
		}
	}

	@media (min-width: 1200px) {
		.container {
			max-width: 1170px;
		}

		.col-lg-3 {
			width: 25%;
		}
	}
</style>





</html>