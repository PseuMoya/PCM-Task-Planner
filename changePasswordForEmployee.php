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

<form action="" method="POST">
	<div id="modalBG" style="display: grid; place-items:center">
		<div class="modal" style="max-width: 450px;">
			<?php if (isset($info)) { ?>
				<span class="status-indicator incomplete"><?php echo $info; ?></span>
			<?php } ?>

			<div class="modalTitle">
				<h2>Create a new password your account</h2>
				<span>Great! You're one step closer into acccessing your account. By going here, we assume you have been given a temporary password for this account. Please enter a new password for the temporary password to be replaced with yours.</span>
			</div>

			<div class="v-wrapper">
				<input type="hidden" class="form-control" name="user_id" value="<?php echo $user_id; ?>" required />
				<input type="password" class="form-control" placeholder="Enter new password" name="password" required />
				<input type="password" class="form-control" placeholder="Re-type password" name="re_password" required />
			</div>
			<div class="btnSection">
				<button type="submit" name="change_password_btn" class="btn btn-default pull-right">Create password</button>
			</div>
		</div>
	</div>
</form>



<?php

include("include/footer.php");

?>