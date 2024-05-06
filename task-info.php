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
    <form role="form" action="" enctype="multipart/form-data" method="post" autocomplete="off">
        <div id="modalBG">
            <div class="modal">
                <div class="modalTitle">
                    <h2>New task</h2>
                </div>

                <div class="v-wrapper">
                    <label for="task_title">Task Name</label>
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
                        <option value="all">All</option>
                        <?php foreach (array_keys($data) as $position) { ?>
                            <option value="<?php echo $position; ?>"><?php echo $position; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div>
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
                        if (position === 'all') {
                            Object.values(data).forEach(function(positionData) {
                                positionData.forEach(function(item) {
                                    var option = document.createElement('option');
                                    option.value = item.id;
                                    option.text = item.name;
                                    option.setAttribute('selected', 'selected');
                                    assignTo.add(option);
                                });
                            });
                        } else if (position in data) {
                            data[position].forEach(function(item) {
                                var option = document.createElement('option');
                                option.value = item.id;
                                option.text = item.name;
                                assignTo.add(option);
                            });
                        }
                    });
                </script>

                <div class="v-wrapper">
                    <label for="task_img">Task Image / File</label>
                    <div class="file-drop-area" style="height: 150px;">

                        <div class="no-file-yet">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-up">
                                <path d="M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21" />
                                <path d="m14 19.5 3-3 3 3" />
                                <path d="M17 22v-5.5" />
                                <circle cx="9" cy="9" r="2" />
                            </svg>
                            <p><b>Upload an image</b> if words aren't enough</p>
                            <span>It can either be an image, PDF, etc.</span>
                        </div>

                        <div class="has-file">
                            <span class="fake-btn">Choose another file</span>
                            <span class="file-msg"></span>
                        </div>

                        <input class="file-input" type="file" name="task_img[]" multiple onchange="limitFiles(this)">
                    </div>
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
        $page_name = "Task_Info";
        include("include/sidebar.php");
        // include('ems_header.php');
        ?>

        <div class="content">
            <div class="content-title">
                <h1>Reports</h1>
                <p>Oversee each intern's task. You may assign a task to an intern, or to all of them.</p>
            </div>

            <div class="btnSection">
                <div class="search-bar">
                    <i class="ri-search-line"></i>
                    <input type="text" placeholder="Search name..." name="search" id="search">
                </div>

                <div class="btnSection">

                    <div class="h-wrapper">
                        <select name="status" id="status" required>
                            <option value="">Select status</option>
                            <option value="Pending">Pending</option>
                            <option value="Failed to submit">Failed to submit</option>
                            <option value="In progress">In progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                        <?php if ($user_role == 1) { ?>
                            <button id="openModal"><i class="ri-add-large-line"></i>Assign a new task</button>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <span class="on-phone">Tip: Scroll right to see more information.</span>

            <div class="card with-table">
                <div class="table-container">
                    <table id="internTable">
                        <thead>
                            <tr>
                                <!-- <th>#</th> -->
                                <th>Task Name</th>
                                <th>Assigned to</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Proof Image / File</th>
                                <th>Task Image / File</th>

                                <th></th>
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
                                        } elseif ($row['status'] == 3) {
                                            echo "<div class='status-indicator failedtosub'>Failed to submit</div>";
                                        } else {
                                            echo "<div class='status-indicator pending'>Pending</div>";
                                        } ?>
                                    </td>



                                    <td>
                                        <div class="attachment">
                                            <?php if (!empty($row['proof'])) {
                                                if (@getimagesize($row['proof'])) { ?>
                                                    <a href="<?php echo $row['proof']; ?>" target="_blank"><i class="ri-external-link-line"></i>
                                                        <div class="img-container"><img src="<?php echo $row['proof']; ?>" alt=""></div>
                                                    </a>

                                                <?php } else { ?>
                                                    <a href="<?php echo $row['proof']; ?>" target="_blank"><i class="ri-external-link-line"></i><?php echo basename($row['proof']); ?></a>

                                                <?php }
                                            } else { ?>
                                                <div class="no-proof"><i class="ri-close-line"></i>No Proof</div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="attachment">
                                            <?php
                                            if (!empty($row['task_img'])) {
                                                $images = json_decode($row['task_img'], true);

                                                if (is_array($images)) {
                                                    $fileCount = count($images);
                                                    if ($fileCount == 0) {
                                                        echo "<div class=\"no-proof\"><i class=\"ri-close-line\"></i>No task attachment</div>";
                                                    } else {
                                                        echo "<button class=\"open-attach-modal\"><i class=\"ri-attachment-2\"></i>$fileCount file(s) attached</button>";
                                                    ?>
                                                        <div id="attachment-modalBG">
                                                            <div class="attachment-modal">
                                                                <div class="modalTitle">
                                                                    <h2>Attached files</h2>
                                                                    <span class="close">&times;</span>
                                                                </div>

                                                                <?php
                                                                    $images = json_decode($row['task_img'], true);
                                                                    $fileCount = count($images);
                                                                    echo "<span>$fileCount files attached</span>";
                                                                ?>

                                                                <div class="list-file">
                                                                    <?php
                                                                    if (!empty($row['task_img'])) {

                                                                        if (is_array($images)) {
                                                                            

                                                                            foreach ($images as $filename) {
                                                                                $fileUrl = "http://localhost/PCM-Task-Planner/task_image/$filename";

                                                                                if (@getimagesize($fileUrl)) {
                                                                                    echo "<a href=\"$fileUrl\" target=\"_blank\"><i class=\"ri-external-link-line\"></i><div class=\"img-container\"><img src=\"$fileUrl\" alt=\"\"></div></a>";
                                                                                } else {
                                                                                    echo "<a href=\"$fileUrl\" target=\"_blank\"><i class=\"ri-external-link-line\"></i>" . basename($fileUrl) . "</a>";
                                                                                }
                                                                            }
                                                                        } else {
                                                                            $fileUrl = "http://localhost/PCM-Task-Planner/task_image/" . $row['task_img'];

                                                                            if (@getimagesize($fileUrl)) {
                                                                                echo "<a href=\"$fileUrl\" target=\"_blank\"><i class=\"ri-external-link-line\"></i><div class=\"img-container\"><img src=\"$fileUrl\" alt=\"\"></div></a>";
                                                                            } else {
                                                                                echo "<a href=\"$fileUrl\" target=\"_blank\"><i class=\"ri-external-link-line\"></i>" . basename($fileUrl) . "</a>";
                                                                            }
                                                                        }
                                                                    } else {
                                                                    ?>
                                                                        <div class="no-proof"><i class="ri-close-line"></i>No task attachment</div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                            <?php
                                                    }
                                                }
                                            } ?>
                                        </div>
                                    </td>

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
<script type="text/javascript">
    // Get references to modal elements
    var attachModalItself = document.querySelector(".attachment-modal");
    var attachModal = document.getElementById("attachment-modalBG");

    // Get references to modal elements
    var exitModals = document.querySelectorAll(".close");

    var btnOpenAttachModal = document.querySelectorAll(".open-attach-modal");
    btnOpenAttachModal.forEach(function(btn) {
        btn.onclick = function() {
            // Find the closest modal to the clicked button
            var modal = btn.closest(".attachment").querySelector("#attachment-modalBG");

            // Show the modal
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        };
    });

    exitModals.forEach(function(closeBtn) {
        closeBtn.onclick = function() {
            var modal = closeBtn.closest("#attachment-modalBG");

            // Hide the modal
            modal.classList.remove('show');
            document.body.style.overflow = '';
        };
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
    let currentDate = new Date();

    flatpickr('#t_start_time', {
        enableTime: true,
        minTime: "9:00",
        maxTime: "18:00",
        defaultDate: currentDate,
        time_24hr: false,
        minDate: currentDate // disable past dates
    });

    flatpickr('#t_end_time', {
        enableTime: true,
        minTime: "9:00",
        maxTime: "18:00",
        defaultDate: currentDate,
        time_24hr: false,
        minDate: currentDate // disable past dates
    });
</script>

<!-- <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.querySelector('.file-input');
        var droparea = document.querySelector('.file-drop-area');
        var fileMsg = document.querySelector('.file-msg');

        var noFile = document.querySelector('.no-file-yet');
        var hasFile = document.querySelector('.has-file');

        fileInput.addEventListener('change', function() {
            var filesCount = this.files.length;

            if (filesCount === 1) {
                var fileName = this.files[0].name;
                fileMsg.textContent = fileName;
                hasFile.style.display = 'flex';
                noFile.style.display = 'none';
            }
        });
    });
</script> -->
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.querySelector('.file-input');
        var droparea = document.querySelector('.file-drop-area');
        var fileMsg = document.querySelector('.file-msg');

        var noFile = document.querySelector('.no-file-yet');
        var hasFile = document.querySelector('.has-file');

        fileInput.addEventListener('change', function() {
            var filesCount = this.files.length;

            if (filesCount > 0) {
                fileMsg.textContent = filesCount + ' file(s) selected';
                hasFile.style.display = 'flex';
                noFile.style.display = 'none';
            }
        });
    });
</script>


<script type="text/javascript">
    var searchInput = document.getElementById('search');
    searchInput.addEventListener("input", function() {
        filterTableBySearch(this.value);
    });

    function filterTableBySearch(searchText) {
        var table = document.getElementById('internTable');
        var rows = table.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            var internNameCell = row.getElementsByTagName('td')[1];
            if (internNameCell) {
                var internName = internNameCell.textContent || internNameCell.innerText;
                if (internName.toLowerCase().indexOf(searchText.toLowerCase()) > -1) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }


        }
    }

    function getUrlParams() {
        var params = {};
        window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str, key, value) {
            params[key] = decodeURIComponent(value);
        });
        return params;
    }

    var urlParams = getUrlParams();
    var statusParam = urlParams["status"];

    if (statusParam) {
        var statusSelect = document.getElementById('status');
        statusSelect.value = statusParam;
        filterTableByStatus(statusSelect.value);


    }

    var statusSelect = document.getElementById('status');
    statusSelect.addEventListener("change", function() {
        filterTableByStatus(this.value);
    });

    function filterTableByStatus(status) {
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

    function limitFiles(input) {
        if (input.files.length > 20) {
            alert("You can only select up to 20 files.");
            input.value = '';
        } else if (input.files.length === 21) {
            input.disabled = true;
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