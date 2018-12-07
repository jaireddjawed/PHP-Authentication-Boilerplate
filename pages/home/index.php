<?php
  require_once('../../includes/PageTemplate.php');

  if (!isset($template))
  {
    $template = new PageTemplate();
    $template->pagetitle = 'Home';
    $template->body = __FILE__;

    require('../../layouts/App/index.php');
    exit;
  }
?>

<div class="jumbotron text-center">
  <h1 class="lead">Welcome to Base!</h1>
  <p>A starting point for building PHP apps.</p>
</div>
