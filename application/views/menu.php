<div class="masthead">
  <h3 class="text-muted"><a href="index.php">HPC // Disk Usage</a></h3>
  <ul class="nav nav-justified">
    <li<?php if($nav_active == "user") echo " class=\"active\""; ?>><a href="user.php">Usage by User</a></li>
    <li><a href="#">Usage by FileSystem</a></li>
    <li<?php if($nav_active == "group") echo " class=\"active\""; ?>><a href="group.php">Usage by Group</a></li>
    <li><a href="#">Old File Usage</a></li>
  </ul>
</div>