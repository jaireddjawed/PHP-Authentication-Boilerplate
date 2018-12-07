<?php
  require_once('../../includes/PageTemplate.php');
  require_once('../../includes/CsrfToken.php');

  $currentDirectory = '/pages/' . basename(__DIR__);

  if (!isset($template))
  {
    $template = new PageTemplate();
    $template->pagetitle = "Recover Password";
    $template->body = __FILE__;

    require('../../layouts/App/index.php');
    exit;
  }
?>

<div class="row">
  <div class="col-xs-12 col-lg-6">
    <h3 class="page-header">Recover Password</h3>
    <form action="<?= $currentDirectory , '/handle-recover-password.php' ?>" method="POST">
      <div class="alert alert-info text-center">
        Enter the E-mail Address associated with your account below.
      </div>
      <div class="form-group">
        <label class="control-label">E-mail Address</label>
        <input type="email" name="email-address" placeholder="E-mail Address" class="form-control" required />
      </div>
      <input type="hidden" name="csrf-token" value="<?= $_SESSION['csrf_token'] ?>" />
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">Send Password Reset E-mail</button>
      </div>
    </form>
  </div>
</div>

<script src="/assets/js/handle-recover-password.js"></script>
