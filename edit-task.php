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
	$obj_admin->update_task_info($_POST, $task_id, $user_role);
}

$page_name = "Edit Task";
include("include/lib_links.php");

$sql = "SELECT * FROM task_info WHERE task_id='$task_id' ";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

?>

<head>
	<title>Edit Task</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<!--modal for employee add-->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<form role="form" action="" enctype="multipart/form-data" method="post" autocomplete="off">
	<div id="modalBG" style="visibility: visible; opacity: 1; transition: none">
		<div class="modal" style="visibility: visible; opacity: 1; transform: scale(1.0); transition: none">
			<div class="modalTitle">
				<h2>Edit Task</h2>
			</div>

			<div class="v-wrapper">
				<label for="task_title">Task Title</label>
				<input type="text" placeholder="Task Title" id="task_title" name="task_title" list="expense" class="form-control" value="<?php echo $row['t_title']; ?>" <?php if ($user_role != 1) { ?> readonly <?php } ?> val required>
			</div>

			<div class="v-wrapper">
				<label for="task_description">Task Description</label>
				<textarea name="task_description" id="task_description" placeholder="What's the task all about...?" class="form-control" rows="5" cols="5"><?php echo $row['t_description']; ?></textarea>
			</div>

			<div class="h-wrapper">
				<div class="v-wrapper">
					<label for="t_start_time">Start Time</label>
					<input type="text" name="t_start_time" id="t_start_time" class="form-control" value="<?php echo $row['t_start_time']; ?>">
				</div>

				<div class="v-wrapper">
					<label for="t_end_time">End Time</label>
					<input type="text" name="t_end_time" id="t_end_time" class="form-control" value="<?php echo $row['t_end_time']; ?>">
				</div>
			</div>

			<div class="v-wrapper">
				<label for="assign_to">Assign to</label>
				<?php
				$sql = "SELECT user_id, fullname FROM tbl_admin WHERE user_role = 2";
				$info = $obj_admin->manage_all_info($sql);
				?>

				<select class="form-control" name="assign_to" id="aassign_to" <?php if ($user_role != 1) { ?> disabled="true" <?php } ?>>
					<option value="">Please select an intern...</option>

					<?php while ($rows = $info->fetch(PDO::FETCH_ASSOC)) { ?>
						<option value="<?php echo $rows['user_id']; ?>" <?php
																		if ($rows['user_id'] == $row['t_user_id']) {
																		?> selected <?php } ?>><?php echo $rows['fullname']; ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="v-wrapper">
				<label for="status">Status</label>
				<select class="form-control" name="status" id="status">
					<option value="0" <?php if ($row['status'] == 0) { ?>selected <?php } ?>>Pending</option>
					<option value="1" <?php if ($row['status'] == 1) { ?>selected <?php } ?>>In progress</option>
					<option value="2" <?php if ($row['status'] == 2) { ?>selected <?php } ?>>Completed</option>

					<?php if ($user_role != 2) { ?>
						<option value="3" <?php if ($row['status'] == 3) { ?> selected <?php } ?>>Failed to submit</option>
					<?php } ?>

				</select>
			</div>
			
			<div class="v-wrapper">
				<label>Proof Image</label>
				<?php if ($user_role != 1) { ?>
					<?php if (!empty($row['proof'])) { ?>
						<div class="img-container">
							<img src="<?php echo $row['proof']; ?>" alt="">
						</div>
						<div class="file-drop-area" style="height: 150px;">
		
							<div class="no-file-yet">
								<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-up"><path d="M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21"/><path d="m14 19.5 3-3 3 3"/><path d="M17 22v-5.5"/><circle cx="9" cy="9" r="2"/></svg>
								<p><b>Wrong upload?</b> Don't worry.</p>
								<span>You can try again. Make sure it's a JPG or a PNG</span>
							</div>
		
							<div class="has-file">
								<span class="fake-btn">Choose another file</span>
								<span class="file-msg"></span>
							</div>
		
							<input class="file-input" type="file" name="proof">
						</div>
					<?php } else { ?>
						<div class="file-drop-area" style="height: 150px;">
		
							<div class="no-file-yet">
								<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-up"><path d="M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21"/><path d="m14 19.5 3-3 3 3"/><path d="M17 22v-5.5"/><circle cx="9" cy="9" r="2"/></svg>
								<p><b>Click to upload</b> or drag and drop</p>
								<span>JPG, PNG</span>
							</div>
		
							<div class="has-file">
								<span class="fake-btn">Choose another file</span>
								<span class="file-msg"></span>
							</div>
		
							<input class="file-input" type="file" name="proof">
						</div>
					<?php } ?>
			</div>
			<?php } ?>

			<?php
			if (isset($_POST['update_task_info'])) {
				if ($user_role != 1) {
					header('Location: taskreport-user.php');
					exit();
				} elseif ($user_role != 2) {
					header('Location: task-info.php');
					exit();
				} else {
					header('Location: index.php');
					exit();
				}
			}
			?>

			<div class="btnSection">
				<form method="post">
					<button type="submit" name="update_task_info">Update Now</button>
				</form>
				<button onclick="window.history.back();">Back</button>
			</div>

		</div>
	</div>
</form>

<script>
	document.querySelector('form').addEventListener('submit', function(event) {
		var status = document.querySelector('#status').value;
		var proof = document.querySelector('input[name="proof"]').value;

		if (status == '2' && proof == '') {
			event.preventDefault();
			alert('Please upload an image proof for completed status');
		}
	});
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script type="text/javascript">
	let currentDate = new Date();

	flatpickr('#t_start_time', {
		enableTime: true,
		minTime: "9:00",
		maxTime: "18:00",
		time_24hr: false,
		minDate: currentDate // disable past dates
	});

	flatpickr('#t_end_time', {
		enableTime: true,
		minTime: "9:00",
		maxTime: "18:00",
		time_24hr: false,
		minDate: currentDate // disable past dates
	});
</script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.querySelector('.file-input');
        var droparea = document.querySelector('.file-drop-area');
        var fileMsg = document.querySelector('.file-msg');

        var noFile = document.querySelector('.no-file-yet');
        var hasFile = document.querySelector('.has-file');

        fileInput.addEventListener('change', function() {
            var filesCount = this.files.length;

            if (filesCount === 1) {
                var fileName = this.files[0].name;
                fileMsg.textContent = fileName;
                hasFile.style.display = 'flex';
                noFile.style.display = 'none';

                // // Read the uploaded image file and set it as the image source
                // var reader = new FileReader();
                // reader.onload = function(event) {
                //     uploadedImage.src = event.target.result;
                // };
                // reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>

<!-- FOR FILE VALIDATION -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    document.querySelector('.file-input').addEventListener('change', function(e) {
        var file = this.files[0]; 
        var fileType = file["type"];
        var validImageTypes = ["image/jpeg", "image/png"];
        if (!validImageTypes.includes(fileType)) { 
            swal('Invalid file type', 'Please upload a PNG or a JPG image.', 'error');
            this.value = '';
        }
    });
</script>