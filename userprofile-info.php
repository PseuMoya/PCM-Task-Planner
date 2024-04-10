<?php

require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['btn_user_password'])) {
    $obj_admin->update_user_password($_POST, $user_id);
}


if (isset($_POST['update_current_employee'])) {

    $obj_admin->update_user_data($_POST, $user_id);
}



$page_name = "User_Profile";
include("include/lib_links.php");


?>


<head>
    <title>Profile | Profile Picture</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>




<body>



<?php
    $page_name = "User_Profile";
    include("include/sidebar.php");
    ?>
    <div class="page">


        <div class="content">
            <h1>Profile</h1>

            <div class="modal">
                <h2>Profile Picture</h2>
                <?php

                $sql = "SELECT * FROM tbl_admin WHERE user_id = $user_id";
                $info = $obj_admin->manage_all_info($sql);

                while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
                ?>

                    <div class="profile-name"><img src="<?php echo $row['profileimg']; ?>" alt="Profile Image"><br><?php echo $row['fullname']; ?></div>

                    <form role="form" action="" enctype="multipart/form-data" method="post" autocomplete="off">

                        <input type="text" style="display: none;" value="<?php echo $row['fullname']; ?>" placeholder="Enter Employee Name" name="em_fullname" list="expense" id="default" required>

                        <input type="text" style="display: none;" value="<?php echo $row['username']; ?>" placeholder="Enter Employee Username" name="em_username" required>

                        <input type="email" style="display: none;" value="<?php echo $row['email']; ?>" placeholder="Enter employee email" name="em_email" required>

                        <div class="v-wrapper">
                            <label class="control-label col-sm-2">Profile Image</label>
                            <input type="file" name="profileimg" class="form-control">
                        </div>


                        <div class="col-sm-8" style="display: none;">
                            <select name="position" class="form-control input-custom" required>
                                <option value="">Select Position...</option>
                                <option value="IT Department" <?php if ($row['position'] == 'IT Department') echo 'selected'; ?>>IT Department</option>
                                <option value="Hr" <?php if ($row['position'] == 'Hr') echo 'selected'; ?>>Hr</option>
                                <option value="Marketing" <?php if ($row['position'] == 'Marketing') echo 'selected'; ?>>Marketing</option>
                                <option value="Admin" <?php if ($row['position'] == 'Admin') echo 'selected'; ?>>Admin</option>
                            </select>
                        </div>

                        <div class="btnSection">
                            <button type="submit" name="update_current_employee" class="btn btn-success-custom">Update Now</button>
                        </div>
                    </form>
            </div>
            <div>
            </div>


            <form role="form" action="" enctype="multipart/form-data" method="post" autocomplete="off">
                <div class="modal">
                    <div class="modalTitle">
                        <h2>Edit Intern</h2>
                    </div>

                    <div class="v-wrapper">
                        <label class="control-label col-sm-2">Fullname</label>
                        <input type="text" value="<?php echo $row['fullname']; ?>" placeholder="Enter Employee Name" name="em_fullname" list="expense" class="form-control" id="default" required>
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
                        <label>Position</label>
                        <div class="col-sm-8">
                            <select name="position" class="form-control input-custom" required>
                                <option value="">Select Position...</option>
                                <option value="IT Department" <?php if ($row['position'] == 'IT Department') echo 'selected'; ?>>IT Department</option>
                                <option value="Hr" <?php if ($row['position'] == 'Hr') echo 'selected'; ?>>Hr</option>
                                <option value="Marketing" <?php if ($row['position'] == 'Marketing') echo 'selected'; ?>>Marketing</option>
                                <option value="Admin" <?php if ($row['position'] == 'Admin') echo 'selected'; ?>>Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="btnSection">
                        <button type="submit" name="update_current_employee" class="btn btn-success-custom">Update Now</button>
                    </div>
            </form>

        <?php } ?>

        </div>
        <div class="col-md-5" style="font-family: Arial, sans-serif;">
            <div class="modal">
                <!-- <button id="emlpoyee_pass_btn" class="btn btn-primary" style="background-color: #4CAF50; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 4px;">Change Password</button> -->
                <form action="" method="POST" id="employee_pass_cng">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="admin_password" style="font-size: 18px; color: #333;">Current Password:</label>
                        <input type="password" name="current_employee_password" class="form-control input-custom" id="current_employee_password" min="8" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; margin-top: 6px; margin-bottom: 16px; resize: vertical;">
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="admin_password" style="font-size: 18px; color: #333;">New Password:</label>
                        <input type="password" name="new_employee_password" class="form-control input-custom" id="new_employee_password" min="8" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; margin-top: 6px; margin-bottom: 16px; resize: vertical;">
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="admin_password" style="font-size: 18px; color: #333;">Confirm Password:</label>
                        <input type="password" name="confirm_employee_password" class="form-control input-custom" id="confirm_employee_password" min="8" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; margin-top: 6px; margin-bottom: 16px; resize: vertical;">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="btn_user_password" class="btn btn-success" style="background-color: #4CAF50; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 4px;">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
