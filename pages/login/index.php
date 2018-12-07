<?php
  require_once('../../includes/PageTemplate.php');
  require_once('../../includes/CsrfToken.php');

  require_once('../../includes/DBConnection.php');
  require_once('../../includes/LoginFunctions.php');

  $currentDirectory = '/pages/' . basename(__DIR__);

  if (!isset($template))
  {
    $template = new PageTemplate();
    $template->pagetitle = "Login";
    $template->body = __FILE__;

    require('../../layouts/App/index.php');
    exit;
  }
?>

<div class="row">
  <div class="col-xs-12 col-lg-6">
    <h3 class="page-header">Login</h3>
    <form action="<?= $currentDirectory , '/handle-login.php' ?>" method="POST">
      <div class="form-group">
        <label class="control-label">E-mail Address</label>
        <input type="email" name="email-address" placeholder="E-mail Address" class="form-control" required />
      </div>
      <div class="form-group">
        <label class="control-label">Password</label>
        <a href="/pages/recover-password" class="pull-right">Forgot Password?</a>
        <input type="password" name="password" placeholder="Password" class="form-control" required />
      </div>
      <input type="hidden" name="csrf-token" value="<?= $_SESSION['csrf_token'] ?>" />
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">Login</button>
      </div>
    </form>
  </div>
</div>

<script src="/assets/js/sha512.js"></script>
<script src="/assets/js/handle-login.js"></script>
