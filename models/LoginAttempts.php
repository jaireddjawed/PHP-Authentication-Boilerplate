<?php
  require_once(dirname(__FILE__) . '/../helpers/db-connection.php');

  $sql = '
    CREATE TABLE `login_attempts` (
      `user_id` INT(11) NOT NULL,
      `time` TIMESTAMP
    );
  ';

  if ($connection->query($sql) === true) {
    echo('Login Attempts table created successfully!');
  } else {
    echo('Error creating table: ' . $connection->error);
  }
