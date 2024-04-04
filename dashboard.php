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
if ($user_role != 1) {
    header('Location: task-info.php');
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
    $sent_po = "admin-manage-user.php";
    $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
}

$page_name = "Dashboard";
include("include/sidebar.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        .dashboard {
            display: flex;
            align-items: center;
            padding: 0px 20px;
        }

        .interns-container {
            display: flex;
            flex-wrap: wrap;
        }

        .intern-box {
            padding: 10px 20px;
            background-color: white;
            border-radius: 10px;
            margin: 10px;
        }
    </style>
</head>

<body>

    <div class="dashboard">

        <div class="interns-count">

            <div class="interns-container">

                <div class="intern-box">
                    <h1>IT Department</h1>
                    <p>
                        <?php
                        $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 AND position = 'IT Department'";
                        $info = $obj_admin->manage_all_info($sql);
                        $count = $info->rowCount();
                        echo $count;
                        ?>
                    </p>
                </div>

                <div class="intern-box">
                    <h1>Hr Department</h1>
                    <p>
                        <?php
                        $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 AND position = 'Hr'";
                        $info = $obj_admin->manage_all_info($sql);
                        $count = $info->rowCount();
                        echo $count;
                        ?>
                    </p>
                </div>

                <div class="intern-box">
                    <h1>Marketing Department</h1>
                    <p>
                        <?php
                        $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 AND position = 'Marketing'";
                        $info = $obj_admin->manage_all_info($sql);
                        $count = $info->rowCount();
                        echo $count;
                        ?>
                    </p>
                </div>

                <div class="intern-box">
                    <h1>Admin Department</h1>
                    <p>
                        <?php
                        $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 AND position = 'Admin'";
                        $info = $obj_admin->manage_all_info($sql);
                        $count = $info->rowCount();
                        echo $count;
                        ?>
                    </p>
                </div>

            </div>

        </div>

    </div>

    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="well well-custom">
                    <div class="gap"></div>
                    <div class="table-responsive">
                        <table class="table table-codensed table-custom">
                            <h4>Task Report: <span>Ongoing</span></h4>
                            <thead>
                                <tr>
                                    <th>Serial No.</th>
                                    <th>Interns</th>
                                    <th>task</th>
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

                    <div class="gap"></div>
                    <div class="table-responsive">
                        <table class="table table-codensed table-custom">
                            <h4>Task Report: <span>Pending</span></h4>
                            <thead>
                                <tr>
                                    <th>Serial No.</th>
                                    <th>Interns</th>
                                    <th>task</th>
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

                    <div class="gap"></div>
                    <div class="table-responsive">
                        <table class="table table-codensed table-custom">
                            <h4>Task Report: <span>Completed</span></h4>
                            <thead>
                                <tr>
                                    <th>Serial No.</th>
                                    <th>Interns</th>
                                    <th>task</th>
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

    </div>


</body>

</html>