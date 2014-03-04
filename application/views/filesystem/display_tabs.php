<p><br />
    <h4>Filesystem Usage for: <?php echo $filesystem; ?></h4>
    <ul id="myTab" class="nav nav-tabs">
      <li<?php if($filesystem == FALSE) echo " class=\"active\""; ?>><a href="<?php echo site_url("filesystem"); ?>">Summary</a></li>
      <?php
        foreach($fs_list->result() as $row) {
      ?>
      <li<?php if($filesystem != FALSE && $filesystem == substr($row->filesystem,1)) echo " class=\"active\""; ?>><a href="<?php echo site_url("filesystem/".$row->filesystem.""); ?>"><?php echo $row->filesystem; ?></a></li>
      <?php
        }
      ?>
    </ul>