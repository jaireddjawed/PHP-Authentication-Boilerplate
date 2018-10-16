<?php
    $layoutPath = dirname(__FILE__); ?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php if(isset($template->pagetitle)) { print $template->pagetitle; } ?></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
        <style><?php require($layoutPath . '/../public/css/footer.css'); ?></style>
        <script><?php require($layoutPath . '/../public/js/sha512.js'); ?></script>
    </head>
    <body>
        <div class="container">
            <?php
                if(isset($template->body)) {
                    require($template->body);
                }
            ?>
        </div>
        <?php require($layoutPath . '/../components/footer.php'); ?>
    </body>
</html>
