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
  $sent_po = "task-info";
  $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
}

if (isset($_POST['add_task_post'])) {
  $obj_admin->add_new_task($_POST);
}

$page_name = "TaskUser";
include("include/lib_links.php");


?>


<head>
    <title>Report | TaskUser</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <form role="form" action="" method="post" autocomplete="off">
        <div id="modalBG">
            <div class="modal">
                <div class="modalTitle">
                    <h2>New task</h2>
                </div>

                <div class="v-wrapper">
                    <label for="task_title">Task Title</label>
                    <input type="text" placeholder="Name of the task" id="task_title" name="task_title" list="expense" class="form-control" id="default" required>
                </div>

                <div class="v-wrapper">
                    <label for="task_description">Task Description</label>
                    <textarea name="task_description" id="task_description" placeholder="What's the task all about...?" class="form-control"></textarea>
                </div>

                <div class="h-wrapper">
                    <div class="v-wrapper">
                        <label for="t_start_time">Start Time</label>
                        <input type="text" name="t_start_time" id="t_start_time" class="form-control">
                    </div>
    
                    <div class="v-wrapper">
                        <label for="t_end_time">End Time</label>
                        <input type="text" name="t_end_time" id="t_end_time" class="form-control">
                    </div>
                </div>

                <div class="v-wrapper">
                    <label for="assign_to">Assign to</label>
                    <?php
                    $sql = "SELECT user_id, fullname FROM tbl_admin WHERE user_role = 2";
                    $info = $obj_admin->manage_all_info($sql);
                    ?>

                    <select class="form-control" name="assign_to" id="aassign_to" required>
                        <option value="">Please select an intern...</option>

                        <?php while ($row = $info->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?php echo $row['user_id']; ?>"><?php echo $row['fullname']; ?></option>
                        <?php } ?>
                        </select>
                </div>

                <div class="btnSection">
                    <button type="submit" name="add_task_post" class="btn btn-success-custom">Assign</button>
                    <button id="exitModal">Cancel</button>
                </div>
            </div>
        </div>
    </form>

    <div class="page">
        <?php
        $page_name = "TaskUser";
        include("include/sidebar.php");
        // include('ems_header.php');
        ?>

        <div class="content">
            <h1>Reports</h1>
            
            <div class="btnSection">
                <?php if($user_role == 1){ ?>
                    <div class="btn-group">
                      <button id="openModal"><i class="ri-add-large-line"></i>Assign a new task</button>
                    </div>
                <?php } ?>
            </div>
            
            <div class="card">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <!-- <th>#</th> -->
                                <th>Task Title</th>
                                <th>Assigned to</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($user_role == 1) {
                                $sql = "SELECT a.*, b.fullname 
                              FROM task_info a
                              INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                              ORDER BY a.task_id DESC";
                            } else {
                                $sql = "SELECT a.*, b.fullname 
                                FROM task_info a
                                INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                                WHERE a.t_user_id = $user_id
                                ORDER BY a.task_id DESC";
                            }

                            $info = $obj_admin->manage_all_info($sql);
                            $serial  = 1;
                            $num_row = $info->rowCount();
                            if ($num_row == 0) {
                                echo '<tr><td colspan="7">No Data found</td></tr>';
                            }

                            while ($row = $info->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <!-- <td><?php echo $serial;
                                    $serial++; ?></td> -->
                                    <td><?php echo $row['t_title']; ?></td>
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['t_start_time']; ?></td>
                                    <td><?php echo $row['t_end_time']; ?></td>

                                    <td>
                                        <?php if ($row['status'] == 1) {
                                            echo "<div class='status-indicator in-progress'>In Progress</div>";
                                        } elseif ($row['status'] == 2) {
                                            echo "<div class='status-indicator completed'>Completed</div>";
                                        } else {
                                            echo "<div class='status-indicator incomplete'>Incomplete</div>";
                                        } ?>
                                    </td>

                                    <td>
                                        <div class="actions">
                                            <a title="Update Task" href="edit-task.php?task_id=<?php echo $row['task_id']; ?>"><i class="ri-edit-2-fill"></i></a>
                                            <a title="View" href="task-details.php?task_id=<?php echo $row['task_id']; ?>"><i class="ri-folder-open-fill"></i></a>
                                            <?php if ($user_role == 1) { ?>
                                                <a title="Delete" href="?delete_task=delete_task&task_id=<?php echo $row['task_id']; ?>" onclick=" return check_delete();"><i class="ri-delete-bin-6-fill"></i></a>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      
</body>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script type="text/javascript">
  let currentDate = new Date();
  flatpickr('#t_start_time', {
    enableTime: true,
    minTime: "9:00",
    maxTime: "18:00",
    defaultDate: currentDate,
    time_24hr: false

  });

  flatpickr('#t_end_time', {
    enableTime: true,
    minTime: "9:00",
    maxTime: "18:00",
    defaultDate: currentDate,
    time_24hr: false
  });
</script>
