<!-- Jumbotron -->
  <div class="jumbotron">
      <form role="form" action="<?php echo site_url("helper/queryToSegement/");?>" method="post">
        <div class="form-group">
          <label for="userNameLabel">User Name</label>
          <input type="text" class="form-control" id="u" name="u" placeholder="panteater" maxlength="8">
          <input type="hidden" name="url" value="<?php echo site_url("user");?>">
        </div>
        <button type="submit" class="btn btn-lg btn-success">Show Disk Usage</button>
      </form>
  </div>
  
  <div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Last Updated:</strong> <?php echo $last_run; ?>
  </div>