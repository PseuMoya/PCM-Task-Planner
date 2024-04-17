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

if (isset($_POST['add_new_task_user_input'])) {
    $obj_admin->add_new_task_user_input($_POST);
}

$page_name = "TaskUser";
include("include/lib_links.php");


?>


<head>
    <title>Your Tasks | TaskPlanner</title>
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
                        $sql = "SELECT user_id, fullname FROM tbl_admin WHERE user_id = $user_id";
                        $info = $obj_admin->manage_all_info($sql);
                        $row = $info->fetch(PDO::FETCH_ASSOC);
                    ?>

                    <input type="text" class="form-control" id="assign_to" value="<?php echo $row['fullname']; ?>" disabled>
                    <input type="hidden" name="assign_to" value="<?php echo $row['user_id']; ?>">
                </div>

                

                <div class="btnSection">
                    <button type="submit" name="add_new_task_user_input" class="btn btn-success-custom">Assign</button>
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
            <div class="content-title">
                <h1>Your Tasks</h1>
            </div>
            <p>This is where your tasks will be listed. Each task will be assigned to you by your assigned department supervisor.</p>


            <div class="btnSection">

                <select name="status" id="status" required>
                            <option value="">Select status</option>
                            <option value="Pending">Pending</option>
                            <option value="Failed to submit">Failed to submit</option>
                            <option value="In progress">In progress</option>
                            <option value="Completed">Completed</option>
                </select>
                <?php if($user_role == 2){ ?>
                    <div class="btnSection">
                        <div class="btn-group">
                        <button id="openModal"><i class="ri-add-large-line"></i>Assign a new task</button>
                        </div>
                    </div>
                <?php } ?>
            </div>

            
            <span class=on-phone>Tip: Scroll right to see more information.</span>

            <div class="card with-table">
                <div class="table-container">
                    <table id="internTable">
                        <thead>
                            <tr>
                                <!-- <th>#</th> -->
                                <th>Task Title</th>
                                <!-- <th>Assigned to</th> -->
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
                                echo '<tr>
                                        <div class="data-not-found">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-check-big"><path d="m9 11 3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                                            <span>No tasks currently assigned.</span>
                                            <p>Tasks will appear here when it\'s been assigned to you.</p>
                                        </div>
                                      </tr>
                                    
                                    <style>table{display:none;}</style>';
                            }

                            while ($row = $info->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <!-- <td><?php echo $serial;
                                                $serial++; ?></td> -->
                                    <td><?php echo $row['t_title']; ?></td>
                                    <!-- <td><?php echo $row['fullname']; ?></td> -->
                                    <td><?php echo $row['t_start_time']; ?></td>
                                    <td><?php echo $row['t_end_time']; ?></td>

                                    <td>
                                        <?php if ($row['status'] == 1) {
                                            echo "<div class='status-indicator in-progress'>In progress</div>";
                                        } elseif ($row['status'] == 2) {
                                            echo "<div class='status-indicator completed'>Completed</div>";
                                        } elseif ($row['status'] == 3) {
                                            echo "<div class='status-indicator failedtosub'>Failed to submit</div>";
                                        } else {
                                            echo "<div class='status-indicator pending'>Pending</div>";
                                        } ?>
                                    </td>

                                    <td>
                                        <div class="actions">

                                            <?php
                                            if ($row['status'] != 3) {
                                                echo "<a title='Update Task' href='edit-task.php?task_id=" . $row['task_id'] . "'><i class='ri-edit-2-fill'></i></a>";
                                            }
                                            ?>

                                            <!-- <a title="Update Task" href="edit-task.php?task_id=<?php echo $row['task_id']; ?>"><i class="ri-edit-2-fill"></i></a> -->
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
        // defaultDate: currentDate,
        time_24hr: false,
        minDate: currentDate // disable past dates
    });
    
    flatpickr('#t_end_time', {
        enableTime: true,
        minTime: "9:00",
        maxTime: "18:00",
        // defaultDate: currentDate,
        time_24hr: false,
        minDate: currentDate // disable past dates
    });

   
</script>   
<script type = "text/javascript">
     var statusSelect = document.getElementById('status');
    statusSelect.addEventListener("change", function(){
        filterTableByStatus(this.value);
    });
    function filterTableByStatus(status){
        console.log("filter select called");
        var table = document.getElementById('internTable');
        var rows = table.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            row.style.display = "table-row";
            var cells = row.getElementsByTagName('td');
    
            if (cells.length >= 4) {
                var rowStatus = cells[3].innerText;
                if (status === '' || rowStatus === status) {
                    row.style.display = "table-row";
                } else {
                    row.style.display = "none";
                }
            }
        }
    }
</script>