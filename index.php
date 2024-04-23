<?php
require 'authentication.php'; // admin authentication check 

// auth check
if (isset($_SESSION['admin_id'])) {
	$user_id = $_SESSION['admin_id'];
	$user_name = $_SESSION['admin_name'];
	$security_key = $_SESSION['security_key'];
	if ($user_id != NULL && $security_key != NULL) {
		header('Location: task-info');
	}
}

if (isset($_POST['login_btn'])) {
	$info = $obj_admin->admin_login_check($_POST);
}

$page_name = "Login";
include("include/lib_links.php");

?>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - TaskPlanner</title>
</head>

<body>
	<div class="header-logo">
		<div class="img-container"><img src="assets/fragranza.png" alt="fragranza olio"></div>
		<div class="img-container"><img class="invert-logo" src="assets/pcm.png" alt="pcm"></div>
	</div>

	<div class="loginModalBG">
		<div class="loginModal">

			<div class="v-wrapper">

				<div class="login-text">
					<h1>Login</h1>
					<p>Enter your account details.</p>
				</div>
				
				<form class="form-login" action="" method="POST">
					<div class="login-form">
						<?php if (isset($info)) { ?>
							<div class="status-indicator failedtosub"><?php echo $info; ?></div>
						<?php } ?>
						<div class="input-group">
							<input type="text" class="inputted" name="username" required>
							<label for="email">Username</label>
						</div>
						<div class="input-group">
							<input type="password" name="admin_password" required>
							<label id="admin_password" for="admin_password" name="admin_password">Password</label>
							<span toggle="#admin_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
						</div>

						<button type="submit" name="login_btn" class="loginBtn">Login</button>
					</div>
				</form>

			</div>

		</div>
	</div>

	<script>
		$(document).ready(function() {
			$(".toggle-password").click(function() {
				$(this).toggleClass("fa-eye fa-eye-slash");
				var input = $($(this).attr("toggle"));
				if (input.attr("type") == "password") {
					input.attr("type", "text");
				} else {
					input.attr("type", "password");
				}
			});
		});
	</script>
</body>

<?php

include("include/footer.php");

?>