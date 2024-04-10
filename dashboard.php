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

$page_name = "Dashboard";
include("include/lib_links.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard | TaskPlanner</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div class="page">
        <?php
        include("include/sidebar.php");
        ?>

        <div class="content">
            <h1>Dashboard</h1>

            <div class="dash-cards">
                <div class="card">
                    <p>IT Department</p>
                    <span class="how-many">
                        <?php
                        $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 AND position = 'IT Department'";
                        $info = $obj_admin->manage_all_info($sql);
                        $count = $info->rowCount();
                        echo $count;
                        ?>
                    </span>
                    <i class="ri-macbook-line"></i>
                </div>

                <div class="card">
                    <p>HR Department</p>
                    <span class="how-many">
                        <?php
                        $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 AND position = 'Hr'";
                        $info = $obj_admin->manage_all_info($sql);
                        $count = $info->rowCount();
                        echo $count;
                        ?>
                    </span>
                    <i class="ri-group-2-line"></i>
                </div>

                <div class="card">
                    <p>Marketing Department</p>
                    <span class="how-many">
                        <?php
                        $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 AND position = 'Marketing'";
                        $info = $obj_admin->manage_all_info($sql);
                        $count = $info->rowCount();
                        echo $count;
                        ?>
                    </span>
                    <i class="ri-store-2-line"></i>
                </div>

                <div class="card">
                    <p>Admin Department</p>
                    <span class="how-many">
                        <?php
                        $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 AND position = 'Admin'";
                        $info = $obj_admin->manage_all_info($sql);
                        $count = $info->rowCount();
                        echo $count;
                        ?>
                    </span>
                    <i class="ri-user-settings-line"></i>
                </div>
            </div>

            <div class="card">
                <h3>Task Report: <span>Ongoing</span></h3>
                <div class="table-container">
                    <table>
                        <thead>
                        <tr>
                            <th>Serial No.</th>
                            <th>Interns</th>
                            <th>Task</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT task_info.*, tbl_admin.user_id, tbl_admin.fullname
                                FROM task_info
                                JOIN tbl_admin ON task_info.t_user_id = tbl_admin.user_id
                                WHERE task_info.status = 1;
                                ";
                                $info = $obj_admin->manage_all_info($sql);

                                $serial  = 1;
                                while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?php echo $serial;
                                        $serial++; ?></td>
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['t_title']; ?></td>
                                </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <h3>Task Report: <span>Pending</span></h3>
                <div class="table-container">
                    <table>
                        <thead>
                        <tr>
                            <th>Serial No.</th>
                            <th>Interns</th>
                            <th>Task</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT task_info.*, tbl_admin.user_id, tbl_admin.fullname
                                FROM task_info
                                JOIN tbl_admin ON task_info.t_user_id = tbl_admin.user_id
                                WHERE task_info.status = 0;
                                ";
                                    $info = $obj_admin->manage_all_info($sql);

                                    $serial  = 1;
                                    while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $serial;
                                            $serial++; ?></td>
                                        <td><?php echo $row['fullname']; ?></td>
                                        <td><?php echo $row['t_title']; ?></td>
                                    </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <h3>Task Report: <span>Completed</span></h3>
                <div class="table-container">
                    <table>
                        <thead>
                        <tr>
                            <th>Serial No.</th>
                            <th>Interns</th>
                            <th>Task</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT task_info.*, tbl_admin.user_id, tbl_admin.fullname 
                                FROM task_info 
                                JOIN tbl_admin ON task_info.t_user_id = tbl_admin.user_id 
                                WHERE task_info.status = 2; 
                                ";
                                    $info = $obj_admin->manage_all_info($sql);

                                    $serial  = 1;
                                    while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $serial;
                                            $serial++; ?></td>
                                        <td><?php echo $row['fullname']; ?></td>
                                        <td><?php echo $row['t_title']; ?></td>
                                    </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</body>

</html>