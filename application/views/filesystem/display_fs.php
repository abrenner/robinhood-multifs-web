    <table class="table table-hover">
      <thead>
        <tr>
          <th>User</th>
          <th>Size</th>
          <th>File Count</th>
          <th>File System</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $size = 0; $count = 0;
        foreach ($fs_usage->result() as $row) {
            $size += $row->blocks;
            $count += $row->count;
        ?>
        <tr>
          <td><a href="<?php echo site_url("user/$row->user"); ?>"><?php echo $row->user; ?></a></td>
          <td><?php echo byte_format($row->blocks); ?></td>
          <td><?php echo formatNumber($row->count); ?></td>
          <td><?php echo $row->filesystem; ?></td>
        </tr>
        <?php
        }
        ?>
        <tr class="table-bordered warning">
          <td><?php echo $fs_usage->num_rows(); ?> Users</td>
          <td><?php echo byte_format($size); ?></td>
          <td><?php echo formatNumber($count); ?></td>
          <td>&nbsp;</td>
        </tr>
      </tbody>
    </table>
</p>