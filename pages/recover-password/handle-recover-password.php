<?php
  require_once('../../includes/DBConnection.php');
  require_once('../../includes/CsrfToken.php');
  require_once('../../includes/EnvSetup.php');

  class RecoverPassword
  {
    private $emailAddress;
    private $passwordResetToken;
    private $connection;

    public function __construct($emailAddress)
    {
      $this->connection = createDBConnection();
      $this->emailAddress = $emailAddress;
    }

    public function __destruct()
    {
      $this->connection->close();
    }

    public function setPasswordResetToken()
    {
      $passwordResetToken = bin2hex(random_bytes(32));
      $this->passwordResetToken = $passwordResetToken;
    }

    public function getUserIdFromEmailAddress()
    {
      $userStmt = 'SELECT `id` FROM `users` WHERE `email_address` = ? LIMIT 1';
      $userStmt = $this->connection->prepare($userStmt);

      $userStmt->bind_param('s', $this->emailAddress);
      $userStmt->execute();
      $userStmt->store_result();

      $userStmt->bind_result($userId);
      $userStmt->fetch();

      if ($userStmt->num_rows != 1)
      {
        echo('User not found.');
        exit;
      }

      return $userId;
    }

    public function savePasswordResetTokenInDatabase()
    {
      $userId = $this->getUserIdFromEmailAddress();
      $passwordResetStmt = 'INSERT INTO `password_resets` (user_id, token) VALUES ('.$userId.',"'.$this->passwordResetToken.'")';
      $this->connection->query($passwordResetStmt);
    }

    public function mailPasswordResetToken()
    {
      $productName = getenv('PRODUCT_NAME');
      $productEmail = getenv('PRODUCT_EMAIL');
      $productSite = getenv('PRODUCT_SITE');

      $subject = 'Password Reset Request | ' . $productName;
      $to = $this->emailAddress;

      // Set the content type since we're sending an HTML Email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      $headers = 'From: ' . $productEmail;

      $body = '
        Hello!
        Click the link below to reset your password:
        '.$productSite.'/pages/reset-password/?token='.$this->passwordResetToken.'>Reset Your Password
        Thanks!
      ';

      mail($to, $subject, $body, $headers);
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    // Validate the email address
    $emailAddress = filter_input(INPUT_POST, 'email-address', FILTER_SANITIZE_EMAIL);
    if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL))
    {
      echo('The email address you entered is not valid.');
      exit;
    }

    $recoverPassword = new RecoverPassword($emailAddress);
    $recoverPassword->setPasswordResetToken();
    $recoverPassword->savePasswordResetTokenInDatabase();
    $recoverPassword->mailPasswordResetToken();

    header('Location: ../login');
    exit;
  }
