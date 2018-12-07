<?php
  require_once(__DIR__ . '/EnvSetup.php');

  function createDBConnection()
  {
    $serverName = getenv('SERVER_NAME');
    $userName = getenv('USER_NAME');
    $password = getenv('PASSWORD');
    $dbName = getenv('DB_NAME');

    $connection = new mysqli($serverName, $userName, $password, $dbName);

    if ($connection->connect_error)
    {
      echo('Error connecting to database: '. $connection->connect_error);
      exit;
    }

    return $connection;
  }
