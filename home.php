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


if (isset($_GET['delete_task'])) {
  $action_id = $_GET['task_id'];

  $sql = "DELETE FROM task_info WHERE task_id = :id";
  $sent_po = "task-info.php";
  $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
}

if (isset($_POST['add_task_post'])) {
  $obj_admin->add_new_task($_POST);
}

$page_name = "Home";
include("include/lib_links.php");




?>


<div class="page">
        <?php
            $page_name = "Home";
            include("include/sidebar.php");
        ?>


<div class="content">
            <h1>Home</h1>

            <div class="card">
                <h3>Task Report: <span>Pending</span></h3>
                <div class="table-container">
                    <table>
                        <thead>
                        <tr>
                            <th>Profile Image</th>
                            <th>Name: </th>
                            <th>Incomplete Task: </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            if ($user_role == 1) {
                                $sql = "SELECT b.fullname, b.profileimg, COUNT(a.task_id) as pending_tasks
                                        FROM task_info a
                                        INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                                        WHERE a.status = 0
                                        GROUP BY b.fullname, b.profileimg
                                        ORDER BY b.fullname ASC";
                            } else {
                                $sql = "SELECT b.fullname, b.profileimg, COUNT(a.task_id) as pending_tasks
                                        FROM task_info a
                                        INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                                        WHERE a.t_user_id = $user_id AND a.status = 0
                                        GROUP BY b.fullname, b.profileimg
                                        ORDER BY b.fullname ASC";
                            }
                            
                            $info = $obj_admin->manage_all_info($sql);
                            $num_row = $info->rowCount();
                            if ($num_row == 0) {
                                echo '<tr><td colspan="7">No Data found</td></tr>';
                            }
                            
                            // Modify the PHP code that generates the table to display only one name and the count of pending tasks
                            while ($row = $info->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><img src="<?php echo $row['profileimg']; ?>" alt="Profile Image" width="40px" height="40px"></td>                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['pending_tasks']; ?></td>
                                </tr>
                            <?php } ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- <div class="card">
                <h3>Task Report: <span>Completed</span></h3>
                <div class="table-container">
                    <table>
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
            </div> -->
        </div>


</div>