<?php

require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
	header('Location: index');
}

// check admin
$user_role = $_SESSION['user_role'];

$task_id = $_GET['task_id'];



if (isset($_POST['update_task_info'])) {
	$obj_admin->update_task_info($_POST, $task_id, $user_role, $id);
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

<head>
	<title>Task Details</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<!--modal for employee add-->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div id="modalBG" style="visibility: visible; opacity: 1; transition: none">
	<div class="modal" style="visibility: visible; opacity: 1; transform: scale(1.0); transition: none">
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

		<div class="h-wrapper">
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
			} elseif ($row['status'] == 3) {
				echo "<div class='status-indicator failedtosub'>Failed to Submit</div>";
			} else {
				echo "<div class='status-indicator pending'>Pending</div>";
			} ?>
		</div>


		<div class="v-wrapper">
			<!-- TODO: preview image of what the user has sent -->
			<label>Attached proof</label>
			<?php if (!empty($row['proof'])) {
				$file_info = new finfo(FILEINFO_MIME_TYPE);
				$mime_type = $file_info->buffer(file_get_contents($row['proof']));
				if (strstr($mime_type, "image/")) { ?>
					<a href="<?php echo $row['proof']; ?>" target="_blank">
						<div class="img-container" style="width: 100%"><img src="<?php echo $row['proof']; ?>" alt=""></div>
					</a>
				<?php } else { ?>
					<div class="file-container">
						<a href="<?php echo $row['proof']; ?>" target="_blank"><i class="ri-external-link-line"></i><?php echo basename($row['proof']); ?></a>
					</div>
				<?php }
			} else { ?>
				<div class="status-indicator failedtosub"><i class="ri-close-line"></i>No attachment is provided.</div>
			<?php } ?>
		</div>




		<div class="v-wrapper">
			<!-- TODO: preview of what the supervisor has sent -->
			<label>Attached Task</label>
			<?php if (!empty($row['task_img'])) {
				$file_info = new finfo(FILEINFO_MIME_TYPE);
				$mime_type = $file_info->buffer(file_get_contents($row['task_img']));
				if (strstr($mime_type, "image/")) { ?>
					<a href="<?php echo $row['task_img']; ?>" target="_blank">
						<div class="img-container" style="width: 100%"><img src="<?php echo $row['task_img']; ?>" alt=""></div>
					</a>
				<?php } else { ?>
					<div class="file-container">
						<a href="<?php echo $row['task_img']; ?>" target="_blank"><i class="ri-external-link-line"></i><?php echo basename($row['task_img']); ?></a>
					</div>
				<?php }
			} else { ?>
				<p><i class="ri-close-line"></i>No task attachment has been given for this task.</p>
			<?php } ?>
		</div>
		<div class="btnSection">
			<button onclick="window.history.back();">Back</button>
		</div>
	</div>
	<?php


	include("include/footer.php");

	?>