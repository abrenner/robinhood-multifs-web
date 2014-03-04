    <table class="table table-hover">
      <thead>
        <tr>
          <th>Size</th>
          <th>File Count</th>
          <th>File System</th>
          <th></th>
          <th></th>
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
          <td><?php echo byte_format($row->blocks); ?></td>
          <td><?php echo formatNumber($row->count); ?></td>
          <td><?php echo $row->filesystem; ?></td>
          <td><?php if($row->label != null) { ?><span class="label label-<?php echo $row->label; ?>"><?php echo $row->description; ?></span><?php } ?></td>
          <td><a href="<?php echo site_url("filesystem/".$row->filesystem.""); ?>">Breakdown</a></td>
        </tr>
        <?php
        }
        ?>
        <tr class="table-bordered warning">
          <td><?php echo byte_format($size); ?> Used</td>
          <td><?php echo formatNumber($count); ?> Files</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
</p>
<div class="alert alert-info alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Last Updated:</strong> <?php echo $last_run; ?>
</div>