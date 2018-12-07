<?php
  require_once('../includes/DBConnection.php');

  $connection = createDBConnection();
  $sql = '
    CREATE TABLE `password_resets` (
      `user_id` INT(11) NOT NULL,
      `token` VARCHAR(32) NOT NULL
    );
  ';

  if ($connection->query($sql) == true)
  {
    echo('Password resets table created successfully!');
  }
  else {
    echo('Error creating table: ' . $connection->error);
  }
