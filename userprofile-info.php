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
    <title>Edit Profile | TaskPlanner</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>




<body>

    <?php
    $page_name = "User_Profile";
    include("include/sidebar.php");

    $sql = "SELECT * FROM tbl_admin WHERE user_id = $user_id";
    $info = $obj_admin->manage_all_info($sql);

    while ($row = $info->fetch(PDO::FETCH_ASSOC)) {

    ?>
        <div class="page">
            <div class="content">
                <div class="content-title">
                    <h1>User Profile</h1>
                    <p>Update your profile.</p>
                    <span class="status-indicator failedtosub" style="white-space: wrap; text-align: start;"><i class="ri-error-warning-line"></i> Any usage of inappropriate or sensitive content in your profile will result you in suspension.</span>
                </div>
                
                
                <div class="card settings">
                    <div class="card-title">
                        <h4>Profile Picture</h4>
                        <span>This image will be displayed on your profile</span>
                    </div>
                    <form role="form" action="" enctype="multipart/form-data" method="post" autocomplete="off">
                        <div class="card profile-pic">
                            
                            <div class="img-container"><img src="<?php echo $row['profileimg']; ?>" alt="Profile Image"></div>
                            
                            <div class="file-drop-area">

                                <div class="no-file-yet">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-up"><path d="M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21"/><path d="m14 19.5 3-3 3 3"/><path d="M17 22v-5.5"/><circle cx="9" cy="9" r="2"/></svg>
                                    <p><b>Click to upload</b> or drag and drop</p>
                                    <span>JPG, PNG or GIF (Recommended ratio 1:1)</span>
                                </div>

                                <div class="has-file">
                                    <span class="fake-btn">Choose another file</span>
                                    <span class="file-msg"></span>
                                </div>

                                <input class="file-input" type="file" name="profileimg" required>
                            </div>


                            <div>
                                <!-- clever way of actually hiding it without having to display what is needed to be change -->
                                <input type="text" style="display: none;" value="<?php echo $row['fullname']; ?>" placeholder="Enter Employee Name" name="em_fullname" list="expense" required>
                                <input type="text" style="display: none;" value="<?php echo $row['username']; ?>" placeholder="Enter Employee Username" name="em_username" required>
                                <input type="email" style="display: none;" value="<?php echo $row['email']; ?>" placeholder="Enter employee email" name="em_email" required>
                                <select style="display: none;" name="position" class="form-control input-custom" required>
                                    <option value="">Select Position...</option>
                                    <option value="IT Department" <?php if ($row['position'] == 'IT Department') echo 'selected'; ?>>IT Department</option>
                                    <option value="Hr Department" <?php if ($row['position'] == 'Hr Department') echo 'selected'; ?>>Hr Department</option>
                                    <option value="Marketing Department" <?php if ($row['position'] == 'Marketing Department') echo 'selected'; ?>>Marketing Department</option>
                                    <option value="Admin Department" <?php if ($row['position'] == 'Admin Department') echo 'selected'; ?>>Admin Department</option>
                                </select>
                            </div>

                            <div class="btnSection">
                                <button type="submit" name="update_current_employee">Update</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card settings">
                    <div class="card-title">
                        <h4>Personal Information</h4>
                        <span>Update your personal details here.</span>
                    </div>


                    <form role="form" action="" enctype="multipart/form-data" method="post" autocomplete="off">
                        <div class="card personal-info">
                            <div class="v-wrapper">
                                <label>Full name</label>
                                <input type="text" value="<?php echo $row['fullname']; ?>" name="em_fullname" list="expense" class="form-control" id="default" required>
                                <span>Your name will appear on tasks. You can change it at any time, but please refrain from abusing it.</span>
                            </div>

                            <div class="v-wrapper">
                                <label>Username</label>
                                <input type="text" value="<?php echo $row['username']; ?>" placeholder="Enter Employee Username" name="em_username" class="form-control" required>
                                <span>This will be used to login to this account.</span>
                            </div>

                            <div class="v-wrapper">
                                <label>Email</label>
                                <input type="email" value="<?php echo $row['email']; ?>" placeholder="Enter employee email" name="em_email" class="form-control" required>
                            </div>


                            <div class="v-wrapper">
                                <label>Position</label>
                                <select name="position" required>
                                    <option value="">Select Position...</option>
                                    <option value="IT Department" <?php if ($row['position'] == 'IT Department') echo 'selected'; ?>>IT Department</option>
                                    <option value="Hr Department" <?php if ($row['position'] == 'Hr Department') echo 'selected'; ?>>Hr Department</option>
                                    <option value="Marketing Department" <?php if ($row['position'] == 'Marketing Department') echo 'selected'; ?>>Marketing Department</option>
                                    <option value="Admin Department" <?php if ($row['position'] == 'Admin Department') echo 'selected'; ?>>Admin Department</option>
                                </select>
                                <span>Change your department. Only do this with your supervisor's permission.</span>
                            </div>
                            
                            <div class="btnSection">
                                <button type="submit" name="update_current_employee">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card settings">
                    <div class="card-title">
                        <h4>Change password</h4>
                        <span>Enter your current password to update.</span>
                    </div>
                    <form role="form" action="" enctype="multipart/form-data" method="post" autocomplete="off">
                        <div class="card personal-info">
                            <div class="v-wrapper">
                                <label for="current_employee_password">Current password</label>
                                <input type="password" name="current_employee_password" class="form-control input-custom" id="current_employee_password" min="8" required>
                            </div>

                            <div class="v-wrapper">
                                <label for="new_employee_password">New password</label>
                                <input type="password" name="new_employee_password" class="form-control input-custom" id="new_employee_password" min="8" required>
                            </div>

                            <div class="v-wrapper">
                                <label for="confirm_employee_password">Confirm password</label>
                                <input type="password" name="confirm_employee_password" class="form-control input-custom" id="confirm_employee_password" min="8" required>
                            </div>

                            <div class="btnSection">
                                <button type="submit" name="btn_user_password">Confirm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>

</body>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.querySelector('.file-input');
        var droparea = document.querySelector('.file-drop-area');
        var fileMsg = document.querySelector('.file-msg');
        var imgContainer = document.querySelector('.card.settings .card.profile-pic .img-container');
        var uploadedImage = imgContainer.querySelector('img');

        var noFile = document.querySelector('.no-file-yet');
        var hasFile = document.querySelector('.has-file');

        fileInput.addEventListener('change', function() {
            var filesCount = this.files.length;

            if (filesCount === 1) {
                var fileName = this.files[0].name;
                fileMsg.textContent = fileName;
                hasFile.style.display = 'flex';
                noFile.style.display = 'none';

                // Read the uploaded image file and set it as the image source
                var reader = new FileReader();
                reader.onload = function(event) {
                    uploadedImage.src = event.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<!-- FOR FILE VALIDATION -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    document.querySelector('.file-input').addEventListener('change', function(e) {
        var file = this.files[0]; 
        var fileType = file["type"];
        var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
        if (!validImageTypes.includes(fileType)) { 
            swal('Invalid file type', 'Please upload a PNG, JPG, or GIF image.', 'error');
            this.value = '';
        }
    });
</script>