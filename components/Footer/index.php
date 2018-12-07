<?php
  $currentDirectory = __DIR__;
  require_once($currentDirectory . '/../../includes/EnvSetup.php');

  $productName = getenv('PRODUCT_NAME');
  $currentYear = date('Y');
?>

<footer class="footer">
  <div class="container">
    <div class="text-center">
      <span class="text-muted">
        &copy; <?php echo($currentYear . ' ' . $productName); ?>. All Rights Reserved.
      </span>
    </div>
  </div>
</footer>
