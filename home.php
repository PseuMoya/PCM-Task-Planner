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



if (isset($_GET['delete_task'])) {
    $action_id = $_GET['task_id'];

    $sql = "DELETE FROM task_info WHERE task_id = :id";
    $sent_po = "task-info";
    $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
}

if (isset($_POST['add_task_post'])) {
    $obj_admin->add_new_task($_POST);
}

$page_name = "Home";
include("include/lib_links.php");

?>

<head>
    <title>Home - TaskPlanner</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    
    <div class="page">
        <?php
        $page_name = "Home";
        include("include/sidebar.php");
        ?>

        <div class="content">
            <h1>Home</h1>

            <div class="card welcome">
                <?php
                if ($user_role == 1) {
                    $sql = "SELECT b.fullname, b.profileimg, COUNT(a.task_id) as pending_tasks
                            FROM tbl_admin b
                            LEFT JOIN task_info a ON(a.t_user_id = b.user_id AND a.status = 0)
                            GROUP BY b.fullname, b.profileimg
                            ORDER BY b.fullname ASC";
                } else {
                    $sql = "SELECT b.fullname, b.profileimg, COUNT(a.task_id) as pending_tasks
                            FROM tbl_admin b
                            LEFT JOIN task_info a ON(a.t_user_id = b.user_id AND a.status = 0)
                            WHERE b.user_id = $user_id
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
                    <div class="v-wrapper">
                        <h1>Welcome, <span><?php echo $row['fullname']; ?></span>!</h1>
                        <p>You have <?php echo $row['pending_tasks']; ?> pending task(s)</p>
                    </div>
                    <div class="img-container"><img src="<?php echo $row['profileimg']; ?>" alt="Profile Image"></div>
                <?php } ?>
            </div>

            <div class="dash-cards">
                <div class="card">
                    <p>Pending Tasks</p>
                    <i class="ri-list-check-3"></i>
                    <span class="how-many">
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
                            echo '0';
                        }

                        while ($row = $info->fetch(PDO::FETCH_ASSOC)) { ?>

                            <?php echo $row['pending_tasks']; ?>
                            <a href="taskreport-user"><button>Go Now</button></a>
                        <?php } ?>
                    </span>
                </div>

                <div class="card">
                    <p>Completed Tasks</p>
                    <i class="ri-checkbox-circle-line"></i>
                    <span class="how-many">
                        <?php
                        if ($user_role == 1) {
                            $sql = "SELECT b.fullname, b.profileimg, COUNT(a.task_id) as pending_tasks
                                            FROM task_info a
                                            INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                                            WHERE a.status = 2
                                            GROUP BY b.fullname, b.profileimg
                                            ORDER BY b.fullname ASC";
                        } else {
                            $sql = "SELECT b.fullname, b.profileimg, COUNT(a.task_id) as pending_tasks
                                            FROM task_info a
                                            INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                                            WHERE a.t_user_id = $user_id AND a.status = 2
                                            GROUP BY b.fullname, b.profileimg
                                            ORDER BY b.fullname ASC";
                        }

                        $info = $obj_admin->manage_all_info($sql);
                        $num_row = $info->rowCount();
                        if ($num_row == 0) {
                            echo '0';
                        }

                        while ($row = $info->fetch(PDO::FETCH_ASSOC)) { ?>
                            <?php echo $row['pending_tasks']; ?>
                            <a href="taskreport-user"><button>Go Now</button></a>
                        <?php } ?>
                    </span>
                </div>
            </div>
        </div>
</body>
