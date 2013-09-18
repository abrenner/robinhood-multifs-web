<div class="masthead">
  <h3 class="text-muted"><a href="<?php echo site_url();?>">HPC // Disk Usage</a></h3>
  <ul class="nav nav-justified">
    <li<?php if($nav_active == "user") echo " class=\"active\""; ?>><a href="<?php echo site_url("user");?>">Usage by User</a></li>
    <li<?php if($nav_active == "filesystem") echo " class=\"active\""; ?>><a href="<?php echo site_url("filesystem");?>">Usage by FileSystem</a></li>
    <li<?php if($nav_active == "group") echo " class=\"active\""; ?>><a href="<?php echo site_url("group");?>">Usage by Group</a></li>
  </ul>
</div>