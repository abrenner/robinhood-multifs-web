<p><br />
    <h4>Group Disk Usage for: <?php echo $group; ?></h4>
    <ul id="myTab" class="nav nav-tabs">
      <li<?php if($filesystem == FALSE) echo " class=\"active\""; ?>><a href="<?php echo site_url("group/$group"); ?>">Summary</a></li>
      <?php
        foreach($group_fs_list->result() as $row) {
      ?>
      <li<?php if($filesystem != FALSE && $filesystem == substr($row->filesystem,1)) echo " class=\"active\""; ?>><a href="<?php echo site_url("group/$group/".substr($row->filesystem,1).""); ?>"><?php echo $row->filesystem; ?></a></li>
      <?php
        }
      ?>
    </ul>