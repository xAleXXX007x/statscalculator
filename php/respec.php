<?php
  require_once '../settings.php';
  include_once '../lib/stats.php';
  require '../vendor/autoload.php';

  if (session_status() != 2) {
    session_start();
  }

  $character = $_SESSION['character'];

  $curr = get_current_character_data($character);
  $new = get_character_data($character);

  $errorText = validate($new);

  if ($curr == $new) {
    $errorText = "Вы не внесли изменений в характеристики и навыки!";
  }

  if ($character[$RESPECS_COLUMN] <= 0) {
    $errorText = "У Вас нет доступных перераспределений!";
  }

  if (strcmp($errorText, '') == 0) {
    $dbLogin = '';

    if (strcmp($MONGODB_USER, '') != 0) {
      $dbLogin = $MONGODB_USER;
  
      if (strcmp($MONGODB_PASSWORD, '') != 0) {
        $dbLogin = $dbLogin.':'.$MONGODB_PASSWORD;
      }
  
      $dbLogin = $dbLogin.'@';
    }
  
    $client = new MongoDB\Client("mongodb://{$dbLogin}{$MONGODB_ADDRESS}");
    $collection = $client->$MONGODB_NAME->$USERS_TABLE;

    $new[$RESPECS_COLUMN]--;
    $character[$RESPECS_COLUMN]--;

    $collection->updateOne(['_id' => $character['_id']], ['$set' => $new]);
  } else {
    $_SESSION['error'] = $errorText;
    echo $errorText;
  }

  $_SESSION['character'] = get_character_stats($character, $new);

  header("Location: ../index.php");
