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
if ($user_role != 1) {
    header('Location: task-info');
}

$admin_id = $_GET['admin_id'];

if (isset($_POST['update_current_employee'])) {

    $obj_admin->update_user_data($_POST, $admin_id);
}

if (isset($_POST['btn_user_password'])) {

    $obj_admin->update_userbyadmin_password($_POST, $admin_id);
}



$sql = "SELECT * FROM tbl_admin WHERE user_id='$admin_id' ";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

$page_name = "Admin";
include("include/lib_links.php");

?>

<head>
    <title>Update Employee</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<div id="modalBG" style="visibility: visible; opacity: 1; transition: none; gap: 1em;">
    <form role="form" action="" enctype="multipart/form-data" method="post" autocomplete="off">
        <div class="modal" style="visibility: visible; opacity: 1; transform: scale(1.0); transition: none">
            <div class="modalTitle">
                <h2>Edit Intern</h2>
            </div>

            <div class="v-wrapper">
                <label class="control-label col-sm-2">Fullname</label>
                <input type="text" value="<?php echo $row['fullname']; ?>" placeholder="Enter Employee Name" name="em_fullname" list="expense" class="form-control" id="default" required>
            </div>

            <div class="v-wrapper">
                <label for="em_school">School</label>
                <input type="text" value="<?php echo $row['school']; ?>" placeholder="Enter school name" name="em_school" class="form-control" required>
            </div>


            <div class="v-wrapper">
                <label class="control-label col-sm-2">Username</label>
                <input type="text" value="<?php echo $row['username']; ?>" placeholder="Enter Employee Username" name="em_username" class="form-control" required>
            </div>

            <div class="v-wrapper">
                <label class="control-label col-sm-2">Email</label>
                <input type="email" value="<?php echo $row['email']; ?>" placeholder="Enter employee email" name="em_email" class="form-control" required>
            </div>

            <div class="v-wrapper">
                <label class="control-label col-sm-2">Profile Image</label>
                <div class="file-drop-area" style="height: 150px;">

                    <div class="no-file-yet">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-up">
                            <path d="M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21" />
                            <path d="m14 19.5 3-3 3 3" />
                            <path d="M17 22v-5.5" />
                            <circle cx="9" cy="9" r="2" />
                        </svg>
                        <p><b>Click to upload</b> or drag and drop</p>
                        <span>JPG, PNG</span>
                    </div>

                    <div class="has-file">
                        <span class="fake-btn">Choose another file</span>
                        <span class="file-msg"></span>
                    </div>

                    <input class="file-input" type="file" name="profileimg">
                </div>
            </div>


            <div class="v-wrapper">
                <label>Position</label>
                <div class="col-sm-8">
                    <select name="position" class="form-control input-custom" required>
                        <option value="">Select Position...</option>
                        <option value="IT Department" <?php if ($row['position'] == 'IT Department') echo 'selected'; ?>>IT Department</option>
                        <option value="Hr Department" <?php if ($row['position'] == 'Hr Department') echo 'selected'; ?>>Hr Department</option>
                        <option value="Marketing Department" <?php if ($row['position'] == 'Marketing Department') echo 'selected'; ?>>Marketing Department</option>
                        <option value="Admin Department" <?php if ($row['position'] == 'Admin Department') echo 'selected'; ?>>Admin Department</option>
                    </select>
                </div>
            </div>

            
            <?php
                function redirect_based_on_role()
                {
                    header('Location: admin-manage-user');
                    exit();
                }

                if (isset($_POST['update_current_employee']) || isset($_POST['back'])) {
                    redirect_based_on_role();
                }
            ?>

            <div class="btnSection">
                <button type="submit" name="update_current_employee" class="btn btn-success-custom">Update Now</button>
                <button name="back" onclick="window.history.back();">Back</button>
            </div>
        </div>
    </form>

    <form action="" method="POST" id="employee_pass_cng">
        <div class="modal" style="visibility: visible; opacity: 1; transform: scale(1.0); transition: none">
            <div class="modalTitle">
                <h2>Password</h2>
            </div>

            <?php
                function password_direct()
                {
                    header('Location: admin-manage-user');
                    exit();
                }

                if (isset($_POST['employee_password']) || isset($_POST['back'])) {
                    password_direct();
                }
            ?>

            <div class="v-wrapper">
                <label for="admin_password">New Password</label>
                <input type="password" name="employee_password" id="employee_password" min="8" required>
            </div>

            <div class="btnSection">
                <button type="submit" name="btn_user_password">Confirm</button>
            </div>
        </div>
    </form>

</div>


<?php

include("include/footer.php");

?>

<script type="text/javascript">
    $('#emlpoyee_pass_btn').click(function() {
        $('#employee_pass_cng').toggle('slow');
    });
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    document.querySelector('.file-input').addEventListener('change', function(e) {
        var file = this.files[0];
        var fileType = file["type"];
        var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
        if (!validImageTypes.includes(fileType)) {
            swal('Invalid file type', 'Please upload a PNG or JPG image.', 'error');
            this.value = '';
        }
    });
</script>