<?php
require 'authentication.php'; // admin authentication check 

// auth check
if (isset($_SESSION['admin_id'])) {
	$user_id = $_SESSION['admin_id'];
	$user_name = $_SESSION['name'];
	$security_key = $_SESSION['security_key'];
}

if (isset($_POST['change_password_btn'])) {
	$info = $obj_admin->change_password_for_employee($_POST);
}

$page_name = "Login";
include("include/lib_links.php");

?>

<style>
	body {
		background: url(assets/login-bg.png);
		background-size: cover !important;
	}
</style>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Change password - Task Planner</title>
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
					<h2>Create a new password for this account</h2>
					<span>Great! You're one step closer into acccessing your account. By going here, we assume you have been given a temporary password for this account. Please enter a new password for the temporary password to be replaced with yours.</span>
				</div>

				<form action="" method="POST">

					<div class="login-form">
						<?php if (isset($info)) { ?>
							<span class="status-indicator incomplete"><?php echo $info; ?></span>
						<?php } ?>
						<input type="hidden" class="form-control" name="user_id" value="<?php echo $user_id; ?>" required />
						
						<div class="input-group">
							<input type="password" name="password" title="Password must be at least 8 characters long and contain at least one letter and one digit." pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}" required>
							<label for="password">Enter new password</label>
						</div>

						<div class="input-group">
							<input type="password" name="re_password" title="Password must be at least 8 characters long and contain at least one letter and one digit." pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}" required>
							<label for="re_password">Re-type password</label>
						</div>

						<button type="submit" name="change_password_btn" class="submitBtn">Create password</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>



<?php

include("include/footer.php");

?>