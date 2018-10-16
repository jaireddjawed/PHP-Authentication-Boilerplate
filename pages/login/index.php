<?php
  $currentPath = dirname(__FILE__);
  $pagetemplate = $currentPath . '/../../helpers/page-template.php';
  require_once($pagetemplate);

  if (!isset($template)) {
    $template = new PageTemplate();
    $template->pagetitle = 'Login';
    $template->body = __FILE__;
    require_once($currentPath . '/../../layouts/App.php');
    exit;
  }
?>
<form>
  <div class="form-group">
    <label>E-mail Address</label>
    <input type="email" name="email-address" placeholder="E-mail Address" class="form-control" />
  </div>
  <div class="form-group">
    <label>Password</label>
    <input type="password" name="password" placeholder="Password" class="form-control" />
  </div>
  <div class="form-group">
    <button type="submit" class="btn btn-success">Login</button>
  </div>
</form>
