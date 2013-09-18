    <table class="table table-hover">
      <thead>
        <tr>
          <th>Size</th>
          <th>File Count</th>
          <th>File System</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $size = 0; $count = 0;
        foreach ($group_fs_usage->result() as $row) {
            $size += $row->blocks;
            $count += $row->count;
        ?>
        <tr>
          <td><?php echo byte_format($row->blocks); ?></td>
          <td><?php echo formatNumber($row->count); ?></td>
          <td><?php echo $row->filesystem; ?></td>
        </tr>
        <?php
        }
        ?>
        <tr class="table-bordered warning">
          <td><?php echo byte_format($size); ?></td>
          <td><?php echo formatNumber($count); ?></td>
          <td></td>
        </tr>
      </tbody>
    </table>
</p>