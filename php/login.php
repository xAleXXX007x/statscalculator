<?php
  require_once '../settings.php';
  require '../vendor/autoload.php';

  session_start();

  $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
  $password = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

  $dbLogin = '';

  if (strcmp($DB_USER, '') != 0) {
    $dbLogin = $DB_USER;

    if (strcmp($DB_PASSWORD, '') != 0) {
      $dbLogin = $dbLogin.':'.$DB_PASSWORD;
    }

    $dbLogin = $dbLogin.'@';
  }

  $client = new MongoDB\Client("mongodb://{$dbLogin}{$DB_ADDRESS}");
  $collection = $client->$DB_NAME->$USERS_TABLE;

  if($collection) {
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $result = $collection->find(array($LOGIN_COLUMN => $login));
    $user = array();

    foreach ($result as $row) {
      foreach ($row as $key => $value) {
        $user[$key] = $value;
      }
    }

    var_dump($user);

    $errorText = '';
    
    if (!$user or !password_verify($password, $user[$PASSWORD_COLUMN])) {
      $errorText = 'Неверный логин или пароль';
    }

    if ($user and intval($user[$BANNED_COLUMN]) != 0) {
      $errorText = 'Вы забанены!';
    }

    if ($user and strcmp($errorText, '') == 0) {
      setcookie('user', $user['_id'], time() + $COOKIE_TIME, '/');
      $_SESSION['user'] = $user;
    } else {
      $_SESSION['error'] = $errorText;
    }

    header("Location: ../index.php");
  } else {
    echo "Ошибка подключения к БД";
  }
