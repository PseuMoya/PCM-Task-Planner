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
    <title>Edit Profile</title>
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
            <div class="dash-cards-profile">
                <form role="form" action="" enctype="multipart/form-data" method="post" autocomplete="off">
                    <div class="modal">
                        <div class="modalTitle">
                            <h2>Profile Picture</h2>
                        </div>
                        <?php

                        $sql = "SELECT * FROM tbl_admin WHERE user_id = $user_id";
                        $info = $obj_admin->manage_all_info($sql);

                        while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <div class="img-container"><img src="<?php echo $row['profileimg']; ?>" alt="Profile Image"></div>

                            <!-- clever way of actually hiding it without having to display what is needed to be change -->
                            <input type="text" style="display: none;" value="<?php echo $row['fullname']; ?>" placeholder="Enter Employee Name" name="em_fullname" list="expense" required>
                            <input type="text" style="display: none;" value="<?php echo $row['username']; ?>" placeholder="Enter Employee Username" name="em_username" required>
                            <input type="email" style="display: none;" value="<?php echo $row['email']; ?>" placeholder="Enter employee email" name="em_email" required>
                            <div class="col-sm-8" style="display: none;">
                                <select name="position" class="form-control input-custom" required>
                                    <option value="">Select Position...</option>
                                    <option value="IT Department" <?php if ($row['position'] == 'IT Department') echo 'selected'; ?>>IT Department</option>
                                    <option value="Hr Department" <?php if ($row['position'] == 'Hr Department') echo 'selected'; ?>>Hr Department</option>
                                    <option value="Marketing Department" <?php if ($row['position'] == 'Marketing Department') echo 'selected'; ?>>Marketing Department</option>
                                    <option value="Admin Department" <?php if ($row['position'] == 'Admin Department') echo 'selected'; ?>>Admin Department</option>
                                </select>
                            </div>

                            <input type="file" name="profileimg">

                            <div class="btnSection">
                                <button type="submit" name="update_current_employee">Update</button>
                            </div>
                    </div>
                </form>

                <form role="form" action="" enctype="multipart/form-data" method="post" autocomplete="off">
                    <div class="modal">
                        <div class="modalTitle">
                            <h2>Personal Information</h2>
                        </div>

                        <div class="v-wrapper">
                            <label>Full name</label>
                            <input type="text" value="<?php echo $row['fullname']; ?>" placeholder="Enter Employee Name" name="em_fullname" list="expense" class="form-control" id="default" required>
                        </div>

                        <div class="v-wrapper">
                            <label>Username</label>
                            <input type="text" value="<?php echo $row['username']; ?>" placeholder="Enter Employee Username" name="em_username" class="form-control" required>
                        </div>

                        <div class="v-wrapper">
                            <label>Email</label>
                            <input type="email" value="<?php echo $row['email']; ?>" placeholder="Enter employee email" name="em_email" class="form-control" required>
                        </div>


                        <div class="v-wrapper">
                            <label>Position</label>
                            <select name="position" class="form-control input-custom" required>
                                <option value="">Select Position...</option>
                                <option value="IT Department" <?php if ($row['position'] == 'IT Department') echo 'selected'; ?>>IT Department</option>
                                <option value="Hr Department" <?php if ($row['position'] == 'Hr Department') echo 'selected'; ?>>Hr Department</option>
                                <option value="Marketing Department" <?php if ($row['position'] == 'Marketing Department') echo 'selected'; ?>>Marketing Department</option>
                                <option value="Admin Department" <?php if ($row['position'] == 'Admin Department') echo 'selected'; ?>>Admin Department</option>
                            </select>
                        </div>
                    <?php } ?>

                    <div class="btnSection">
                        <button type="submit" name="update_current_employee" class="btn btn-success-custom">Save changes</button>
                    </div>
                    </div>
                </form>

                <form role="form" action="" enctype="multipart/form-data" method="post" autocomplete="off">
                    <div class="modal">
                        <div class="modalTitle">
                            <h2>Change password</h2>
                        </div>

                        <div class="v-wrapper">
                            <label for="current_employee_password">Current Password:</label>
                            <input type="password" name="current_employee_password" class="form-control input-custom" id="current_employee_password" min="8" required>
                        </div>

                        <div class="v-wrapper">
                            <label for="new_employee_password">New Password:</label>
                            <input type="password" name="new_employee_password" class="form-control input-custom" id="new_employee_password" min="8" required>
                        </div>

                        <div class="v-wrapper">
                            <label for="confirm_employee_password">Confirm Password:</label>
                            <input type="password" name="confirm_employee_password" class="form-control input-custom" id="confirm_employee_password" min="8" required>
                        </div>

                        <div class="btnSection">
                            <button type="submit" name="btn_user_password">Confirm</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
