<?php
  require_once '../settings.php';

  unset($_COOKIE['user']);
  setcookie('user', null, -1, '/');
  session_abort();

  header("Location: ../index.php");
