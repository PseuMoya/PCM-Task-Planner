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


if (isset($_GET['delete_user'])) {
    $action_id = $_GET['admin_id'];

    $task_sql = "DELETE FROM task_info WHERE t_user_id = $action_id";
    $delete_task = $obj_admin->db->prepare($task_sql);
    $delete_task->execute();

    $attendance_sql = "DELETE FROM attendance_info WHERE atn_user_id = $action_id";
    $delete_attendance = $obj_admin->db->prepare($attendance_sql);
    $delete_attendance->execute();

    $sql = "DELETE FROM tbl_admin WHERE user_id = :id";
    $sent_po = "admin-manage-user";
    $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
}


$page_name = "Admin";
include("include/lib_links.php");

if (isset($_POST['add_new_employee'])) {
    $error = $obj_admin->add_new_user($_POST);
}



?>

<head>
    <title>Admin Management | TaskPlanner</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<!--modal for employee add-->
<!-- Modal -->

<body>
    <form role="form" action="" enctype="multipart/form-data" method="post" autocomplete="off">
        <div id="modalBG">
            <div class="modal">
                <?php if (isset($error)) { ?>
                    <h5 class="alert alert-danger"><?php echo $error; ?></h5>
                <?php } ?>
                <div class="modalTitle">
                    <h2>Add an Intern</h2>
                </div>

                <div class="v-wrapper">
                    <label for="em_fullname">Full name</label>
                    <input type="text" placeholder="e.g. Firstname M.I. Lastname" name="em_fullname" list="expense" class="form-control" id="default" required>
                </div>

                <div class="v-wrapper">
                    <label for="em_username">Username</label>
                    <input type="text" placeholder="Enter employee username" name="em_username" class="form-control" required>
                </div>

                <div class="v-wrapper">
                    <label for="em_email">Email</label>
                    <input type="email" placeholder="Enter employee email" name="em_email" class="form-control" required>
                </div>

                <div class="v-wrapper">
                    <label for="position">Position</label>
                    <select name="position" required>
                        <option value="">Select Position...</option>
                        <option value="IT Department">IT Department</option>
                        <option value="Hr Department">Hr Department</option>
                        <option value="Marketing Department">Marketing Department</option>
                        <option value="Admin Department">Admin Department</option>
                    </select>
                </div>

                <div class="v-wrapper">
                    <label for="profileimg">Profile Image</label>
                    <input type="file" name="profileimg" class="form-control">
                </div>

                <div class="btnSection">
                    <button type="submit" name="add_new_employee">Add Employee</button>
                    <button id="exitModal">Cancel</button>
                </div>
            </div>
        </div>
    </form>

    <div class="page">
        <?php
        $page_name = "Admin";
        include("include/sidebar.php");
        // include('ems_header.php');
        ?>

        <div class="content">
            <h1>Administration</h1>
                
            <!-- <div class="btnSection">
                <?php if ($user_role == 1) { ?>
                    <div class="btn-group">
                        <button id="openModal"><i class="ri-user-add-line"></i>Add New Employee</button>
                    </div>
                <?php } ?>
            </div> -->
            
            <?php
            // Fetch distinct positions from the database, excluding the Super Admin position
            $positions_sql = "SELECT DISTINCT position FROM tbl_admin WHERE position != 'Super Admin'";
            $positions_result = $obj_admin->db->prepare($positions_sql);
            $positions_result->execute();
            $positions = $positions_result->fetchAll(PDO::FETCH_COLUMN);

            // Get the selected position from the $_GET array
            $selected_position = isset($_GET['position']) ? $_GET['position'] : '';

            ?>

            <!-- Position filter dropdown -->
            <div class="btnSection">
                <form method="get" role="form" action="">
                    <select name="position" class="form-control">
                        <option value="">All Positions</option>
                        <?php foreach ($positions as $position) : ?>
                            <option value="<?php echo $position; ?>" <?php echo ($selected_position == $position) ? 'selected' : ''; ?>><?php echo $position; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary"><i class="ri-filter-2-line"></i>Filter</button>
                </form>

                <?php if ($user_role == 1) { ?>
                    <button id="openModal"><i class="ri-user-add-line"></i>Add New Employee</button>
                <?php } ?>
            </div>

            


            <div class="card with-table">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Serial No.</th>
                                <th>Profile Image</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Department</th>
                                <th>Temp Password</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Fetch the records from the tbl_admin table that match the selected position
                            $sql = "SELECT * FROM tbl_admin WHERE user_role = 2";
                            if ($selected_position != '') {
                                $sql .= " AND position = :position";
                            }
                            $sql .= " ORDER BY user_id DESC";
                            $info = $obj_admin->db->prepare($sql);
                            if ($selected_position != '') {
                                $info->bindParam(':position', $selected_position);
                            }
                            $info->execute();
                            
                            // Display these records in the HTML table
                            $serial  = 1;
                            $num_row = $info->rowCount();
                            if ($num_row == 0) {
                                echo '<tr>
                                        <div class="data-not-found">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-x"><path d="M2 21a8 8 0 0 1 11.873-7"/><circle cx="10" cy="8" r="5"/><path d="m17 17 5 5"/><path d="m22 17-5 5"/></svg>
                                        <span>No interns found</span>
                                            <p>Start by adding one.</p>
                                        </div>
                                      </tr>
                            
                                        <style>table{display:none;}</style>';
                            }
                            while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td><?php echo $serial; $serial++; ?></td>
                                    <td><img src="<?php echo $row['profileimg']; ?>" alt="Profile Image"></td>                                    
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['position']; ?></td>
                                    <td><div class="temp-pass"><?php echo $row['temp_password']; ?></div></td>
                            
                                    <td>
                                        <div class="actions">
                                            <a title="Update Employee" href="update-employee?admin_id=<?php echo $row['user_id']; ?>"><i class="ri-folder-open-fill"></i></a>
                                            <a title="Delete" href="?delete_user=delete_user&admin_id=<?php echo $row['user_id']; ?>" onclick=" return check_delete();"><i class="ri-delete-bin-6-fill"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</body>

<?php
if (isset($_SESSION['update_user_pass'])) {

    // echo '<script>alert("Password updated successfully");</script>';
    // echo '<script>alert("index");</script>';

    unset($_SESSION['update_user_pass']);
}
include("include/footer.php");

?>