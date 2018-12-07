<?php
  require_once('../../includes/PageTemplate.php');

  $currentDirectory = '/pages/' . basename(__DIR__);

  if (!isset($template))
  {
    $template = new PageTemplate();
    $template->pagetitle = "Reset Password";
    $template->body= __FILE__;

    require('../../layouts/App/index.php');
    exit;
  }
?>

<div class="row">
  <div class="col-xs-12 col-lg-6">
    <h3 class="page-header">Reset Password</h3>
    <form action="<?= $currentDirectory . '/handle-reset-password.php' ?>" method="POST">
      <div class="alert alert-info text-center">
        To reset your password, enter a new one below. You will be logged in with your new password.
      </div>
      <div class="form-group">
        <label class="control-label">New Password</label>
        <input type="password" name="new-password" placeholder="New Password" class="form-control" required />
      </div>
      <div class="form-group">
        <label class="control-label">Confirm New Password</label>
        <input type="password" name="confirm-new-password" placeholder="Confirm New Password" class="form-control" required />
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
      </div>
    </form>
  </div>
</div>

<script src="/assets/js/sha512.js"></script>
<script src="/assets/js/handle-reset-password.js"></script>
