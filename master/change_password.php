<?php

include('header.php');

?>
<br>


<div class="containter">
	<h1 style="align-content: center;font-size:50px;font-family:cursive;" align="center">Change Password</h1><br>

	<div class="container">

		<div class="row">
			<div class="col-md-3">

			</div>
			<div class="col-md-6" style="margin-top:50px;">


				<span id="message">
					<?php
					if (isset($_GET['verified'])) {
						echo '
		<div class="alert alert-success">
		  Your email has been verified, now you can login
		</div>
		';
					}
					?>
				</span>
				<div class="card border border-success">
					<div class="card-header">Change Password
					</div>
					<!-- <div class="card-header" style="font-family:comic sans MS;color:blue;font-size:larger;"><center>Student Login</center></div> -->
					<div class="card-body">
						<form method="post" id="change_password_form">
							<div class="form-group">
								<label style="top:5px;">Enter Password : </label>
								<div style="margin-bottom: 25px;top:5px" class="input-group">
									<input type="password" name="user_password" id="user_password" class="form-control" />

								</div>
								<!-- <input type="text" name="user_email_address" id="user_email_address" class="form-control" /> -->
							</div>
							<div class="form-group">
								<label>Enter Confirm Password : </label>
								<div style="margin-bottom: 15px" class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<input type="password" name="confirm_user_password" id="confirm_user_password" class="form-control" />
								</div>

								<!-- <input type="password" name="user_password" id="user_password" class="form-control" /> -->
							</div>

							<div class="form-group" align="center">
								<input type="hidden" name="page" value="change_password" />
								<input type="hidden" name="action" value="change_password" />
								<input type="submit" name="user_password" id="user_password" class="btn blue" value="Change" />
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



	<script>
		$(document).ready(function() {

			$('#change_password_form').parsley();

			$('#change_password_form').on('submit', function(event) {
				event.preventDefault();

				$('#user_password').attr('required', 'required');

				$('#confirm_user_password').attr('required', 'required');

				$('#confirm_user_password').attr('data-parsley-equalto', '#user_password');

				if ($('#change_password_form').parsley().validate()) {
					$.ajax({
						url: "ajax_action.php",
						method: "POST",
						data: $(this).serialize(),
						dataType: "json",
						beforeSend: function() {
							$('#change_password').attr('disabled', 'disabled');
							$('#change_password').val('please wait...');
						},
						success: function(data) {
							if (data.success) {
								alert(data.success);
								location.reload(true);
							}
							$('#change_password').attr('disabled', false);
							$('#change_password').val('Change');
						}
					})
				}
			});

		});
	</script>