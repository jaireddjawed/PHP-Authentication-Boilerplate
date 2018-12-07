<?php
  require_once('../../includes/PageTemplate.php');
  require_once('../../includes/CsrfToken.php');

  $currentDirectory = '/pages/' . basename(__DIR__);

  if (!isset($template))
  {
    $template = new PageTemplate();
    $template->pagetitle = "Signup";
    $template->body = __FILE__;

    require('../../layouts/App/index.php');
    exit;
  }
?>

<div class="row">
  <div class="col-xs-12 col-lg-6">
    <h3 class="page-header">Signup</h3>
    <form action="<?= $currentDirectory . '/handle-signup.php' ?>" method="POST">
      <div class="row">
        <div class="col-xs-12 col-md-6">
          <div class="form-group">
            <label class="control-label">First Name</label>
            <input type="text" name="first-name" placeholder="First Name" class="form-control" required />
          </div>
        </div>
        <div class="col-xs-12 col-md-6">
          <div class="form-group">
            <label class="control-label">Last Name</label>
            <input type="text" name="last-name" placeholder="Last Name" class="form-control" required />
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label">E-mail Address</label>
        <input type="email" name="email-address" placeholder="E-mail Address" class="form-control" required />
      </div>
      <div class="form-group">
        <label class="control-label">Password</label>
        <input type="password" name="password" placeholder="Password" class="form-control" required />
      </div>
      <input type="hidden" name="csrf-token" value="<?= $_SESSION['csrf_token'] ?>" />
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">Signup</button>
      </div>
    </form>
  </div>
</div>

<script src="/assets/js/sha512.js"></script>
<script src="/assets/js/handle-signup.js"></script>
