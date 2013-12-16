<!-- Jumbotron -->
  <div class="jumbotron">
      <form role="form" action="<?php echo site_url("helper/queryToSegement/");?>" method="post">
        <div class="form-group">
          <label for="userNameLabel">Group Name</label>
          <input type="text" class="form-control" id="g" name="g" placeholder="users">
          <input type="hidden" name="url" value="<?php echo site_url("group");?>">
        </div>
        <button type="submit" class="btn btn-lg btn-success">Show Group Usage</button>
      </form>
  </div>
  
  <div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Last Updated:</strong> <?php echo $last_run; ?>
  </div>