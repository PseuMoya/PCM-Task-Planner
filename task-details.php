<?php

require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
	header('Location: index.php');
}

// check admin
$user_role = $_SESSION['user_role'];

$task_id = $_GET['task_id'];



if (isset($_POST['update_task_info'])) {
	$obj_admin->update_task_info($_POST, $task_id, $user_role);
}

$page_name = "Edit Task";
include("include/lib_links.php");

$sql = "SELECT a.*, b.fullname 
FROM task_info a
LEFT JOIN tbl_admin b ON(a.t_user_id = b.user_id)
WHERE task_id='$task_id'";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

?>

<!--modal for employee add-->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="modal">
	<div class="modalTitle">
		<h2>Task details</h2>
	</div>
	
	<div class="v-wrapper">
		<label for="task_title">Task Title</label>
		<p><?php echo $row['t_title']; ?></p>
	</div>
	
	<div class="v-wrapper">
		<label for="task_description">Task Description</label>
		<p><?php echo $row['t_description']; ?></p>
	</div>

	<div class="h-wrapper" style="gap: 1em">
		<div class="v-wrapper">
			<label for="t_start_time">Start Time</label>
			<p><?php echo $row['t_start_time']; ?></p>
		</div>

		<div class="v-wrapper">
			<label for="t_end_time">End Time</label>
			<p><?php echo $row['t_end_time']; ?></p>
		</div>
	</div>

	<div class="v-wrapper">
		<label for="assign_to">Assigned to</label>
		<p><?php echo $row['fullname']; ?></p>
	</div>

	<div class="v-wrapper">
		<label for="status">Status</label>
		<?php if ($row['status'] == 1) {
			echo "<div class='status-indicator in-progress'>In Progress</div>";
		} elseif ($row['status'] == 2) {
			echo "<div class='status-indicator completed'>Completed</div>";
		} else {
			echo "<div class='status-indicator incomplete'>Incomplete</div>";
		} ?>
	</div>

	<div class="btnSection">
		<a href="task-info"><button>Go back</button></a>
	</div>
</div>
<?php


include("include/footer.php");

?>