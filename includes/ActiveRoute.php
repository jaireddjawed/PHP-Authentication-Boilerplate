<?php

  function activeRoute($routeName)
  {
    $currentFileName = basename($_SERVER['REQUEST_URI'], '.php');
    if ($currentFileName === $routeName)
    {
      echo 'active';
    }
  }
