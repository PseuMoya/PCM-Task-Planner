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
                        $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 AND position = 'Hr Department'";
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
                        $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 AND position = 'Marketing Department'";
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
                        $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 AND position = 'Admin Department'";
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

                                $num_row = $info->rowCount();
                                if ($num_row == 0) {
                                    echo '<tr>
                                    <div class="data-not-found">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-database-zap"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 15 21.84"/><path d="M21 5V8"/><path d="M21 12L18 17H22L19 22"/><path d="M3 12A9 3 0 0 0 14.59 14.87"/></svg>
                                        <span>No data found</span>
                                    </div>
                                  </tr>
                                
                                <style>thead{display:none;}</style>';
                                }
                                
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

                                    $num_row = $info->rowCount();
                                    if ($num_row == 0) {
                                        echo '<tr>
                                            <div class="data-not-found">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-database-zap"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 15 21.84"/><path d="M21 5V8"/><path d="M21 12L18 17H22L19 22"/><path d="M3 12A9 3 0 0 0 14.59 14.87"/></svg>
                                                <span>No data found</span>
                                            </div>
                                        </tr>
                                    
                                    <style>thead{display:none;}</style>';
                                    }
                                
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

                                    $num_row = $info->rowCount();
                                    if ($num_row == 0) {
                                        echo '<tr>
                                            <div class="data-not-found">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-database-zap"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 15 21.84"/><path d="M21 5V8"/><path d="M21 12L18 17H22L19 22"/><path d="M3 12A9 3 0 0 0 14.59 14.87"/></svg>
                                                <span>No data found</span>
                                            </div>
                                        </tr>
                                    
                                    <style>thead{display:none;}</style>';
                                    }

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