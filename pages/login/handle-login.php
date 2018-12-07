<?php
  require_once('../../includes/DBConnection.php');
  require_once('../../includes/LoginFunctions.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    // Validate Email Address
    $emailAddress = filter_input(INPUT_POST, 'email-address', FILTER_SANITIZE_EMAIL);
    if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL))
    {
      echo('The email address you entered is not valid.');
      exit;
    }

    $csrfFormToken = filter_input(INPUT_POST, 'csrf-token', FILTER_SANITIZE_STRING);
    $sessionCsrfToken = $_SESSION['csrf_token'];

    // Verify the CSRF Token is correct
    if ($csrfFormToken != $sessionCsrfToken)
    {
      echo('Invalid Csrf Token!');
      exit;
    }

    $password = filter_input(INPUT_POST, 'hashed-password', FILTER_SANITIZE_STRING);

    $connection = createDBConnection();
    login($emailAddress, $password, $connection);

    header('Location: ../dashboard');
    exit;
  }
