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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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
          if($user_role == 1){
        ?>
        <li><a href="dashboard.php" <?php if($page_name == "Dashboard" ){echo "class=\"active\"";} ?>><i class="ri-dashboard-horizontal-fill"></i>Dashboard</a></li>
        <li><a href="task-info.php" <?php if($page_name == "Task_Info" ){echo "class=\"active\"";} ?>><i class="ri-file-text-fill"></i>Reports</a></li>
        <li><a href="attendance-info.php" <?php if($page_name == "Attendance" ){echo "class=\"active\"";} ?>><i class="ri-team-fill"></i>Attendance</a></li>
        <li><a href="admin-manage-user.php" <?php if($page_name == "Admin" ){echo "class=\"active\"";} ?>><i class="ri-admin-fill"></i>Administration</a></li>
        
        <!-- if user is intern -->
        <?php 
          }else if($user_role == 2){ 
        ?>
        <li><a href="home.php" <?php if($page_name == "Home" ){echo "class=\"active\"";} ?>><i class="fas fa-home"></i>Home</a></li>        
        <li><a href="task-info.php" <?php if($page_name == "Task_Info" ){echo "class=\"active\"";} ?>><i class="ri-file-text-fill"></i>Reports</a></li>
        <!-- <li><a href="attendance-info.php" <?php if($page_name == "Attendance" ){echo "class=\"active\"";} ?>><i class="ri-team-fill"></i>Attendance</a></li> -->
        
        <!-- how tf does a user gain the role 1 or 2 -->
        <?php
          }else{
            header('Location: index.php');
          }
        ?>
      </ul>
      <ul>
        <div class="h-wrapper">
          <img src="placeholder_pic.jpeg" alt="" width="50px">
          <div class="v-wrapper">
              <p>Juan dela Cruz</p>
              <span>STI - IT Department</span>
          </div>
        </div>
        <li><a href="?logout=logout"><i class="ri-logout-box-r-line"></i>Logout</a></li>
      </ul>
    </div>
  </div>