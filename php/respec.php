<?php
  require_once '../settings.php';
  include_once '../lib/stats.php';
  require '../vendor/autoload.php';


  if (session_status() != 2) {
    session_start();
  }

  $user = $_SESSION['user'];

  $curr = get_current_character_data($user);
  $new = get_character_data($user);

  if ($curr == $new) {
    $errorText = "Вы не внесли изменений в характеристики и навыки!";
  }

  $errorText = validate($new);

  if ($user[$RESPECS_COLUMN] <= 0) {
    $errorText = "У Вас нет доступных перераспределений!";
  }

  if (strcmp($errorText, '') == 0) {
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

    $new[$RESPECS_COLUMN]--;
    $user[$RESPECS_COLUMN]--;

    $collection->updateOne(['_id' => $user['_id']], ['$set' => $new]);
  } else {
    $_SESSION['error'] = $errorText;
    echo $errorText;
  }

  $_SESSION['user'] = get_user_stats($user, $new);

  header("Location: ../index.php");
