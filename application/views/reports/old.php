<p><br />
    <h4>Old Disk Usage Reports: <?php echo $user; ?></h4>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>FileSystem</th>
          <th>Latest Mod Time</th>
          <th>Count</th>
          <th>Path</th>e
        </tr>
      </thead>
      <tbody>
        <?php
        $count = 0;
        foreach ($results->result() as $row) {
            $count += $row->value;
        ?>
        <tr>
          <td><?php echo $row->filesystem; ?></td>
          <td><?php echo $row->last_mod; ?></td>
          <td><?php echo formatNumber($row->value); ?></td>
          <td><?php echo $row->path; ?></td>
        </tr>
        <?php
        }
        ?>
        <tr class="table-bordered warning">
          <td><?php echo formatNumber($count); ?> Files</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
</p>