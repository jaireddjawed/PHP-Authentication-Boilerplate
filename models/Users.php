<?php
  require_once(dirname(__FILE__) . '/../helpers/db-connection.php');

  $sql = '
    CREATE TABLE `users` (
      `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `first_name` VARCHAR(30) NOT NULL,
      `last_name` VARCHAR(30) NOT NULL,
      `email_address` VARCHAR(50),
      `password` CHAR(128) NOT NULL,
      `salt` char(128) NOT NULL,
      `created_at` TIMESTAMP
    );
  ';

  if ($connection->query($sql) === true) {
    echo('Users table created successfully!');
  } else {
    echo('Error creating table: ' . $connection->error);
  }
