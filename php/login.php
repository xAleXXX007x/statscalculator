<?php
  require_once '../settings.php';

  session_start();

  $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
  $password = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

  $mysql = new mysqli($DB_ADDRESS, $DB_USER, $DB_PASSWORD, $DB_NAME);

  if($mysql) {
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $result = $mysql->query("SELECT * FROM `$USERS_TABLE` WHERE `$LOGIN_COLUMN` = '$login'");
    $mysql->close();

    if($result) {
      $user = $result->fetch_assoc();
  
      $errorText = '';
      
      if ($user && $result->num_rows == 0 || !password_verify($password, $user[$PASSWORD_COLUMN])) {
        $errorText = 'Неверный логин или пароль';
      }
  
      if ($user && $user[$BANNED_COLUMN] != 0) {
        $errorText = 'Вы забанены!';
      }
  
      if ($user and strcmp($errorText, '') == 0) {
        setcookie('user', $user['id'], time() + $COOKIE_TIME, '/');
        $_SESSION['user'] = $user;
      } else {
        $_SESSION['error'] = $errorText;
      }
  
      header("Location: ../index.php");
    } else {
      echo "Ошибка MySQL запроса";
    }
  } else {
    echo "Ошибка подключения к БД";
  }
