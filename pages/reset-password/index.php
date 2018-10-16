<?php
  $currentPath = dirname(__FILE__);
  $pagetemplate = $currentPath . '/../../helpers/page-template.php';
  require_once($pagetemplate);

  if (!isset($template)) {
    $template = new PageTemplate();
    $template->pagetitle = 'Reset Password';
    $template->body = __FILE__;
    require_once($currentPath . '/../../layouts/App.php');
    exit;
  }
?>
<form>
  <div class="form-group">
    <label>New Password</label>
    <input type="password" name="new-password" placeholder="New Password" class="form-control" />
  </div>
  <div class="form-group">
    <label>New Password</label>
    <input type="password" name="new-password" placeholder="New Password" class="form-control" />
  </div>
  <div class="form-group">
    <button type="submit" class="btn btn-success">Reset Password &amp; Login</button>
  </div>
</form>
