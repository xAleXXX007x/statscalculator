<?php
  require_once '../settings.php';

  unset($_COOKIE['user']);
  setcookie('user', null, -1, '/');

  header("Location: ../index.php");
