<?php
  require_once(__DIR__ . '/../vendor/autoload.php');

  if (!isset($dotEnv))
  {
    $dotEnv = new Dotenv\Dotenv(__DIR__ . '/../'); # since our .env file is one directory upward
    $dotEnv->load();
  }
