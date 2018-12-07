<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  function checkAuthStatus($connection)
  {
    $isLoggedIn = isset(
      $_SESSION['user_id'],
      $_SESSION['email_address'],
      $_SESSION['login_string']);

    if ($isLoggedIn)
    {
      $userId = $_SESSION['user_id'];
      $emailAddress = $_SESSION['email_address'];
      $loginString = $_SESSION['login_string'];

      $userBrowser = $_SERVER['HTTP_USER_AGENT'];
      $userStmt = 'SELECT `password` FROM `users` WHERE `id` = ? LIMIT 1';
      $userStmt = $connection->prepare($userStmt);

      // Bind userId to parameter
      $userStmt->bind_param('i', $userId);
      $userStmt->execute();
      $userStmt->store_result();

      if ($userStmt->num_rows == 1)
      {
        $userStmt->bind_result($password);
        $userStmt->fetch();

        $loginCheck = hash('sha512', $password . $userBrowser);

        // The User Is Logged in
        if ($loginCheck == $loginString) {
          return true;
        }
      }
    }

    // Not Logged in
    return false;
  }

  function checkLoginAttempts($userId, $connection)
  {
    $currentTime = time();
    $currentNumAttempts = $currentTime - (2 * 60 * 60);

    $loginAttemptStmt = 'SELECT `time` FROM  `login_attempts` WHERE `user_id` = ? AND `time` > "$currentNumAttempts" LIMIT 1';
    $loginAttemptStmt = $connection->prepare($loginAttemptStmt);

    if (!$loginAttemptStmt) {
      echo('Could not get the number of login attempts.');
      exit;
    }

    $loginAttemptStmt->bind_param('i', $userId);
    $loginAttemptStmt->execute();
    $loginAttemptStmt->store_result();

    return $loginAttemptStmt->num_rows > 5;
  }

  function login($emailAddress, $password, $connection)
  {
    $userStmt = 'SELECT `id`, `password`, `salt` FROM `users` WHERE `email_address` = ? LIMIT 1';
    $userStmt = $connection->prepare($userStmt);
    $userStmt->bind_param('s', $emailAddress);
    $userStmt->execute();
    $userStmt->store_result();

    // Set variables from result
    $userStmt->bind_result($userId, $dbPassword, $salt);
    $userStmt->fetch();

    // Hash the user entered password with the salt
    $password = hash('sha512', $password . $salt);

    if ($userStmt->num_rows != 1)
    {
      echo('User not found.');
      exit;
    }

    $loginAttempts = checkLoginAttempts($userId, $connection);

    if ($loginAttempts >= 5)
    {
      echo('Your account has been locked because of too many login attempts. Please wait 2 hours before trying again.');
      exit;
    }

    // The password entered is correct
    if ($password == $dbPassword)
    {
      $userBrowser = $_SERVER['HTTP_USER_AGENT'];

      // XSS protection since we may print out the user Id
      $userId = preg_replace("/[^0-9]+/", "", $userId);
      $_SESSION['user_id'] = $userId;

      $_SESSION['email_address'] = $emailAddress;
      $_SESSION['login_string'] = hash('sha512', $password . $userBrowser);

      $connection->close();
    }
    else {
      $currentTime = time();
      $loginAttemptStmt = 'INSERT INTO `login_attempts` (user_id, time) VALUES ('.$userId.', '.$currentTime.')';
      $connection->query($loginAttemptStmt);
      $connection->close();

      echo('Invalid Password.');
      exit;
    }
  }

  function logout()
  {
    $_SESSION = array(); // Unset all session values
    $params = session_get_cookie_params(); // Get session parameters

    // Delete the cookie
    setcookie(session_name(),'', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

    // Destroy the session
    session_destroy();
    header('Location: ../login');
    exit;
  }
