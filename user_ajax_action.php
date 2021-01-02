<?php

include('master/Examination.php');

require_once('class/class.phpmailer.php');

$exam = new Examination;

date_default_timezone_set('Asia/Kolkata');

$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

if (isset($_POST['page'])) {
	if ($_POST['page'] == 'register') {
		if ($_POST['action'] == 'check_email') {
			$exam->query = "
			SELECT * FROM user_table 
			WHERE user_email_address = '" . trim($_POST["email"]) . "'
			";

			$total_row = $exam->total_row();

			if ($total_row == 0) {
				$output = array(
					'success'		=>	true
				);
				echo json_encode($output);
			}
		}

		if ($_POST['action'] == 'register') {
			$user_verfication_code = md5(rand());

			$receiver_email = $_POST['user_email_address'];

			$exam->filedata = $_FILES['user_image'];

			$user_image = $exam->Upload_file();

			$exam->data = array(
				':user_email_address'	=>	$receiver_email,
				':user_password'		=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
				':user_verfication_code' =>	$user_verfication_code,
				':user_name'			=>	$_POST['user_name'],
				':user_gender'			=>	$_POST['user_gender'],
				':user_dob'		   		=>	$_POST['user_dob'],
				':user_year'			=>	$_POST['user_year'],
				':user_course'			=>	$_POST['user_course'],
				':user_address'			=>	$_POST['user_address'],
				':user_mobile_no'		=>	$_POST['user_mobile_no'],
				':user_image'			=>	$user_image,
				':user_created_on'		=>	$current_datetime
			);

			$exam->query = "
			INSERT INTO user_table 
			(user_email_address, user_password, user_verfication_code, user_name, user_gender, user_dob, user_year, user_course, user_address, user_mobile_no, user_image, user_created_on)
			VALUES 
			(:user_email_address, :user_password, :user_verfication_code, :user_name, :user_gender, :user_dob, :user_year, :user_course, :user_address, :user_mobile_no, :user_image, :user_created_on)
			";

			$exam->execute_query();

			$subject = 'Online Examination Registration Verification';

			$body = '
			<p>Thank you for registering.</p>
			<p>This is a verification eMail, please click the link to verify your eMail address by clicking this <a href="' . $exam->home_page . 'verify_email.php?type=user&code=' . $user_verfication_code . '" target="_blank"><b>link</b></a>.</p>
			<p>In case if you have any difficulty please eMail us.</p>
			<p>Thank you,</p>
			<p>Online Examination System</p>
			';
			// $headers = "From: ssig432@gmail.com\nMIME-Version: 1.0\nContent-Type: text/html; charset=utf-8\n"; 
			// $exam->send_email($receiver_email,$subject,$body,$headers);
			$exam->send_email($receiver_email, $subject, $body);
			$output = array(
				'success'		=>	true
			);

			echo json_encode($output);
		}
	}




	if ($_POST['page'] == 'login') {
		if ($_POST['action'] == 'login') {
			$exam->data = array(
				':user_email_address'	=>	$_POST['user_email_address']
			);
			$cn = 1;
			$error = 1;

			// student login checking
			$exam->query = "
			SELECT * FROM user_table 
			WHERE user_email_address = :user_email_address
			";

			$total_row = $exam->total_row();


			if ($total_row > 0) {
				$result = $exam->query_result();
				$error = 2;
				foreach ($result as $row) {

					if (password_verify($_POST['user_password'], $row['user_password'])) {

						$cn = 2;

						$_SESSION['user_id'] = $row['user_id'];
						$output = array(
							'success'	=>	true,
							'status'    =>	'student'
						);
					} else {
						if ($error == 1) {
							$output = array(
								'error'		=>	'Wrong Password'
							);
						}
					}
				}
			}

			if ($cn == 1) {
				// //coe login checking
				$exam->query = "
			SELECT * FROM coe_table 
			WHERE coe_email_address = :user_email_address and user_type='COE'
			";

				$total_row = $exam->total_row();


				if ($total_row > 0) {
					$result = $exam->query_result();
					$error = 2;
					foreach ($result as $row) {

						if (password_verify($_POST['user_password'], $row['coe_password'])) {
							$cn = 2;
							$_SESSION['coe_id'] = $row['coe_id'];
							$output = array(
								'success'	=>	true,
								'status'    =>	'coe'
							);
						} else {
							if ($error == 1) {
								$output = array(
									'error'		=>	'Wrong Password'
								);
							}
						}
					}
				}
			}

			//admin checking

			if ($cn == 1) {
				$exam->query = "
			SELECT * FROM coe_table 
			WHERE coe_email_address = :user_email_address and user_type='ADMIN'
			";

				$total_row = $exam->total_row();


				if ($total_row > 0) {
					$result = $exam->query_result();
					$error = 2;
					foreach ($result as $row) {

						if (password_verify($_POST['user_password'], $row['coe_password'])) {
							$cn = 2;
							$_SESSION['adm_id'] = $row['coe_id'];
							$output = array(
								'success'	=>	true,
								'status'    =>	'admin'
							);
						} else {
							if ($error == 1) {

								$output = array(
									'error'		=>	'Wrong Password'
								);
							}
						}
					}
				} else {
					$output = array(
						'error'		=>	'Wrong Email Address or Password'
					);
				}
			}



			//master checking
			if ($cn == 1) {
				$exam->query = "
			SELECT * FROM admin_table 
			WHERE admin_email_address = :user_email_address
			";

				$total_row = $exam->total_row();


				if ($total_row > 0) {
					$result = $exam->query_result();

					foreach ($result as $row) {

						if (password_verify($_POST['user_password'], $row['admin_password'])) {
							$_SESSION['admin_id'] = $row['admin_id'];
							$output = array(
								'success'	=>	true,
								'status'    =>	'staff'
							);
						} else {
							$output = array(
								'error'		=>	'Wrong Password'
							);
						}
					}
				} else {
					$output = array(
						'error'		=>	'Wrong Email Address or Password'
					);
				}
			}



			echo json_encode($output);
		}
	}

	if ($_POST['page'] == "profile") {
		if ($_POST['action'] == "profile") {
			// $user_image = $_POST['hidden_user_image'];

			// if($_FILES['user_image']['name'] != '')
			// {
			// 	$exam->filedata = $_FILES['user_image'];

			// 	$user_image = $exam->Upload_file();
			// }

			$exam->data = array(
				':user_name'				=>	$exam->clean_data($_POST['user_name']),
				':user_gender'				=>	$_POST['user_gender'],
				':user_address'				=>	$exam->clean_data($_POST['user_address']),
				':user_mobile_no'			=>	$_POST['user_mobile_no'],
				':user_dob'					=>	$_POST['user_dob'],
				':user_id'					=>	$_SESSION['user_id']
			);

			$exam->query = "
			UPDATE user_table 
			SET user_name = :user_name, user_gender = :user_gender, user_dob = :user_dob, user_address = :user_address, user_mobile_no = :user_mobile_no
			WHERE user_id = :user_id
			";
			$exam->execute_query();

			$output = array(
				'success'		=>	true
			);

			echo json_encode($output);
		}
	}

	if ($_POST['page'] == 'change_password') {
		if ($_POST['action'] == 'change_password') {
			$exam->data = array(
				':user_password'	=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
				':user_id'			=>	$_SESSION['user_id']
			);

			$exam->query = "
			UPDATE user_table 
			SET user_password = :user_password 
			WHERE user_id = :user_id
			";

			$exam->execute_query();

			session_destroy();

			$output = array(
				'success'		=>	'Password has been change'
			);

			echo json_encode($output);
		}
	}

	if ($_POST['page'] == 'index') {
		if ($_POST['action'] == "fetch_exam") {
			$exam->query = "
			SELECT * FROM online_exam_table 
			WHERE online_exam_id = '" . $_POST['exam_id'] . "'
			";

			$result = $exam->query_result();

			$output = '
			<div class="card">
				<div class="card-header">Exam Details</div>
				<div class="card-body">
					<table class="table table-striped table-hover table-bordered">
			';
			foreach ($result as $row) {
				$output .= '
				<tr>
					<td><b>Exam Title</b></td>
					<td>' . $row["online_exam_title"] . '</td>
				</tr>
				<tr>
					<td><b>Exam Date & Time</b></td>
					<td>' . $row["online_exam_datetime"] . '</td>
				</tr>
				<tr>
					<td><b>Exam Duration</b></td>
					<td>' . $row["online_exam_duration"] . ' Minute</td>
				</tr>
				';
				if ($exam->If_user_already_enroll_exam($_POST['exam_id'], $_SESSION['user_id'])) {
					$enroll_button = '
					<tr>
						<td colspan="2" align="center">
							<button type="button" name="enroll_button" class="btn btn-info">You Already Enroll it</button>
						</td>
					</tr>
					';
				} else {
					$enroll_button = '
					<tr>
						<td colspan="2" align="center">
							<button type="button" name="enroll_button" id="enroll_button" class="btn btn-warning" data-exam_id="' . $row['online_exam_id'] . '">Enroll it</button>
						</td>
					</tr>
					';
				}
				$output .= $enroll_button;
			}
			$output .= '</table>';
			echo $output;
		}

		if ($_POST['action'] == 'enroll_exam') {
			$exam->data = array(
				':user_id'		=>	$_SESSION['user_id'],
				':exam_id'		=>	$_POST['exam_id']
			);

			$exam->query = "
			INSERT INTO user_exam_enroll_table 
			(user_id, exam_id) 
			VALUES (:user_id, :exam_id)
			";

			$exam->execute_query();




			$exam->query = "
			SELECT question_id FROM question_table 
			WHERE online_exam_id = '" . $_POST['exam_id'] . "'
			";
			$result = $exam->query_result();
			foreach ($result as $row) {


				$exam->data = array(
					':user_id'				=>	$_SESSION['user_id'],
					':exam_id'				=>	$_POST['exam_id'],
					':question_id'			=>	$row['question_id'],
					':user_answer_option'	=>	'0',
					':marks'				=>	'0'
				);

				$exam->query = "
				INSERT INTO user_exam_question_answer 
				(user_id, exam_id, question_id, user_answer_option, marks) 
				VALUES (:user_id, :exam_id, :question_id, :user_answer_option, :marks)
				";
				$exam->execute_query();
			}
		}
	}

	if ($_POST["page"] == 'enroll_exam') {
		if ($_POST['action'] == 'fetch') {
			$output = array();


			$exam->query = "
			SELECT * FROM user_exam_enroll_table 
			INNER JOIN online_exam_table 
			ON online_exam_table.online_exam_id = user_exam_enroll_table.exam_id 
			WHERE user_exam_enroll_table.user_id = '" . $_SESSION['user_id'] . "' 
			AND (";

			if (isset($_POST["search"]["value"])) {
				$exam->query .= 'online_exam_table.online_exam_title LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR online_exam_table.online_exam_datetime LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR online_exam_table.online_exam_duration LIKE "%' . $_POST["search"]["value"] . '%" ';
				// $exam->query .= 'OR online_exam_table.total_question LIKE "%' . $_POST["search"]["value"] . '%" ';
				// $exam->query .= 'OR online_exam_table.marks_per_right_answer LIKE "%' . $_POST["search"]["value"] . '%" ';
				// $exam->query .= 'OR online_exam_table.marks_per_wrong_answer LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR online_exam_table.online_exam_status LIKE "%' . $_POST["search"]["value"] . '%" ';
			}

			$exam->query .= ')';

			if (isset($_POST["order"])) {
				$exam->query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
			} else {
				$exam->query .= 'ORDER BY online_exam_table.online_exam_id DESC ';
			}

			$extra_query = '';

			if ($_POST["length"] != -1) {
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filterd_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM user_exam_enroll_table 
			INNER JOIN online_exam_table 
			ON online_exam_table.online_exam_id = user_exam_enroll_table.exam_id 
			WHERE user_exam_enroll_table.user_id = '" . $_SESSION['user_id'] . "'";

			$total_rows = $exam->total_row();

			$data = array();
			$scount = 1;

			foreach ($result as $row) {
				$sub_array = array();
				$sub_array[] = $scount;
				$scount += 1;
				$sub_array[] = html_entity_decode($row["online_exam_title"]);
				$sub_array[] = $row["online_exam_datetime"];
				$sub_array[] = $row["online_exam_duration"] . ' Minute';
				// $sub_array[] = $row["total_question"] . ' Question';
				// $sub_array[] = $row["marks_per_right_answer"] . ' Mark';
				// $sub_array[] = '-' . $row["marks_per_wrong_answer"] . ' Mark';
				$status = '';
				$view_exam = ''; //Added
				if ($row['online_exam_status'] == 'Created') {
					$status = '<span class="badge badge-success">Created</span>';
				}

				if ($row['online_exam_status'] == 'Started') {
					$status = '<span class="badge badge-primary">Started</span>';
				}

				if ($row['online_exam_status'] == 'Completed') {
					$status = '<span class="badge badge-dark">Completed</span>';
				}


				$sub_array[] = $status;

				if ($row["online_exam_status"] == 'Started' and $row["exam_status"] == '') {
					$view_exam = '<a href="view_exam.php?code=' . $row["online_exam_code"] . '" id="view_exam" class="btn blue btn-sm" onclick="openWin()" style="color:black;" >View Exam</a>';
				}
				if ($row["online_exam_status"] == 'Completed') {
					$view_exam = '<a href="view.php?code=' . $row["online_exam_code"] . '" class="btn warning btn-sm">View Exam</a>';
					$view_exam = '<span class="badge badge-success">Exam Completed</span>';
				}
				if ($row["online_exam_status"] == 'Started' and $row["exam_status"] == 'Completed') {
					$view_exam = '<span class="badge badge-success">Exam submitted</span>';
				}

				//$view_exam = '<a href="view_exam.php?code=' . $row["online_exam_code"] . '" id="view_exam" class="btn blue btn-sm" onclick="openWin(); return false;" style="color:black;" >View Exam</a>';


				$sub_array[] = $view_exam;

				$data[] = $sub_array;
			}

			$output = array(
				"draw"    			=> 	intval($_POST["draw"]),
				"recordsTotal"  	=>  $total_rows,
				"recordsFiltered" 	=> 	$filterd_rows,
				"data"    			=> 	$data,
			);
			echo json_encode($output);
		}
	}

	if ($_POST['page'] == 'view_exam') {
		$cnt = 0;
		if ($_POST['action'] == 'load_question') {
			$ex_id = $_POST["exam_id"];
			if ($_POST['question_id'] == '') {
				$exam->query = "
				SELECT * FROM question_table 
				WHERE online_exam_id = '" . $_POST["exam_id"] . "' 
				ORDER BY question_id ASC 
				LIMIT 1
				";
			} else {
				$exam->query = "
				SELECT * FROM question_table 
				WHERE question_id = '" . $_POST["question_id"] . "' 
				";
			}


			$result = $exam->query_result();

			$output = '';
			$question_id = '';
			$user_id = '';


			foreach ($result as $row) {
				$cnt = $cnt + 1;
				$output .= '
				<h1> Question ' . $row["question_number"] . ': ' . $row["question_title"] . '</h1>
				
				<hr />
				<br />
				<div class="row">
				';



				$exam->query = "
				SELECT * FROM option_table 
				WHERE question_id = '" . $row['question_id'] . "'
				";
				$sub_result = $exam->query_result();

				$count = 1;

				foreach ($sub_result as $sub_row) {
					$exam->query = "select user_answer_option from user_exam_question_answer where user_id='" . $_SESSION["user_id"] . "'and question_id='" . $row['question_id'] . "'";
					$result = $exam->fetchsinglerow();


					$user_answer_option = $result['user_answer_option'];

					if ($user_answer_option == $sub_row["option_number"]) {
						$user_answer_option = "checked";
					}

					$output .= '
							<div class="col-md-6" style="margin-bottom:32px;">
								<div class="radio">
									<label><h4><input type="radio" name="option_1" class="answer_option" data-question_id="' . $row["question_id"] . '" data-id="' . $count . '" ' . $user_answer_option . '/>&nbsp;' . $sub_row["option_title"] . '</h4></label>
								</div>
							</div>
							';

					$count = $count + 1;
				}
				$output .= '
				</div>
				';
				$exam->query = "
				SELECT question_id FROM question_table 
				WHERE question_id < '" . $row['question_id'] . "' 
				AND online_exam_id = '" . $_POST["exam_id"] . "' 
				ORDER BY question_id DESC 
				LIMIT 1";

				$previous_result = $exam->query_result();

				$previous_id = '';
				$next_id = '';

				foreach ($previous_result as $previous_row) {

					$previous_id = $previous_row['question_id'];
				}

				$exam->query = "
				SELECT question_id FROM question_table 
				WHERE question_id > '" . $row['question_id'] . "' 
				AND online_exam_id = '" . $_POST["exam_id"] . "' 
				ORDER BY question_id ASC 
				LIMIT 1";

				$next_result = $exam->query_result();

				foreach ($next_result as $next_row) {

					$next_id = $next_row['question_id'];
				}

				$if_previous_disable = '';
				$if_next_disable = '';

				if ($previous_id == "") {
					$if_previous_disable = 'disabled';
				}
				$hide_submit = 'd-none';
				if ($next_id == "") {
					$if_next_disable = 'disabled';
					$hide_submit = '';
				}
				//	$exam_id= '4' ;
				$output .= '
					<br /><br />
				  	<div align="center">
				   		<button type="button" name="previous" class="btn blue previous" id="' . $previous_id . '" ' . $if_previous_disable . '>PREVIOUS</button>&nbsp;
						   <button type="button" name="next" class="btn info next" id="' . $next_id . '" ' . $if_next_disable . '>  NEXT  </button>' . ' <br> <hr>
						   <a id="swal" onclick="myfun();" class="btn success submit ' . $hide_submit  . '" href="submit.php?id=' . $ex_id . '">SUBMIT</a>
						</br></hr>
				  	</div>
					  <br /><br />
					  <script>
    function myfun() {
        swal({
            title: "Are you sure?",
            text: "Do you want to finish exam?Kindly stop the recording to save your answers.",
            icon: "warning",
            buttons: true,
            dangerMode: true,

        })
            .then((willDelete) => {
                if (willDelete) {
                    swal("submitted successfully!", {
                        icon: "success",
                    });
                } else {
                    // swal("Your imaginary file is safe!");
                    return false;
                }
            });
    }

</script>
<style>
    .swal-overlay {
        background-color: rgba(43, 165, 137, 0.45);
    }
</style>';
				//

				//   swal({
				// 	title: 'Are you sure?',
				// 	text: "Do you want finsh the exam",
				// 	type: 'warning',
				// 	showCancelButton: true,
				// 	confirmButtonColor: '#3085d6',
				// 	cancelButtonColor: '#d33',
				// 	confirmButtonText: 'Yes, delete it!'
				//   }).then(function() {
				// 	swal(
				// 	  'Success!',
				// 	  'Exam submitted successfully.',
				// 	  'success'
				// 	);
				//   })

				//   

				//
			}

			echo $output;
		}
		if ($_POST['action'] == 'question_navigation') {
			$exam->query = "
				SELECT section_id, title FROM section 
				WHERE exam_id = '" . $_POST["exam_id"] . "' 
				ORDER BY section_id ASC;
				";
			$result = $exam->query_result();
			// die(var_dump($result));
			$output = '
			<div class="card">
				<div class="card-header">Question Navigation</div>
				<div class="card-body">
					<div class="row">
			';

			$exam_id = $_POST["exam_id"];
			$user_id = $_SESSION['user_id'];

			$exam->query = "
					SELECT question_id from user_exam_question_answer
					WHERE user_id=$user_id and exam_id = $exam_id and not user_answer_option = '0'; 
				";

			$answered_questions = ($exam->query_result_assoc());
			$question_ids = array();
			foreach($answered_questions as $answer){
				$question_ids[] = $answer['question_id'];
			};
			// print_r($question_ids);
			// die(print_r($answered_questions));

			// $exam->query = "
			// 	SELECT section_id, title from section 
			// 	where exam_id = $exam_id;
			// ";
			// echo $exam_id, $user_id;
			// die(var_dump($exam->query_result()));

			foreach ($result as $row) {
				$section_id = $row['section_id'];
				$output .= '<div class="card">
					<div class="card-header">' . $row["title"] . '</div>
					<div class="card-body">';

					$exam->query = "
						SELECT question_id, question_number from question_table 
						where section_id = $section_id and online_exam_id = $exam_id;
					";
					$questions_in_section = $exam->query_result();

					// die(print_r($questions_in_section));

					foreach($questions_in_section as $question){
						$color = 'btn-primary';
						// var_dump(in_array($question['question_id'], $question_ids));
						if (in_array($question['question_id'], $question_ids) !== false){
							$color = 'btn-success';
							// var_dump($color);
						};
						$output .= '<span class="col-md-1" style="margin-bottom:24px;">
					<button type="button" class="btn '. $color .' question_navigation" data-question_id="' . $question['question_id'] . '">' . $question['question_number'] . '</button>
				</span>';
					};

				$output .= '</div>
				</div>';
			}

			// $count = 1;
			// foreach ($result as $row) {
			// 	$question = $row["question_id"];
			// 	$exam->query = "
			// 	SELECT * FROM user_exam_question_answer 
			// 	WHERE exam_id = '" . $_POST["exam_id"] . "' and  user_id = '" . $_SESSION["user_id"] . "' and question_id = '" . $question . "' and user_answer_option= '0'
			// 	";
			// 	$results = $exam->query_result();

			// 	$total_row = $exam->total_row();

			// 	if ($total_row == 1) {
			// 		$output .= '
			// 	<div class="col-md-2" style="margin-bottom:24px;">
			// 		<button type="button" class="btn btn-primary btn-lg question_navigation" data-question_id="' . $question . '">' . $count . '</button>
			// 	</div>
			// 	';
			// 		$count++;
			// 	} else {
			// 		$output .= '
			// 	<div class="col-md-2" style="margin-bottom:24px;">
			// 		<button type="button" class="btn btn-success btn-lg question_navigation" data-question_id="' . $question . '">' . $count . '</button>
			// 	</div>
			// 	';
			// 		$count++;
			// 	}
			// }
			// $output .= '
			// 	</div>
			// </div></div>
			// ';
			echo $output;
		}

		if ($_POST['action'] == 'user_detail') {
			$exam->query = "
			SELECT * FROM user_table 
			WHERE user_id = '" . $_SESSION["user_id"] . "'
			";

			$result = $exam->query_result();

			$output = '
			<div class="card border border-primary">
				<div class="card-header">User Details</div>
				<div class="card-body">
					<div class="row">
			';

			foreach ($result as $row) {
				$output .= '<div class="col-md-3">
				<img src="https://upload.wikimedia.org/wikipedia/en/7/77/Bannari_Amman_Institute_of_Technology_logo.png" height="140px" width="100px" />

				</div>
				<div class="col-md-9">

					<table class="table table-bordered">
						<tr>
							<th>Name</th>
							<td>' . $row["user_name"] . '</td>
						</tr>
						<tr>
							<th>Email ID</th>
							<td>' . $row["user_email_address"] . '</td>
						</tr>
						<tr>
							<th>Gendar</th>
							<td>' . $row["user_gender"] . '</td>
						</tr>
					</table>
				</div>
				';
			}
			$output .= '</div></div></div>';
			echo $output;
		}
		if ($_POST['action'] == 'answer') {
			$exam_right_answer_mark = $exam->Get_question_right_answer_mark($_POST['exam_id']);

			$exam_wrong_answer_mark = $exam->Get_question_wrong_answer_mark($_POST['exam_id']);

			$option_marks = $exam->Get_question_answer_option($_POST['question_id']);

			$orignal_answer = $option_marks['answer_option'];

			// die(var_dump($option_marks, $_POST));

			$marks = 0;

			if ($orignal_answer == $_POST['answer_option']) {
				$marks = (int)$option_marks['correct_mark'];
			} else {
				$marks = (int)$option_marks['wrong_mark'];
			}

			// die(var_dump($marks));
			$exam->data = array(
				':user_answer_option'	=>	$_POST['answer_option'],
				':marks'				=>	$marks
			);

			$exam->query = "
			UPDATE user_exam_question_answer 
			SET user_answer_option = :user_answer_option, marks = :marks 
			WHERE user_id = '" . $_SESSION["user_id"] . "' 
			AND exam_id = '" . $_POST['exam_id'] . "' 
			AND question_id = '" . $_POST["question_id"] . "'
			";
			$exam->execute_query();
		}
	}
}
