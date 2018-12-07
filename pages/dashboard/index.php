<?php
  require_once('../../includes/PageTemplate.php');
  require_once('../../includes/LoginFunctions.php');

  if (!isset($template))
  {
    $template = new PageTemplate();
    $template->pagetitle = 'Dashboard';
    $template->body = __FILE__;

    require('../../layouts/App/index.php');
    exit;
  }

  $connection = createDBConnection();
  $isLoggedIn = checkAuthStatus($connection);
?>

<?php if ($isLoggedIn) : ?>
  <div class="jumbotron">
    <h1 class="lead">Dashboard</h1>
  </div>
<?php
  else :
    header('Location: ../login');
    exit;
  endif
?>
