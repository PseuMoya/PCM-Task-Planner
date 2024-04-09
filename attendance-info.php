<?php
require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
$user_role = $_SESSION['user_role'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index');
}

// check admin 
$user_role = $_SESSION['user_role'];
if ($user_role != 1) {
    header('Location: home');
}

// Handle position filter
$selected_position = isset($_GET['position']) ? $_GET['position'] : '';
$positions = ['IT department', 'Admin', 'Marketing', 'HR'];

if (isset($_GET['delete_attendance'])) {
    $action_id = $_GET['aten_id'];
    $sql = "DELETE FROM attendance_info WHERE aten_id = :id";
    $sent_po = "attendance-info";
    $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
}

if (isset($_POST['add_punch_in'])) {
    $info = $obj_admin->add_punch_in($_POST);
}

if (isset($_POST['add_punch_out'])) {
    $obj_admin->add_punch_out($_POST);
}

$page_name = "Attendance";
include("include/lib_links.php");
?>

<head>
    <title>Attendance | TaskPlanner</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div class="page">
        <?php
        include("include/sidebar.php");
        ?>

        <div class="content">
            <h1>Intern Lists</h1>

            <div class="btnSection">
                <!-- Position filter dropdown -->
                <form method="get" role="form" action="">
                    <select name="position" class="form-control">
                        <option value="">All Positions</option>
                        <?php foreach ($positions as $position) : ?>
                            <option value="<?php echo $position; ?>" <?php echo ($selected_position == $position) ? 'selected' : ''; ?>><?php echo $position; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary"><i class="ri-filter-2-line"></i>Filter</button>
                </form>
            </div>

            <div class="card">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Tasks</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Prepare SQL query based on selected position
                            $sql = "SELECT * FROM tbl_admin WHERE position IS NOT NULL AND position <> ''";
                            if (!empty($selected_position)) {
                                $sql .= " AND position = '$selected_position'";
                            }
                            $sql .= " ORDER BY user_id DESC";

                            $info = $obj_admin->manage_all_info($sql);
                            $serial = 1;
                            $num_row = $info->rowCount();
                            if ($num_row == 0) {
                                echo '<tr><td colspan="7">No Data found</td></tr>';
                            }
                            while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
                                $user_id = $row['user_id'];
                                $sql = "SELECT * FROM task_info WHERE t_user_id = $user_id";
                                $task_info = $obj_admin->manage_all_info($sql);
                                $task_num = $task_info->rowCount();
                            ?>
                                <tr>
                                    <td><?php echo $serial++; ?></td>
                                    <td><img src="<?php echo $row['profileimg']; ?>" alt="Profile Image" width="40px" height="40px"></td>                                    
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['position']; ?></td>
                                    <td><?php echo $task_num; ?></td>
                                    <td>
                                        <?php
                                        if ($task_num == 0) {
                                            echo "<div class='status-indicator incomplete'>No tasks currently</div>";
                                        } else {
                                            echo "<div class='status-indicator completed'>Task assigned</div>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
include("include/footer.php");
?>