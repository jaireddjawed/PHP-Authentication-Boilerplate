<?php
  session_start();

  function setCsrfToken()
  {
    if (!isset($_SESSION['csrf_token']))
    {
      $csrfToken = bin2hex(random_bytes(32)); // generate a random token for our forms to prevent csrf attacks
      $_SESSION['csrf_token'] = $csrfToken;
    }
  }

  setCsrfToken();
