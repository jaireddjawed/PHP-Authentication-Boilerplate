<?php
  require_once('../../includes/DBConnection.php');
  require_once('../../includes/CsrfToken.php');

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  class CreateNewUser
  {
    private $connection;

    private $firstName;
    private $lastName;
    private $emailAddress;
    private $password;

    public function __construct($firstName, $lastName, $emailAddress, $password)
    {
      $this->connection = createDBConnection();

      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->emailAddress = $emailAddress;
      $this->password = $password;
    }

    public function __destruct()
    {
      $this->connection->close();
    }

    public function checkForExistingUserEmail()
    {
      $emailStmt = 'SELECT id FROM `users` WHERE email_address = ? LIMIT 1';
      $emailStmt = $this->connection->prepare($emailStmt);
      $emailStmt->bind_param('s', $this->emailAddress);
      $emailStmt->execute();
      $emailStmt->store_result();

      if ($emailStmt->num_rows == 1)
      {
        echo('An existing user with this email address already exists!');
        exit;
      }
      $emailStmt->close();
    }

    public function register()
    {
      // create random salt and salted password
      $randomSalt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
      $saltedPassword = hash('sha512', $this->password . $randomSalt);

      // get the date that the user is registered
      $userTimestamp = date('Y-m-d G:i:s');

      // insert the new user into the database
      $insertUserStmt = '
        INSERT INTO `users` (first_name, last_name, email_address, password, salt, created_at)
        VALUES (?, ?, ?, ?, ?, ?);
      ';
      $insertUserStmt = $this->connection->prepare($insertUserStmt);
      $insertUserStmt->bind_param('ssssss', $this->firstName, $this->lastName, $this->emailAddress, $saltedPassword, $randomSalt, $userTimestamp);

      if (!$insertUserStmt->execute())
      {
        echo('Error saving user into database!');
        exit;
      }
    }

    public function login()
    {
      $userStmt = 'SELECT `id`, `password` FROM `users` WHERE `email_address` = ? LIMIT 1';
      $userStmt = $this->connection->prepare($userStmt);
      $userStmt->bind_param('s',  $this->emailAddress);
      $userStmt->execute();
      $userStmt->store_result();

      $userStmt->bind_result($userId, $password);
      $userStmt->fetch();

      if ($userStmt->num_rows != 1)
      {
        echo('Error logging in!');
        exit;
      }

      $userBrowser = $_SERVER['HTTP_USER_AGENT'];

      $_SESSION['user_id'] = $userId;
      $_SESSION['email_address'] = $this->emailAddress;
      $_SESSION['login_string'] = hash('sha512', $password . $userBrowser);
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    // Filter first and last names
    $firstName = filter_input(INPUT_POST, 'first-name', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'last-name', FILTER_SANITIZE_STRING);

    // Validate the email address
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

    // Save the User in the database
    $newUser = new CreateNewUser($firstName, $lastName, $emailAddress, $password);
    $newUser->checkForExistingUserEmail();
    $newUser->register();
    $newUser->login();

    header('Location: ../dashboard');
    exit;
  }
