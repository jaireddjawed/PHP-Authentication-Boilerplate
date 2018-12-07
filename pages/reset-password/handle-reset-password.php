<?php
  require_once('../../includes/DBConnection.php');

  class ResetPassword
  {
    private $passwordToken;
    private $newPassword;
    private $connection;

    public function __construct($passwordToken, $newPassword)
    {
      $this->connection = createDBConnection();

      $this->passwordToken = $passwordToken;
      $this->newPassword = $newPassword;
    }

    public function __destruct()
    {
      $this->connection->close();
    }

    public function getUserIdFromToken()
    {
      $userStmt = 'SELECT `user_id` FROM `password_resets` WHERE `token` = ? LIMIT 1';
      $userStmt = $this->connection->prepare($userStmt);

      $userStmt->bind_param('s', $this->passwordToken);
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

    public function resetUserPassword()
    {
      // Get userId from database
      $userId = $this->getUserIdFromToken();

      // create random salt and salted password
      $randomSalt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
      $saltedPassword = hash('sha512', $this->newPassword . $randomSalt);

      $resetPasswordStmt = 'UPDATE `users` SET `password` = ?, `salt` = ? WHERE `id` = ?';
      $resetPasswordStmt = $this->connection->prepare($resetPasswordStmt);
      $resetPasswordStmt->bind_param('sss', $saltedPassword, $randomSalt, $userId);

      if (!$resetPasswordStmt->execute())
      {
        echo('Error resetting password!');
        exit;
      }
    }

    public function removeTokenFromDatabase()
    {
      $removePasswordResetStmt = 'DELETE FROM `password_resets` WHERE `token` = ?';
      $removePasswordResetStmt = $this->connection->prepare($removePasswordResetStmt);
      $removePasswordResetStmt->bind_param('s', $this->passwordToken);
      $removePasswordResetStmt->execute();
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $passwordToken = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    $newPassword = filter_input(INPUT_POST, 'hashed-password', FILTER_SANITIZE_STRING);

    $resetPassword = new ResetPassword($passwordToken, $newPassword);
    $resetPassword->resetUserPassword();
    $resetPassword->removeTokenFromDatabase();

    header('Location: ../login');
    exit;
  }
