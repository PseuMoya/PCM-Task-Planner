<script type="text/javascript">
    /* delete function confirmation  */
    function check_delete() {
        var check = confirm('Are you sure you want to delete this?');
        if (check) {

            return true;
        } else {
            return false;
        }
    }
</script>

<div class="sidebar">
    <div class="title">
        <img src="logo.svg" alt="">
        <p>Task<span>Planner</span></p>
    </div>
    <div class="sidebar-wrapper">
        <ul>
            <!-- if user is admin -->
            <?php
            $user_role = $_SESSION['user_role'];
            if ($user_role == 1) {
            ?>
                <li><a href="dashboard" <?php if ($page_name == "Dashboard") {
                                            echo "class=\"active\"";
                                        } ?>><i class="ri-dashboard-horizontal-fill"></i>Dashboard</a></li>
                <li><a href="task-info" <?php if ($page_name == "Task_Info") {
                                            echo "class=\"active\"";
                                        } ?>><i class="ri-file-text-fill"></i>Reports</a></li>
                <li><a href="attendance-info" <?php if ($page_name == "Attendance") {
                                                    echo "class=\"active\"";
                                                } ?>><i class="ri-team-fill"></i>Intern List</a></li>
                <li><a href="admin-manage-user" <?php if ($page_name == "Admin") {
                                                    echo "class=\"active\"";
                                                } ?>><i class="ri-admin-fill"></i>User Management</a></li>

                <!-- if user is intern -->
            <?php
            } else if ($user_role == 2) {
            ?>
                <li><a href="home" <?php if ($page_name == "Home") {
                                        echo "class=\"active\"";
                                    } ?>><i class="ri-home-fill"></i>Home</a></li>
                <li><a href="taskreport-user" <?php if ($page_name == "TaskUser") {
                                                    echo "class=\"active\"";
                                                } ?>><i class="ri-list-check-3"></i>Your Tasks</a></li>
                <li><a href="userprofile-info.php" <?php if ($page_name == "User_Profile") {
                                                        echo "class=\"active\"";
                                                    } ?>><i class="ri-admin-fill"></i>User Profile</a></li>

                <!-- how tf does a user gain the role 1 or 2 -->
            <?php
            } else {
                header('Location: index');
            }
            ?>
        </ul>
        <ul>
            <?php
            $sql = "SELECT b.fullname, b.profileimg, b.position
          FROM tbl_admin b
          WHERE b.user_id = $user_id
          ORDER BY b.fullname ASC";

            $info = $obj_admin->manage_all_info($sql);
            $num_row = $info->rowCount();

            while ($row = $info->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="h-wrapper">
                    <div class="img-container"><img src="<?php echo $row['profileimg']; ?>" alt="Profile Image"></div>
                    <div class="v-wrapper">
                        <p><?php echo $row['fullname']; ?></p>
                        <span><?php echo $row['position']; ?></span>
                    </div>
                </div>
                <?php
                $user_role = $_SESSION['user_role'];
                if ($user_role == 2) {
                ?>
                    <li><a href="INTERN-USER-MANUAL.pdf" target="_blank" class="manual"><i class="ri-book-fill"></i>User Manual</a></li>
                <?php } else { ?>
                    <li><a href="ADMIN-USER-MANUAL.pdf" target="_blank" class="manual"><i class="ri-book-fill"></i>Admin Manual</a></li>
                <?php } ?>
                <li><a href="?logout=logout"><i class="ri-logout-box-r-line"></i>Logout</a></li>
            <?php } ?>
        </ul>
    </div>
    <div class="hamburger-menu" id="hamburger"><i class="ri-menu-line"></i></div>
</div>

<button id="sidebarBtn" class="on-desktop">
    <i class="ri-arrow-left-wide-line"></i>
</button>

<script type="text/javascript">
    let isOpen = true; // Track the current size state
    const sidebar = document.querySelector('.sidebar');
    const sidebarBtn = document.querySelector('#sidebarBtn');

    sidebarBtn.addEventListener('click', function() {
        this.classList.toggle('active');
        if (isOpen == true) {
            document.documentElement.style.setProperty('--sidebar-width', '0px');
            sidebar.style.left = '-4%';
            isOpen = false;

        } else {
            document.documentElement.style.setProperty('--sidebar-width', '275px');
            sidebar.style.left = '0%';
            isOpen = true;
        }
    });

    // Function to handle window resize
    function handleResize() {
        if (!isOpen && window.innerWidth <= 768) {
            sidebar.style.left = '0%';
            document.documentElement.style.setProperty('--sidebar-width', '275px');
            isOpen = true;
        }
    }

    // Add event listener for window resize
    window.addEventListener('resize', handleResize);

    // Call handleResize initially
    handleResize();

    let hamburger = document.querySelector('#hamburger');
    let nav = document.querySelector('.sidebar-wrapper');

    hamburger.onclick = () => {
        nav.classList.toggle('open');
    }
</script>