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
$positions = ['IT Department', 'Admin Department', 'Marketing Department', 'HR Department'];

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
            <div class="content-title">
                <h1>Intern List</h1>
                <p>See if interns have tasks at hand.</p>
            </div>

            <div class="btnSection">
                <div class="search-bar">
                    <i class="ri-search-line"></i>
                    <input type="text" placeholder="Search name..." name="search" id="search">
                </div>
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

            <span class=on-phone>Tip: Scroll right to see more information.</span>

            <div class="card with-table">
                <div class="table-container">
                    <table id="internTable">
                        <thead>
                            <tr>
                                <th>No.</th>
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
                                echo '<tr>
                                        <div class="data-not-found">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                                        <span>No data found</span>
                                            <p>Try refreshing the website.</p>
                                        </div>
                                      </tr>
                            
                                        <style>table{display:none;}</style>';
                            }
                            while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
                                $user_id = $row['user_id'];
                                $sql = "SELECT * FROM task_info WHERE t_user_id = $user_id AND (status != 2 AND status != 3)";
                                $task_info = $obj_admin->manage_all_info($sql);
                                $task_num = $task_info->rowCount();
                            ?>

                                <tr>
                                    <?php if($row['position'] != 'Super Admin'){ ?>
                                    <td><?php echo $serial++; ?></td>
                                    <td><div class="profile-name"><div class="img-container"><img src="<?php echo $row['profileimg']; ?>" alt="Profile Image"></div><?php echo $row['fullname']; ?></div></td>
                                    <td><?php echo $row['position']; ?></td>
                                    <td><?php echo $task_num; ?></td>
                                    <td>
                                        <?php
                                        if ($task_num == 0) {
                                            echo "<div class='status-indicator failedtosub'>No tasks currently</div>";
                                        } else {
                                            echo "<div class='status-indicator completed'>Task assigned</div>";
                                        }
                                        ?>
                                    </td>
                                    <?php } ?>

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
<script>
    var searchInput = document.getElementById('search');
    searchInput.addEventListener("input", function(){
        filterTableBySearch(this.value);
    });
    function filterTableBySearch (searchText) {
        var table = document.getElementById('internTable');
        var rows = table.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            var internNameCell = row.getElementsByTagName('td')[    1];
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
</script>