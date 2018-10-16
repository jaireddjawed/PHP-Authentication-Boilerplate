<?php
  $servername = "localhost";
  $username = "admin";
  $password = "yhmgTWsCJh7vUkCb";
  $dbname = "secure_login";

  $connection = new mysqli($servername, $username, $password, $dbname);

  if ($connection->connect_error) {
    echo('Error connecting to database: ' . $connection->connect_error);
    exit();
}
