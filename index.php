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
include("include/login_header.php");

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>LOGIN</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

		.main {
			margin: 0;
			padding: 0;
			position: static;
			width: 100% !important;
		}

		body,
		html {
			margin: 0 !important;
			padding: 0 !important;
			background: url(assets/login-bg.png);
			background-size: cover !important;
			font-family: "Poppins", sans-serif;

		}

		.form-custom-login {
			border-color: transparent !important;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;

		}

		.login-section {

			display: flex;
			justify-content: center !important;
			align-items: center !important;
			height: 100vh;
			width: 100% !important;
			position: relative;
		}

		.login-container {
			display: flex;
			justify-content: start;
			align-items: center;
			width: 516px;
			height: 630px;
			border-color: transparent !important;
			padding: 20px;
			background: linear-gradient(140.78deg, rgba(0, 0, 0, 0.3) -0.22%, rgba(0, 0, 0, 0.1) 96.15%);
			backdrop-filter: blur(7.5px);
			border-radius: 20px;
			padding: 0px 50px;
		}

		.form-login {
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: flex-start;
			text-align: left;
			width: 100%;
		}

		.inputted {
			background-color: transparent !important;
			border: 1px solid transparent !important;
			border-bottom: 1px solid #fff !important;
			width: 100% !important;
			font-size: 24px;
			margin: 10px 0px;
			color: #fff;
		}

		.btn-login {
			background-color: #fff;
			color: #000;
			border: 1px solid #676767 !important;
			border-radius: 20px;
			padding: 10px 20px;
			width: 100% !important;
			margin-top: 20px;

		}

		.header-log {
			display: flex;
			flex-direction: column;
			justify-content: flex-start !important;
			align-items: flex-start !important;
			color: #fff;
			margin-bottom: 70px;
		}

		.header-log h1 {
			font-size: 50px;
			font-weight: 800;
		}

		.header-log p {
			font-size: 20px;
			font-weight: 400;
			color: rgba(255, 255, 255, 0.7);
			margin-top: 10px;
		}

		.form-inputted {
			width: 100%;
		}

		.logo {
			position: absolute;
			left: 70px;
			top: 50px;
		}


		.inputted {
			width: 100%;
			padding: 12px 20px;
			margin: 8px 0;
			box-sizing: border-box;
			border: 2px solid #ccc;
			border-radius: 4px;
		}
	</style>


</head>

<body>

	<div class="logo">
		<img src="assets/logo-fr.png" alt="">
	</div>

	<div class="login-section">
		<div class="login-container">

			<form class="form-login" action="" method="POST">
				<?php if (isset($info)) { ?>
					<h5 class="alert alert-danger"><?php echo $info; ?></h5>
				<?php } ?>
				<div class="header-log">
					<h1>Login</h1>
					<p>Enter your account details</p>
				</div>
				<div class="form-inputted">
					<input type="text" class="inputted" placeholder="Username" name="username" required />
				</div>
				<div class="form-inputted" ng-class="{'has-error': loginForm.password.$invalid && loginForm.password.$dirty, 'has-success': loginForm.password.$valid}">
					<input type="password" class="inputted" placeholder="Password" name="admin_password" required />
				</div>
				<button type="submit" name="login_btn" class="btn-login">Login</button>

			</form>


		</div>

	</div>


	<!-- <section class="bg-login">
	<div class="row">
	<div class="col-md-4 col-md-offset-3">
		<div class="well form" style="position:relative;top:20vh;">
		<center><h2 style="margin-top:1px; color: white; font-weight: 800; font-size: 50px">LOGIN</h2></center>
			<form class="form-horizontal form-custom-login" action="" method="POST">			
			<?php if (isset($info)) { ?>
			  <h5 class="alert alert-danger"><?php echo $info; ?></h5>
			  <?php } ?>
			  <div class="form-group">
			    <input type="text" class="form-control" placeholder="Username" name="username" required/>
			  </div>
			  <div class="form-group" ng-class="{'has-error': loginForm.password.$invalid && loginForm.password.$dirty, 'has-success': loginForm.password.$valid}">
			    <input type="password" class="form-control" placeholder="Password" name="admin_password" required/>
			  </div>
			  <button type="submit" name="login_btn" class="btn btn-info pull-right">Login</button>
			</form>
		</div>
	</div>
</div>
</section> -->
</body>

</html>



<?php

include("include/footer.php");

?>