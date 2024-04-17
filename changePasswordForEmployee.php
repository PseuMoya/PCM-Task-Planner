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
</head>

<body>
	<form action="" method="POST">
		<div id="modalBG" style="visibility: visible; opacity: 1; transition: none; place-items: center;">
		<div class="modal" style="visibility: visible; opacity: 1; transform: scale(1.0); transition: none; width: 50%; justify-content: center;">
				<?php if (isset($info)) { ?>
					<span class="status-indicator incomplete"><?php echo $info; ?></span>
				<?php } ?>

				<div class="modalTitle">
					<h2>Create a new password for this account</h2>
					<span>Great! You're one step closer into acccessing your account. By going here, we assume you have been given a temporary password for this account. Please enter a new password for the temporary password to be replaced with yours.</span>
				</div>

				<div class="v-wrapper">
					<input type="hidden" class="form-control" name="user_id" value="<?php echo $user_id; ?>" required />
					<input type="password" class="form-control" placeholder="Enter new password" name="password" title="Password must be at least 8 characters long and contain at least one letter and one digit." pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}" required />
					<input type="password" class="form-control" placeholder="Re-type password" name="re_password" title="Password must be at least 8 characters long and contain at least one letter and one digit." pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}" required />
				</div>
				<div class="btnSection">
					<button type="submit" name="change_password_btn" class="btn btn-default pull-right">Create password</button>
				</div>
			</div>
		</div>
	</form>
</body>



<?php

include("include/footer.php");

?>