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
          if($user_role == 1){
        ?>
        <li><a href="task-info.php" <?php if($page_name == "Task_Info" ){echo "class=\"active\"";} ?>><i class="ri-list-check-3"></i>Task Management</a></li>
        <!-- <li><a href="attendance-info.php" <?php if($page_name == "Attendance" ){echo "class=\"active\"";} ?>><i class="ri-user-2-fill"></i>Attendance</a></li> -->
        <li><a href="manage-admin.php" <?php if($page_name == "Admin" ){echo "class=\"active\"";} ?>><i class="ri-group-fill"></i>User Management</a></li>
        
        <!-- if user is intern -->
        <?php 
          }else if($user_role == 2){ 
        ?>
        <li><a href="task-info.php" <?php if($page_name == "Task_Info" ){echo "class=\"active\"";} ?>>Pang</a></li>
        <li><a href="attendance-info.php" <?php if($page_name == "Attendance" ){echo "class=\"active\"";} ?>>Intern</a></li>
        <li><a href="manage-admin.php" <?php if($page_name == "Admin" ){echo "class=\"active\"";} ?>>To</a></li>

        <!-- how tf does a user gain the role 1 or 2 -->
        <?php
          }else{
            header('Location: index.php');
          }
        ?>
      </ul>
      <ul>
        <li><a href="?logout=logout">Logout</a></li>
      </ul>
    </div>
  </div>
<div class="main">