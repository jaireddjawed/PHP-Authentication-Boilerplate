<?php
  require_once(dirname(__FILE__) . '/../helpers/db-connection.php');

  $error_msg = '';

  if (isset($_POST['submit'])) {
    $firstname = filter_input(INPUT_POST, 'first-name', FILTER_SANITIZE_STRING);
    $lastname = filter_input(INPUT_POST, 'last-name', FILTER_SANITIZE_STRING);

    $emailaddress = filter_input(INPUT_POST, 'email-address', FILTER_SANITIZE_EMAIL);
    $emailaddress = filter_var($emailaddress, FILTER_VALIDATE_EMAIL);

    if (!$emailaddress) {
      $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }

    $hashedpassword = filter_input(INPUT_POST, 'hashed-password', FILTER_SANITIZE_STRING);

    if (strlen($hashedpassword) != 128) {
      // The hashed pwd should be 128 characters long.
      // If it's not, something really odd has happened
      $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }

    $usertimestamp = date('Y-m-d G:i:s');

    $prep_stmt = 'SELECT id FROM `users` WHERE `email_address` = ? LIMIT 1';
    $stmt = $connection->prepare($prep_stmt);
    $stmt->bind_param('s', $emailaddress);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
      // A user with this email address already exists
      $error_msg .= '<p class="error">A user with this email address already exists.</p>';
    }

    $stmt->close();

    if (empty($error_msg)) {
      $randomsalt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
      $saltedpassword = hash('sha512', $hashedpassword . $randomsalt);

      $insertstmt = $connection->prepare('INSERT INTO `users` (first_name, last_name, email_address, password, salt, created_at) VALUES (?, ?, ?, ?, ?, ?)');

      if ($insertstmt) {
        $insertstmt->bind_param('ssssss', $firstname, $lastname, $emailaddress, $hashedpassword, $randomsalt, $usertimestamp);

        if (!$insertstmt->execute()) {
          echo('Error creating user!');
          exit();
        }
      }

      header('Location: ../pages/home.php');
      exit();
    }
  }

