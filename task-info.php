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
  $sent_po = "task-info.php";
  $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
}

if (isset($_POST['add_task_post'])) {
  $obj_admin->add_new_task($_POST);
}

$page_name = "Task_Info";
include("include/lib_links.php");


?>


<head>
    <title>Reports | TaskPlanner</title>
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
                    <label for="position">Position</label>
                    <?php
                    $sql = "SELECT user_id, fullname, position FROM tbl_admin WHERE user_role = 2 ORDER BY position";
                    $info = $obj_admin->manage_all_info($sql);
                    $data = [];
                    while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
                        $data[$row['position']][] = ['id' => $row['user_id'], 'name' => $row['fullname']];
                    }
                    ?>

                    <select class="form-control" name="position" id="position" required>
                        <option value="">Please select a position...</option>
                        <option value = "all">All</option>
                        <?php foreach (array_keys($data) as $position) { ?>
                            <option value="<?php echo $position; ?>"><?php echo $position; ?></option>
                        <?php } ?>
                    </select>

                    <label for="assign_to">Assign to</label>
                    <select class="form-control" name="assign_to[]" id="assign_to" multiple required>
                        <option value="">Please select an intern...</option>
                       
                    </select>
                </div>

                <script>
                    var data = <?php echo json_encode($data); ?>;
                    document.getElementById('position').addEventListener('change', function() {
                        var position = this.value;
                        var assignTo = document.getElementById('assign_to');
                        assignTo.innerHTML = '<option value="">Please select an intern...</option>';
                        if (position === 'all'){
                            Object.values(data).forEach(function(positionData) {
                                positionData.forEach(function(item) {
                                    var option = document.createElement('option');
                                    option.value = item.id;
                                    option.text = item.name;
                                    option.setAttribute('selected', 'selected');
                                    assignTo.add(option);
                                });
                            });
                        }else if (position in data) {
                            data[position].forEach(function(item) {
                                var option = document.createElement('option');
                                option.value = item.id;
                                option.text = item.name;
                                assignTo.add(option);
                            });
                        }
                    });
                </script>


                <div class="btnSection">
                    <button type="submit" name="add_task_post" class="btn btn-success-custom">Assign</button>
                    <button id="exitModal">Cancel</button>
                </div>
            </div>
        </div>
    </form>

    <div class="page">
        <?php
        $page_name = "Task_Info";
        include("include/sidebar.php");
        // include('ems_header.php');
        ?>

        <div class="content">
            <h1>Reports</h1>
            <div class="search-bar">
                        <input type="text" placeholder="Search..." name="search" id="search">
                    </div>

                    <select name="status" id="status" required>
                        <option value="">Select status</option>
                        <option value="Pending">Pending</option>
                        <option value="Failed to submit">Failed to submit</option>
                        <option value="In progress">In progress</option>
                        <option value="Completed">Completed</option>
                    </select>
            
            <?php if($user_role == 1){ ?>
                <div class="btnSection">
                      <button id="openModal"><i class="ri-add-large-line"></i>Assign a new task</button>
                </div>
            <?php } ?>
            
            <div class="card with-table">
                <div class="table-container">
                    <table id="internTable">
                        <thead>
                            <tr>
                                <!-- <th>#</th> -->
                                <th>Task Title</th>
                                <th>Assigned to</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Proof Image</th>
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
                                            <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
                                            <span>No tasks currently assigned.</span>
                                            <p>You can start by assigning a new task to an intern.</p>
                                        </div>
                                      </tr>
                            
                                        <style>table{display:none;}</style>';
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
                                            echo "<div class='status-indicator in-progress'>In progress</div>";
                                        } elseif ($row['status'] == 2) {
                                            echo "<div class='status-indicator completed'>Completed</div>";
                                        }elseif ($row['status'] == 3) { 
                                            echo "<div class='status-indicator failedtosub'>Failed to submit</div>"; 
                                        } else {
                                            echo "<div class='status-indicator pending'>Pending</div>";
                                        } ?>
                                    </td>

                                    <td>
                                        <div class="attachment">
                                            <?php if (!empty($row['proof'])) { ?>
                                                <a href="<?php echo $row['proof']; ?>" target="_blank"><i class="ri-external-link-line"></i><img src="<?php echo $row['proof']; ?>" alt=""></a>
                                                <span class="tooltiptext">See attachment</span>
                                            <?php } else { ?>
                                                <div class="no-proof"><i class="ri-close-line"></i>No Proof</div>
                                            <?php } ?>
                                        </div>
                                    </td>

                                    <td>
                                    <div class="actions"> 
                                            <?php if ($row['status'] = 3 && $user_role = 2) { ?> 
                                                <a title="Update Task" href="edit-task.php?task_id=<?php echo $row['task_id']; ?>"><i class="ri-edit-2-fill"></i></a> 
                                            <?php } ?> 
                                            <a title=" View" href="task-details.php?task_id=<?php echo $row['task_id']; ?>"><i class="ri-folder-open-fill"></i></a> 
                                            <?php if ($user_role = 1) { ?> 
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
        <!-- include the sidebar -->
        <?php
        include("include/footer.php");
        ?>
</body>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>

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
<script type="text/javascript">
    var searchInput = document.getElementById('search');
    searchInput.addEventListener("input", function(){
        filterTableBySearch(this.value);
    });
    function filterTableBySearch (searchText) {
        var table = document.getElementById('internTable');
        var rows = table.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            var internNameCell = row.getElementsByTagName('td')[1];
            if(internNameCell){
                var internName = internNameCell.textContent || internNameCell.innerText;
                if (internName.toLowerCase().indexOf(searchText.toLowerCase()) > -1) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
            }

           
        }
    }

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
                var rowStatus = cells[4].innerText;
                if (status === '' || rowStatus === status) {
                    row.style.display = "table-row";
                } else {
                    row.style.display = "none";
                }
            }
        }
    }
</script>
<!-- <script type="text/javascript">
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
</script> -->



