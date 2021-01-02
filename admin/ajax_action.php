<?php

include('../include/db.php');
require_once '../include/db.php';
//ajax_action.php 

include('Examination.php');


$exam = new Examination;

date_default_timezone_set('Asia/Kolkata');

$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));



if (isset($_POST['page'])) {
	if ($_POST['page'] == 'register') {
		if ($_POST['action'] == 'check_email') {
			$exam->query = "
			SELECT * FROM admin_table 
			WHERE admin_email_address = '" . trim($_POST["email"]) . "'
			";

			$total_row = $exam->total_row();

			if ($total_row == 0) {
				$output = array(
					'success'	=>	true
				);

				echo json_encode($output);
			}
		}

		if ($_POST['action'] == 'register') {
			$admin_verification_code = md5(rand());

			$receiver_email = $_POST['admin_email_address'];
			$admin_name = $_POST['admin_name'];
			$admin_gender = $_POST['admin_gender'];
			$admin_mobile_no = $_POST['admin_mobile_no'];
			$admin_course = $_POST['admin_course'];
			$admin_level = $_POST['admin_level'];

			$exam->data = array(
				':admin_email_address'		=>	$receiver_email,
				':admin_password'			=>	password_hash($_POST['admin_password'], PASSWORD_DEFAULT),
				':admin_verfication_code'	=>	$admin_verification_code,
				':admin_type'				=>	'sub_master',
				':admin_created_on'			=>	$current_datetime,
				':admin_name'				=>	$admin_name,
				':admin_gender'				=>	$admin_gender,
				':admin_course'				=>	$admin_course,
				':admin_contact'			=>	$admin_mobile_no,
				':admin_level'			    =>	$admin_level
			);

			$exam->query = "
			INSERT INTO admin_table 
			(admin_name, admin_email_address, admin_password, admin_gender,  admin_course, admin_contact, admin_level, admin_verfication_code, admin_type, admin_created_on) 
			VALUES 
			(:admin_name, :admin_email_address, :admin_password, :admin_gender,  :admin_course, :admin_contact, :admin_level, :admin_verfication_code, :admin_type, :admin_created_on)
			";

			$exam->execute_query();

			$subject = 'Online Examination Registration Verification';

			$body = '
			<p>Thank you for registering.</p>
			<p>This is a verification eMail, please click the link to verify your eMail address by clicking this <a href="' . $exam->home_page . 'verify_email.php?type=master&code=' . $admin_verification_code . '" target="_blank"><b>link</b></a>.</p>
			<p>In case if you have any difficulty please eMail us.</p>
			<p>Thank you,</p>
			<p>Online Examination System</p>
			';

			$exam->send_email($receiver_email, $subject, $body);

			$output = array(
				'success'	=>	true
			);

			echo json_encode($output);
		}
	}

	//change password
	if ($_POST['page'] == 'change_password') {
		if ($_POST['action'] == 'change_password') {
			$exam->data = array(
				':admin_password'	=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
				':admin_id'			=>	$_SESSION['coe_id']
			);

			$exam->query = "
			UPDATE admin_table 
			SET admin_password = :admin_password 
			WHERE admin_id = :admin_id
			";

			$exam->execute_query();

			//	session_destroy();

			//header('location:../login.php');

			$output = array(
				'success'		=>	'Password has been change'
			);

			echo json_encode($output);
		}
	}


	//login staff
	if ($_POST['page'] == 'login') {
		if ($_POST['action'] == 'login') {
			$exam->data = array(
				':admin_email_address'	=>	$_POST['admin_email_address']
			);

			$exam->query = "
			SELECT * FROM admin_table 
			WHERE admin_email_address = :admin_email_address
			";

			$total_row = $exam->total_row();

			if ($total_row > 0) {
				$result = $exam->query_result();

				foreach ($result as $row) {
					if ($row['email_verified'] == 'yes') {
						if (password_verify($_POST['admin_password'], $row['admin_password'])) {
							$_SESSION['coe_id'] = $row['admin_id'];
							$output = array(
								'success'	=>	true
							);
						} else {
							$output = array(
								'error'	=>	'Wrong Password'
							);
						}
					} else {
						$output = array(
							'error'		=>	'Your Email is not verify'
						);
					}
				}
			} else {
				$output = array(
					'error'		=>	'Wrong Email Address'
				);
			}
			echo json_encode($output);
		}
	}

	if ($_POST['page'] == 'exam') {
		if ($_POST['action'] == 'fetch') {
			$output = array();

			$exam->query = "
			SELECT * FROM online_exam_table ;			";

			if (isset($_POST['search']['value'])) {
				$exam->query .= 'online_exam_title LIKE "%' . $_POST["search"]["value"] . '%" ';

				$exam->query .= 'OR online_exam_datetime LIKE "%' . $_POST["search"]["value"] . '%" ';

				$exam->query .= 'OR online_exam_duration LIKE "%' . $_POST["search"]["value"] . '%" ';

				// $exam->query .= 'OR total_question LIKE "%' . $_POST["search"]["value"] . '%" ';

				// $exam->query .= 'OR marks_per_right_answer LIKE "%' . $_POST["search"]["value"] . '%" ';

				// $exam->query .= 'OR marks_per_wrong_answer LIKE "%' . $_POST["search"]["value"] . '%" ';

				$exam->query .= 'OR online_exam_status LIKE "%' . $_POST["search"]["value"] . '%" ';
			}

			$exam->query .= ')';

			if (isset($_POST['order'])) {
				$exam->query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
			} else {
				$exam->query .= 'ORDER BY online_exam_id DESC ';
			}

			$extra_query = '';

			if ($_POST['length'] != -1) {
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM online_exam_table;
			 
			";

			$total_rows = $exam->total_row();

			$data = array();

			$cnt = 0;

			foreach ($result as $row) {
				$cnt++;
				$sub_array = array();

				$sub_array[] = $cnt;

				$sub_array[] = html_entity_decode($row['online_exam_title']);

				$sub_array[] = $row['online_exam_datetime'];

				$sub_array[] = $row['user_year'];

				$sub_array[] = $row['user_course'];

				$sub_array[] = $row['online_exam_duration'] . ' Minute';

				// $sub_array[] = $row['total_question'] . ' Question';

				// $sub_array[] = $row['marks_per_right_answer'] . ' Mark';


				// $sub_array[] = '-' . $row['marks_per_wrong_answer'] . ' Mark';

				$status = '';
				$edit_button = '';
				$delete_button = '';
				$question_button = '';
				$result_button = '';

				if ($row['online_exam_status'] == 'Pending') {
					$status = '<span class="badge badge-warning">Pending</span>';
				}

				if ($row['online_exam_status'] == 'Created') {
					$status = '<span class="badge badge-success">Created</span>';
				}

				if ($row['online_exam_status'] == 'Started') {
					$status = '<span class="badge badge-primary">Started</span>';
				}

				if ($row['online_exam_status'] == 'Completed') {
					$status = '<span class="badge badge-dark">Completed</span>';
				}

				if ($exam->Is_exam_is_not_started($row["online_exam_id"])) {
					$edit_button = '
					<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="' . $row['online_exam_id'] . '">Edit</button>
					';

					$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="' . $row['online_exam_id'] . '">Delete</button>';
				} else {
					$result_button = '<a href="exam_result.php?code=' . $row["online_exam_code"] . '" class="btn success btn-sm">Result</a>';
				}

				if ($exam->Is_allowed_add_question($row['online_exam_id'])) {
					$question_button = '
					<button type="button" name="add_question" class="btn btn-info btn-sm add_question" id="' . $row['online_exam_id'] . '">Add Question</button>&nbsp;<a href="question.php?code=' . $row['online_exam_code'] . '" class="btn btn-warning btn-sm">View Question</a>
					';
				} else {
					$question_button = '
					<a href="question.php?code=' . $row['online_exam_code'] . '" class="btn btn-warning btn-sm">View Question</a>
					';
				}

				$sub_array[] = $status;

				$sub_array[] = $question_button;

				$sub_array[] = '<a href="exam_enroll.php?code=' . $row['online_exam_code'] . '" class="btn warning btn-sm">Enrolled</a>';

				$sub_array[] = $result_button;

				$sub_array[] = $edit_button . ' ' . $delete_button;

				$data[] = $sub_array;
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data
			);

			echo json_encode($output);
		}


		if ($_POST['action'] == 'Add') {
			$exam_code = md5(rand());
			$user_year = $_POST['exam_year'];
			$user_course = $_POST['exam_course'];

			$exam->data = array(
				':admin_id'				=>	$_POST['staff_id'],
				':online_exam_title'	=>	$exam->clean_data($_POST['online_exam_title']),
				':online_exam_datetime'	=>	$_POST['online_exam_datetime'] . ':00',
				':online_exam_duration'	=>	$_POST['online_exam_duration'],
				// ':total_question'		=>	$_POST['total_question'],
				':user_year'			=>	$_POST['exam_year'],
				':user_course'			=>	$_POST['exam_course'],
				// ':marks_per_right_answer'=>	$_POST['marks_per_right_answer'],
				// ':marks_per_wrong_answer'=>	$_POST['marks_per_wrong_answer'],
				':online_exam_created_on' =>	$current_datetime,
				':online_exam_status'	=>	'Pending',
				':online_exam_code'		=>	$exam_code
			);

			$exam->query = "
			INSERT INTO online_exam_table 
			(admin_id, user_year, user_course, online_exam_title, online_exam_datetime, online_exam_duration,   online_exam_created_on, online_exam_status, online_exam_code) 
			VALUES (:admin_id, :user_year, :user_course, :online_exam_title, :online_exam_datetime, :online_exam_duration,   :online_exam_created_on, :online_exam_status, :online_exam_code)
			";
			$examid = "";
			$exam->execute_query();

			$results = mysqli_query($db, "SELECT * FROM online_exam_table where online_exam_code ='$exam_code';");

			if (mysqli_num_rows($results) == 1) {
				$rows = mysqli_fetch_array($results);
				$examid = $rows["online_exam_id"];
			}

			$results = mysqli_query($db, "INSERT INTO user_exam_enroll_table (user_id, exam_id) SELECT user_id, '$examid' FROM user_table WHERE user_year= '$user_year' and user_course = '$user_course';");



			$output = array(
				'success'	=>	'New Exam Added Successfully'
			);

			echo json_encode($output);
		}

		if ($_POST['action'] == 'edit_fetch') {
			$exam->query = "
			SELECT * FROM online_exam_table 
			WHERE online_exam_id = '" . $_POST["exam_id"] . "'
			";

			$result = $exam->query_result();

			foreach ($result as $row) {
				$output['online_exam_title'] = $row['online_exam_title'];

				$output['online_exam_datetime'] = $row['online_exam_datetime'];

				$output['online_exam_year'] = $row['user_year'];

				$output['online_exam_course'] = $row['user_course'];

				$output['total_question'] = $row['total_question'];

				$output['marks_per_right_answer'] = $row['marks_per_right_answer'];

				$output['marks_per_wrong_answer'] = $row['marks_per_wrong_answer'];
			}

			echo json_encode($output);
		}

		if ($_POST['action'] == 'Edit') {
			$exam->data = array(
				':online_exam_title'	=>	$_POST['online_exam_title'],
				':online_exam_datetime'	=>	$_POST['online_exam_datetime'] . ':00',
				':online_exam_duration'	=>	$_POST['online_exam_duration'],
				':exam_year'			=>	$_POST['exam_year'],
				':exam_course'			=>	$_POST['exam_course'],
				':total_question'		=>	$_POST['total_question'],
				':marks_per_right_answer' =>	$_POST['marks_per_right_answer'],
				':marks_per_wrong_answer' =>	$_POST['marks_per_wrong_answer'],
				':online_exam_id'		=>	$_POST['online_exam_id']
			);

			$exam->query = "
			UPDATE online_exam_table 
			SET online_exam_title = :online_exam_title, online_exam_datetime = :online_exam_datetime, user_year = :exam_year, user_course = :exam_course, online_exam_duration = :online_exam_duration, total_question = :total_question, marks_per_right_answer = :marks_per_right_answer, marks_per_wrong_answer = :marks_per_wrong_answer  
			WHERE online_exam_id = :online_exam_id
			";

			$exam->execute_query($exam->data);

			$output = array(
				'success'	=>	'Exam Details has been changed',
				'DATA' => $_POST
			);

			echo json_encode($output);
		}
		if ($_POST['action'] == 'delete') {
			$exam->data = array(
				':online_exam_id'	=>	$_POST['exam_id']
			);

			$exam->query = "
			DELETE FROM online_exam_table 
			WHERE online_exam_id = :online_exam_id
			";
			$e_id = $_POST['exam_id'];

			$exam->execute_query();

			$results = mysqli_query($db, "DELETE FROM user_exam_enroll_table	WHERE exam_id = '$e_id';");


			$output = array(
				'success'	=>	'Exam Details has been removed'
			);

			echo json_encode($output);
		}
	}


	// MASHAKA MAKUUUUBWA ------------------ HII ITAKUWA IMERUDIA

	//	if($_POST['page'] = 'question')
	//	{
	//		if($_POST['action'] == 'Add')
	//		{
	//			$exam->data = array(
	//				':online_exam_id'		=>	$_POST['online_exam_id'],
	//				':question_title'		=>	$exam->clean_data($_POST['question_title']),
	//				':answer_option'		=>	$_POST['answer_option']
	//			);
	//
	//			$exam->query = "
	//			INSERT INTO question_table 
	//			(online_exam_id, question_title, answer_option) 
	//			VALUES (:online_exam_id, :question_title, :answer_option)
	//			";
	//
	//			$question_id = $exam->execute_question_with_last_id($exam->data);
	//
	//			for($count = 1; $count <= 4; $count++)
	//			{
	//				$exam->data = array(
	//					':question_id'		=>	$question_id,
	//					':option_number'	=>	$count,
	//					':option_title'		=>	$exam->clean_data($_POST['option_title_' . $count])
	//				);
	//
	//				$exam->query = "
	//				INSERT INTO option_table 
	//				(question_id, option_number, option_title) 
	//				VALUES (:question_id, :option_number, :option_title)
	//				";
	//
	//				$exam->execute_query($exam->data);
	//			}
	//
	//			$output = array(
	//				'success'		=>	'Question Added'
	//			);
	//
	//			echo json_encode($output);
	//		}
	//	}
	//-->
	// MASHAKA MAKUUUUBWA ------------------ HII ITAKUWA IMERUDIA
	if ($_POST['page'] == 'question') {
		if ($_POST['action'] == 'Add') {
			$exam->data = array(
				':online_exam_id'		=>	$_POST['online_exam_id'],
				':question_title'		=>	$_POST['question_title'],
				':answer_option'		=>	$_POST['answer_option']
			);

			$exam->query = "
			INSERT INTO question_table 
			(online_exam_id, question_title, answer_option) 
			VALUES (:online_exam_id, :question_title, :answer_option)
			";

			$question_id = $exam->execute_question_with_last_id($exam->data);

			for ($count = 1; $count <= 4; $count++) {
				$exam->data = array(
					':question_id'		=>	$question_id,
					':option_number'	=>	$count,
					':option_title'		=>	$exam->clean_data($_POST['option_title_' . $count])
				);

				$exam->query = "
				INSERT INTO option_table 
				(question_id, option_number, option_title) 
				VALUES (:question_id, :option_number, :option_title)
				";

				$exam->execute_query($exam->data);
			}

			$output = array(
				'success'		=>	'Question Added',
			);

			echo json_encode($output);
		}


		if ($_POST['action'] == 'fetch') {
			$output = array();
			$exam_id = '';
			if (isset($_POST['code'])) {
				$exam_id = $exam->Get_exam_id($_POST['code']);
			}
			$exam->query = "
			SELECT * FROM question_table 
			WHERE online_exam_id = '" . $exam_id . "' 
			AND (
			";

			if (isset($_POST['search']['value'])) {
				$exam->query .= 'question_title LIKE "%' . $_POST["search"]["value"] . '%" ';
			}

			$exam->query .= ')';

			if (isset($_POST["order"])) {
				$exam->query .= '
				ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' 
				';
			} else {
				$exam->query .= 'ORDER BY question_id ASC ';
			}

			$extra_query = '';

			if ($_POST['length'] != -1) {
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM question_table 
			WHERE online_exam_id = '" . $exam_id . "'
			";

			$total_rows = $exam->total_row();

			$data = array();

			$cnt = 0;

			foreach ($result as $row) {
				$cnt++;
				$sub_array = array();
				$sub_array[] = $cnt;
				$sub_array[] = $row['question_title'];
				$exam->query = "select option_title from option_table where question_id=" . $row['question_id'] . " and option_number=" . $row['answer_option'];
				$option_result = $exam->query_result();
				// die(var_dump($option_result[0]['option_title']));
				$sub_array[] = '' . $option_result[0]['option_title'];

				$edit_button = '';
				$delete_button = '';

				if ($exam->Is_exam_is_not_started($exam_id)) {
					$edit_button = '<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="' . $row['question_id'] . '">Edit</button>';

					$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="' . $row['question_id'] . '">Delete</button>';
				}

				$sub_array[] = $edit_button . ' ' . $delete_button;

				$data[] = $sub_array;
			}


			$output = array(
				"draw"		=>	intval($_POST["draw"]),
				"recordsTotal"	=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"		=>	$data
			);

			echo json_encode($output);
		}

		if ($_POST['action'] == 'edit_fetch') {
			$exam->query = "
			SELECT * FROM question_table 
			WHERE question_id = '" . $_POST["question_id"] . "'
			";

			$result = $exam->query_result();

			foreach ($result as $row) {
				$output['question_title'] = html_entity_decode($row['question_title']);

				$output['answer_option'] = $row['answer_option'];

				for ($count = 1; $count <= 4; $count++) {
					$exam->query = "
					SELECT option_title FROM option_table 
					WHERE question_id = '" . $_POST["question_id"] . "' 
					AND option_number = '" . $count . "'
					";

					$sub_result = $exam->query_result();

					foreach ($sub_result as $sub_row) {
						$output["option_title_" . $count] = html_entity_decode($sub_row["option_title"]);
					}
				}
			}

			echo json_encode($output);
		}

		if ($_POST['action'] == 'Edit') {
			$exam->data = array(
				':question_title'		=>	$_POST['question_title'],
				':answer_option'		=>	$_POST['answer_option'],
				':question_id'			=>	$_POST['question_id']
			);

			$exam->query = "
			UPDATE question_table 
			SET question_title = :question_title, answer_option = :answer_option 
			WHERE question_id = :question_id
			";

			$exam->execute_query();

			for ($count = 1; $count <= 4; $count++) {
				$exam->data = array(
					':question_id'		=>	$_POST['question_id'],
					':option_number'	=>	$count,
					':option_title'		=>	$_POST['option_title_' . $count]
				);

				$exam->query = "
				UPDATE option_table 
				SET option_title = :option_title 
				WHERE question_id = :question_id 
				AND option_number = :option_number
				";
				$exam->execute_query();
			}

			$output = array(
				'success'	=>	'Question Edit'
			);

			echo json_encode($output);
		}

		// delete question
		if ($_POST['action'] == 'delete') {
			$exam->data = array(
				':question_id'	=>	$_POST['question_id']
			);

			$exam->query = "
			DELETE FROM question_table 
			WHERE question_id = :question_id
			";

			$exam->execute_query();

			$exam->query = "
			DELETE FROM option_table 
			WHERE question_id = :question_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Question Details has been removed'
			);

			echo json_encode($output);
		}
	}

	if ($_POST['page'] == 'user') {
		if ($_POST['action'] == 'load') {
			$output = array();


			$exam->query = "SELECT * FROM user_table ;";


			if (isset($_POST["search"]["value"])) {
				$exam->query .= 'user_email_address LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR user_name LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR user_rollno LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR user_course LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR user_year LIKE "%' . $_POST["search"]["value"] . '%" ';
			}

			if (isset($_POST["order"])) {
				$exam->query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' )';
			} else {
				$exam->query .= 'ORDER BY user_id DESC )';
			}

			$extra_query = '';

			if ($_POST["length"] != -1) {
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filterd_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM user_table";

			$total_rows = $exam->total_row();

			$data = array();
			$cnt = 0;
			foreach ($result as $row) {
				$cnt++;
				$sub_array = array();
				$sub_array[] = $cnt;
				$sub_array[] = '<img src="../upload/' . $row["user_image"] . '" class="img-thumbnail" width="75" />';
				$sub_array[] = $row["user_name"];
				$sub_array[] = $row["user_email_address"];
				$sub_array[] = $row["user_rollno"];
				$sub_array[] = $row["user_year"];

				$sub_array[] = $row["user_course"];
				// $is_email_verified = '';
				// if($row["user_email_verified"] == 'yes')
				// {
				// 	$is_email_verified = '<label class="badge badge-success">Yes</label>';
				// }
				// else
				// {
				// 	$is_email_verified = '<label class="badge badge-danger">No</label>';	
				// }

				// $sub_array[] = $is_email_verified;
				$sub_array[] = '<button type="button" name="view_details" class="btn btn-primary btn-sm details" id="' . $row["user_id"] . '">View Details</button>';

				$sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="' . $row["user_id"] . '"><i class="fa fa-trash"></i></button> &nbsp;<a type="button" name="edit" class="btn btn-success btn-sm edit" id="' . $row["user_id"] . '"><i class="fa fa-edit fa-sm"></i></a>';

				$data[] = $sub_array;
			}

			$output = array(
				"draw"    			=> 	intval($_POST["draw"]),
				"recordsTotal"  	=>  $total_rows,
				"recordsFiltered" 	=> 	$filterd_rows,
				"data"    			=> 	$data
			);
			echo json_encode($output);
		}


		if ($_POST['action'] == 'Add') {


			$exam->data = array(
				':user_name'			=>	$_POST['user_name'],
				':user_rollno'			=>	$_POST['user_rollno'],
				':user_year'			=>	$_POST['user_year'],
				':user_course'			=>	$_POST['user_course'],
				':user_gender'			=>	$_POST['user_gender'],
				':user_dob'				=>	$_POST['user_dob'],
				':user_email_address'	=>	$_POST['user_email_address'],
				':user_mobile_no'		=>	$_POST['user_mobile_no'],
				':user_address'			=>	$_POST['user_address']
			);

			$exam->query = "
			INSERT INTO user_table
			(user_name, user_rollno, user_course, user_year, user_gender, user_dob, user_email_address, user_mobile_no,user_address) 
			VALUES (:user_name, :user_rollno, :user_course, :user_year, :user_gender, :user_dob, :user_email_address, :user_mobile_no, :user_address);
			";

			$exam->execute_query();


			$output = array(
				'success'	=>	'User Added Successfully'
			);

			echo json_encode($output);
		}




		if ($_POST['action'] == 'delete') {
			$exam->data = array(
				':user_id'	=>	$_POST['user_id']
			);


			$exam->query = "
			DELETE FROM user_table WHERE user_id = :user_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'User Details has been removed'
			);

			echo json_encode($output);
		}


		if ($_POST['action'] == 'fetch') {
			$output = array();

			$course = $_POST['course'];
			$year = $_POST['year'];

			$exam->query = "SELECT * FROM user_table WHERE user_course = '$course' and user_year = '$year' ; ";


			if (isset($_POST["search"]["value"])) {
				$exam->query .= 'user_email_address LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR user_name LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR user_rollno LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR user_course LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR user_year LIKE "%' . $_POST["search"]["value"] . '%" ';
			}

			if (isset($_POST["order"])) {
				$exam->query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' )';
			} else {
				$exam->query .= 'ORDER BY user_id DESC )';
			}

			$extra_query = '';

			if ($_POST["length"] != -1) {
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filterd_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM user_table";

			$total_rows = $exam->total_row();

			$data = array();
			$cnt = 0;
			foreach ($result as $row) {
				$cnt++;
				$sub_array = array();
				$sub_array[] = $cnt;
				$sub_array[] = '<img src="../upload/' . $row["user_image"] . '" class="img-thumbnail" width="75" />';
				$sub_array[] = $row["user_name"];
				$sub_array[] = $row["user_email_address"];
				$sub_array[] = $row["user_rollno"];
				$sub_array[] = $row["user_year"];

				$sub_array[] = $row["user_course"];
				// $is_email_verified = '';
				// if($row["user_email_verified"] == 'yes')
				// {
				// 	$is_email_verified = '<label class="badge badge-success">Yes</label>';
				// }
				// else
				// {
				// 	$is_email_verified = '<label class="badge badge-danger">No</label>';	
				// }

				// $sub_array[] = $is_email_verified;
				$sub_array[] = '<button type="button" name="view_details" class="btn btn-primary btn-sm details" id="' . $row["user_id"] . '">View Details</button>';

				$sub_array[] = '<button type="button" name="delete"  class="btn btn-danger btn-sm delete" id="' . $row["user_id"] . '"><i class="fa fa-trash"></i></button><button type="button" name="edit" class="btn btn-success btn-sm edit" id="' . $row["user_id"] . '"><i class="fa fa-edit fa-sm"></i></button>';

				$data[] = $sub_array;
			}

			$output = array(
				"draw"    			=> 	intval($_POST["draw"]),
				"recordsTotal"  	=>  $total_rows,
				"recordsFiltered" 	=> 	$filterd_rows,
				"data"    			=> 	$data
			);
			echo json_encode($output);
		}
		if ($_POST['action'] == 'fetch_data') {
			$exam->query = "
			SELECT * FROM user_table 
			WHERE user_id = '" . $_POST["user_id"] . "'
			";
			$result = $exam->query_result();
			$output = '';
			foreach ($result as $row) {

				$output .= '
				<div class="row">
					<div class="col-md-12">
						<div align="center">
							<img src="../upload/' . $row["user_image"] . '" class="img-thumbnail" width="200" />
						</div>
						<br />
						<table class="table table-bordered">
							<tr>
								<th>Name</th>
								<td>' . $row["user_name"] . '</td>
							</tr>
							<tr>
								<th>Gender</th>
								<td>' . $row["user_gender"] . '</td>
							</tr>
							<tr>
								<th>Address</th>
								<td>' . $row["user_address"] . '</td>
							</tr>
							<tr>
								<th>Date of Birth</th>
								<td>' . $row["user_dob"] . '</td>
							</tr>
							<tr>
								<th>Mobile No.</th>
								<td>' . $row["user_mobile_no"] . '</td>
							</tr>
							<tr>
								<th>Email</th>
								<td>' . $row["user_email_address"] . '</td>
							</tr>
						</table>
					</div>
				</div>
				';
			}
			echo $output;
		}

		if ($_POST['action'] == 'edit_fetch') {
			$exam->query = "
			SELECT * FROM user_table 
			WHERE user_id = '" . $_POST["user_id"] . "'
			";

			$result = $exam->query_result();

			foreach ($result as $row) {
				$output['user_name'] = html_entity_decode($row['user_name']);
				$output['user_rollno'] = $row['user_rollno'];
				$output['user_year'] = $row['user_year'];
				$output['user_course'] = $row['user_course'];
				$output['user_gender'] = $row['user_gender'];
				$output['user_dob'] = $row['user_dob'];
				$output['user_email_address'] = $row['user_email_address'];
				$output['user_mobile_no'] = $row['user_mobile_no'];
				$output['user_address'] = $row['user_address'];
				$output['user_id'] = $row["user_id"];
			}



			echo json_encode($output);
		}

		if ($_POST['action'] == 'Edit') {
			$exam->data = array(
				':user_id'      =>  $_POST['user_id'],
				':user_name'	=>	$_POST['user_name'],
				':user_rollno'	=>	$_POST['user_rollno'],
				':user_year'	=>	$_POST['user_year'],
				':user_course'	=>	$_POST['user_course'],
				':user_gender'	=>	$_POST['user_gender'],
				':user_dob'		=>	$_POST['user_dob'],
				':user_email_address' =>	$_POST['user_email_address'],
				':user_mobile_no' =>	$_POST['user_mobile_no'],
				':user_address'		=>	$_POST['user_address']
			);

			$exam->query = "
			UPDATE user_table 
			SET user_name = :user_name, user_rollno = :user_rollno, user_year = :user_year, user_course = :user_course, user_gender = :user_gender, user_dob = :user_dob, user_email_address = :user_email_address, user_mobile_no = :user_mobile_no,  user_address =:user_address
			WHERE user_id = :user_id
			";

			$exam->execute_query($exam->data);

			$output = array(
				'success'	=>	'User Details has been changed',
				'DATA' => $_POST
			);

			echo json_encode($output);
		}
	}


	if ($_POST['page'] == 'staff') {
		if ($_POST['action'] == 'load') {
			$output = array();


			$exam->query = "SELECT * FROM admin_table ;";


			if (isset($_POST["search"]["value"])) {
				$exam->query .= 'admin_email_address LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR admin_name LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR staff_id LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR admin_course LIKE "%' . $_POST["search"]["value"] . '%" ';
			}

			if (isset($_POST["order"])) {
				$exam->query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' )';
			} else {
				$exam->query .= 'ORDER BY user_id DESC )';
			}

			$extra_query = '';

			if ($_POST["length"] != -1) {
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filterd_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM admin_table";

			$total_rows = $exam->total_row();

			$data = array();
			$cnt = 0;
			foreach ($result as $row) {
				$cnt++;
				$sub_array = array();
				$sub_array[] = $cnt;

				$sub_array[] = $row["admin_name"];
				$sub_array[] = $row["admin_email_address"];

				$sub_array[] = $row["admin_course"];

				$sub_array[] = $row["admin_contact"];
				// $is_email_verified = '';
				// if($row["user_email_verified"] == 'yes')
				// {
				// 	$is_email_verified = '<label class="badge badge-success">Yes</label>';
				// }
				// else
				// {
				// 	$is_email_verified = '<label class="badge badge-danger">No</label>';	
				// }

				// $sub_array[] = $is_email_verified;
				// $sub_array[] = '<button type="button" name="view_details" class="btn btn-primary btn-sm details" id="'.$row["user_id"].'">View Details</button>';

				$sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="' . $row["admin_id"] . '"><i class="fa fa-trash"></i></button> &nbsp;<a type="button" name="edit" class="btn btn-success btn-sm edit" id="' . $row["admin_id"] . '"><i class="fa fa-edit fa-sm"></i></a>';
				$data[] = $sub_array;
			}

			$output = array(
				"draw"    			=> 	intval($_POST["draw"]),
				"recordsTotal"  	=>  $total_rows,
				"recordsFiltered" 	=> 	$filterd_rows,
				"data"    			=> 	$data
			);
			echo json_encode($output);
		}

		if ($_POST['action'] == 'delete') {
			$exam->data = array(
				':admin_id'	=>	$_POST['admin_id']
			);


			$exam->query = "
			DELETE FROM admin_table WHERE admin_id = :admin_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Staff Details has been removed'
			);

			echo json_encode($output);
		}



		if ($_POST['action'] == 'fetch') {
			$output = array();

			$course = $_POST['course'];


			$exam->query = "SELECT * FROM admin_table WHERE admin_course = '$course' ; ";


			if (isset($_POST["search"]["value"])) {
				$exam->query .= 'admin_email_address LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR admin_name LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR staff_id LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR admin_course LIKE "%' . $_POST["search"]["value"] . '%" ';
			}

			if (isset($_POST["order"])) {
				$exam->query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' )';
			} else {
				$exam->query .= 'ORDER BY user_id DESC )';
			}

			$extra_query = '';

			if ($_POST["length"] != -1) {
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filterd_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM admin_table";

			$total_rows = $exam->total_row();

			$data = array();
			$cnt = 0;
			foreach ($result as $row) {
				$cnt++;
				$sub_array = array();
				$sub_array[] = $cnt;
				$sub_array[] = $row["admin_name"];
				$sub_array[] = $row["admin_email_address"];

				$sub_array[] = $row["admin_course"];

				$sub_array[] = $row["admin_contact"];
				// $is_email_verified = '';
				// if($row["user_email_verified"] == 'yes')
				// {
				// 	$is_email_verified = '<label class="badge badge-success">Yes</label>';
				// }
				// else
				// {
				// 	$is_email_verified = '<label class="badge badge-danger">No</label>';	
				// }

				// $sub_array[] = $is_email_verified;
				// $sub_array[] = '<button type="button" name="view_details" class="btn btn-primary btn-sm details" id="' . $row["user_id"] . '">View Details</button>';

				$sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="' . $row["admin_id"] . '"><i class="fa fa-trash"></i></button> &nbsp;<a type="button" name="edit" class="btn btn-success btn-sm edit" id="' . $row["admin_id"] . '"><i class="fa fa-edit fa-sm"></i></a>';



				$data[] = $sub_array;
			}

			$output = array(
				"draw"    			=> 	intval($_POST["draw"]),
				"recordsTotal"  	=>  $total_rows,
				"recordsFiltered" 	=> 	$filterd_rows,
				"data"    			=> 	$data
			);
			echo json_encode($output);
		}
		if ($_POST['action'] == 'edit_fetch') {
			$exam->query = "
			SELECT * FROM admin_table 
			WHERE admin_id = '" . $_POST["admin_id"] . "'
			";

			$result = $exam->query_result();

			foreach ($result as $row) {
				$output['admin_name'] = html_entity_decode($row['admin_id']);
				$output['admin_email_address'] = $row['admin_email_address'];
				// $output['admin_password'] = $row['admin_password'];
				$output['admin_course'] = $row['admin_course'];
				$output['admin_gender'] = $row['admin_gender'];
				$output['admin_contact'] = $row['admin_contact'];
				$output['admin_id'] = $row["admin_id"];
			}



			echo json_encode($output);
		}

		if ($_POST['action'] == 'Edit') {
			$exam->data = array(
				':admin_id'      =>  $_POST['admin_id'],
				':admin_name'	=>	$_POST['admin_name'],
				':admin_email_address'	=>	$_POST['admin_email_address'],
				// ':admin_password'	=>	password_hash($_POST['admin_password'], PASSWORD_DEFAULT),
				':admin_course'	=>	$_POST['admin_course'],
				':admin_gender'	=>	$_POST['admin_gender'],
				':admin_contact'		=>	$_POST['admin_contact'],
			);

			$exam->query = "
			UPDATE admin_table 
			SET admin_name = :admin_name, admin_email_address = :admin_email_address, admin_course = :admin_course, admin_gender = :admin_gender,  admin_contact =:admin_contact
			WHERE admin_id = :admin_id
			";

			$exam->execute_query($exam->data);

			$output = array(
				'success'	=>	'Staff Details has been changed',
				// 'DATA' => $_POST
			);

			echo json_encode($output);
		}
	}





	if ($_POST['page'] == 'exam_enroll') {
		if ($_POST['action'] == 'fetch') {
			$output = array();

			$exam_id = $exam->Get_exam_id($_POST['code']);

			$exam->query = "
			SELECT * FROM user_exam_enroll_table 
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_enroll_table.user_id  
			WHERE user_exam_enroll_table.exam_id = '" . $exam_id . "' 
			AND (
			";

			if (isset($_POST['search']['value'])) {
				$exam->query .= '
				user_table.user_name LIKE "%' . $_POST["search"]["value"] . '%" 
				';
				$exam->query .= 'OR user_table.user_gender LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR user_table.user_mobile_no LIKE "%' . $_POST["search"]["value"] . '%" ';
				$exam->query .= 'OR user_table.user_email_verified LIKE "%' . $_POST["search"]["value"] . '%" ';
			}
			$exam->query .= ') ';

			if (isset($_POST['order'])) {
				$exam->query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
			} else {
				$exam->query .= 'ORDER BY user_exam_enroll_table.user_exam_enroll_id ASC ';
			}

			$extra_query = '';

			if ($_POST['length'] != -1) {
				$extra_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM user_exam_enroll_table 
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_enroll_table.user_id  
			WHERE user_exam_enroll_table.exam_id = '" . $exam_id . "'
			";

			$total_rows = $exam->total_row();

			$data = array();

			$cnt = 0;

			foreach ($result as $row) {
				$cnt++;
				$sub_array = array();
				$sub_array[] = $cnt;
				$sub_array[] = "<img src='../upload/" . $row["user_image"] . "' class='img-thumbnail' width='75' />";
				$sub_array[] = $row["user_name"];
				$sub_array[] = $row["user_rollno"];
				$sub_array[] = $row["user_email_address"];
				$sub_array[] = $row["user_gender"];

				$attendace = '';

				if ($row["attendance_status"] == 'Present') {
					$attendace = '<label class="badge badge-success">Present</label>';
				} else {
					$attendace = '<label class="badge badge-danger">Absent</label>';
				}
				$sub_array[] = $attendace;

				$sub_array[] = $row["exam_intime"];
				$sub_array[] = $row["exam_outtime"];

				$examstatus = '';

				if ($row["exam_status"] == 'Completed') {
					$examstatus = '<label class="badge badge-success">Exam Completed</label>';
				} else {
					$examstatus = '<label class="badge badge-danger">Exam Not Completed</label>';
				}
				$sub_array[] = $examstatus;


				$sub_array[] = $row["remark"];

				$result = '';


				if ($exam->Get_exam_status($exam_id) == 'Completed') {
					$result = '<a href="user_exam_result.php?code=' . $_POST['code'] . '&id=' . $row['user_id'] . '" class="btn blue btn-sm" target="_blank">Result</a>';
				}
				$sub_array[] = $result;

				$data[] = $sub_array;
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data
			);

			echo json_encode($output);
		}
	}

	if ($_POST['page'] == 'exam_result') {
		if ($_POST['action'] == 'fetch') {
			$output = array();
			$exam_id = $exam->Get_exam_id($_POST["code"]);
			$exam->query = "
			SELECT user_table.user_id, user_table.user_image, user_table.user_name, sum(user_exam_question_answer.marks) as total_mark  
			FROM user_exam_question_answer  
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_question_answer.user_id 
			WHERE user_exam_question_answer.exam_id = '$exam_id' 
			AND (
			";

			if (isset($_POST["search"]["value"])) {
				$exam->query .= 'user_table.user_name LIKE "%' . $_POST["search"]["value"] . '%" ';
			}

			$exam->query .= '
			) 
			GROUP BY user_exam_question_answer.user_id 
			';

			if (isset($_POST["order"])) {
				$exam->query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
			} else {
				$exam->query .= 'ORDER BY total_mark DESC ';
			}

			$extra_query = '';

			if ($_POST["length"] != -1) {
				$extra_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT 	user_table.user_image, user_table.user_name, sum(user_exam_question_answer.marks) as total_mark  
			FROM user_exam_question_answer  
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_question_answer.user_id 
			WHERE user_exam_question_answer.exam_id = '$exam_id' 
			GROUP BY user_exam_question_answer.user_id 
			ORDER BY total_mark DESC
			";

			$total_rows = $exam->total_row();

			$data = array();
			$cnt = 0;
			foreach ($result as $row) {
				$cnt++;
				$sub_array = array();
				$sub_array[] = $cnt;
				$sub_array[] = '<img src="../upload/' . $row["user_image"] . '" class="img-thumbnail" width="75" />';
				$sub_array[] = $row["user_name"];
				$sub_array[] = $exam->Get_user_exam_status($exam_id, $row["user_id"]);
				$sub_array[] = $row["total_mark"];
				$data[] = $sub_array;
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data
			);

			echo json_encode($output);
		}
	}
}
