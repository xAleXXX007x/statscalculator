<?php
  $stats = array(
    $STAT_STR_COLUMN,
    $STAT_PER_COLUMN,
    $STAT_END_COLUMN,
    $STAT_REF_COLUMN,
    $STAT_AGI_COLUMN,
    $STAT_LCK_COLUMN
  );

  $skills = array(
    $SKILL_PSY_COLUMN,
    $SKILL_MNG_COLUMN,
    $SKILL_THF_COLUMN,
    $SKILL_SRV_COLUMN,
    $SKILL_WRK_COLUMN,
    $SKILL_BIO_COLUMN,
    $SKILL_ENG_COLUMN,
    $SKILL_MGC_COLUMN,
    $SKILL_RSR_COLUMN,
    $SKILL_SMT_COLUMN,
    $SKILL_ARC_COLUMN
  );

  function validate($characterData) {
    global $stats, $skills;
    $STATS_COLUMN = $GLOBALS['STATS_COLUMN'];
    $SKILLS_COLUMN = $GLOBALS['SKILLS_COLUMN'];
    $STAT_MIN = $GLOBALS['STAT_MIN'];
    $STAT_MAX = $GLOBALS['STAT_MAX'];
    $SKILL_MIN = $GLOBALS['SKILL_MIN'];
    $SKILL_MAX = $GLOBALS['SKILL_MAX'];
    $SKILL_COST = $GLOBALS['SKILL_COST'];

    $SPECIAL_COLUMN = $GLOBALS['SPECIAL_COLUMN'];
    $EST_COLUMN = $GLOBALS['EST_COLUMN'];
    $PERK_COLUMN = $GLOBALS['PERK_COLUMN'];

    $est = intval($characterData[$SPECIAL_COLUMN][$EST_COLUMN]);
    $estSum = 0;

    foreach($stats as $stat) {
      $statValue = intval($characterData[$STATS_COLUMN][$stat]);

      if ($statValue < $STAT_MIN) {
        return "Характеристика {$stat} меньше минимума в {$STAT_MIN}.";
      }

      if ($statValue > $STAT_MAX) {
        return "Характеристика {$stat} больше максимума в {$STAT_MAX}.";
      }

      $estSum += $statValue;
    }

    foreach($skills as $skill) {
      $skillValue = intval($characterData[$SKILLS_COLUMN][$skill]);

      if ($skillValue < $SKILL_MIN) {
        return "Навык {$skill} меньше минимума в {$SKILL_MIN}.";
      }

      if ($skillValue > $SKILL_MAX) {
        return "Навык {$skill} больше максимума в {$SKILL_MAX}.";
      }

      $estSum += $SKILL_COST[intval($skillValue)];
    }

    $estSum += intval($characterData[$SPECIAL_COLUMN][$PERK_COLUMN]);

    if ($estSum > $est) {
      $diff = $estSum - $est;
      return "Доступно эститенции: {$est}, затрачено: {$estSum}. Превышение на {$diff}";
    }

    return '';
  }

  
  function get_free_estitence($character) {
    global $stats, $skills;
    $STATS_COLUMN = $GLOBALS['STATS_COLUMN'];
    $SKILLS_COLUMN = $GLOBALS['SKILLS_COLUMN'];
    $SPECIAL_COLUMN = $GLOBALS['SPECIAL_COLUMN'];
    $EST_COLUMN = $GLOBALS['EST_COLUMN'];
    $SKILL_COST = $GLOBALS['SKILL_COST'];
    $PERK_COLUMN = $GLOBALS['PERK_COLUMN'];

    $characterData = get_current_character_data($character);
    $est = intval($characterData[$SPECIAL_COLUMN][$EST_COLUMN]);
    $estSum = 0;

    foreach($stats as $stat) {
      $statValue = intval($characterData[$STATS_COLUMN][$stat]);

      $estSum += $statValue;
    }

    foreach($skills as $skill) {
      $skillValue = intval($characterData[$SKILLS_COLUMN][$skill]);

      $estSum += $SKILL_COST[intval($skillValue)];
    }

    $estSum += intval($characterData[$SPECIAL_COLUMN][$PERK_COLUMN]);

    return $est - $estSum;
  }

  function get_current_character_data($character) {
    global $stats, $skills;
    $STATS_COLUMN = $GLOBALS['STATS_COLUMN'];
    $SKILLS_COLUMN = $GLOBALS['SKILLS_COLUMN'];
    $SPECIAL_COLUMN = $GLOBALS['SPECIAL_COLUMN'];
    $EST_COLUMN = $GLOBALS['EST_COLUMN'];
    $PERK_COLUMN = $GLOBALS['PERK_COLUMN'];

    $characterData = $character;
    $characterData[$SPECIAL_COLUMN][$EST_COLUMN] = intval($character[$SPECIAL_COLUMN][$EST_COLUMN]);

    foreach ($stats as $stat) {
      $characterData[$STATS_COLUMN][$stat] = intval($character[$STATS_COLUMN][$stat]);
    }

    foreach ($skills as $skill) {
      $characterData[$SKILLS_COLUMN][$skill] = intval($character[$SKILLS_COLUMN][$skill]);
    }

    $characterData[$SPECIAL_COLUMN][$PERK_COLUMN] = intval($character[$SPECIAL_COLUMN][$PERK_COLUMN]);

    return $characterData;
  }

  function get_character_data($character) {
    global $stats, $skills;
    $STATS_COLUMN = $GLOBALS['STATS_COLUMN'];
    $SKILLS_COLUMN = $GLOBALS['SKILLS_COLUMN'];
    $SPECIAL_COLUMN = $GLOBALS['SPECIAL_COLUMN'];
    $EST_COLUMN = $GLOBALS['EST_COLUMN'];
    $PERK_COLUMN = $GLOBALS['PERK_COLUMN'];

    $characterData = $character;
    $characterData[$SPECIAL_COLUMN][$EST_COLUMN] = intval($character[$SPECIAL_COLUMN][$EST_COLUMN]);

    foreach ($stats as $stat) {
      $characterData[$STATS_COLUMN][$stat] = intval($_POST[$stat]);
    }

    foreach ($skills as $skill) {
      $characterData[$SKILLS_COLUMN][$skill] = intval($_POST[$skill]);
    }

    $characterData[$SPECIAL_COLUMN][$PERK_COLUMN] = intval($_POST[$PERK_COLUMN]);

    return $characterData;
  }

  function get_character_stats($character, $characterData) {
    global $stats, $skills;
    $STATS_COLUMN = $GLOBALS['STATS_COLUMN'];
    $SKILLS_COLUMN = $GLOBALS['SKILLS_COLUMN'];
    $SPECIAL_COLUMN = $GLOBALS['SPECIAL_COLUMN'];
    $PERK_COLUMN = $GLOBALS['PERK_COLUMN'];

    foreach ($stats as $stat) {
      $character[$STATS_COLUMN][$stat] = intval($characterData[$STATS_COLUMN][$stat]);
    }

    foreach ($skills as $skill) {
      $character[$SKILLS_COLUMN][$skill] = intval($characterData[$SKILLS_COLUMN][$skill]);
    }

    $character[$SPECIAL_COLUMN][$PERK_COLUMN] = intval($characterData[$SPECIAL_COLUMN][$PERK_COLUMN]);

    return $character;
  }

  function init_character($login) {
    $MONGODB_USER = $GLOBALS['MONGODB_USER'];
    $MONGODB_PASSWORD = $GLOBALS['MONGODB_PASSWORD'];
    $MONGODB_ADDRESS = $GLOBALS['MONGODB_ADDRESS'];
    $MONGODB_NAME = $GLOBALS['MONGODB_NAME'];
    $USERS_TABLE = $GLOBALS['USERS_TABLE'];
    $CHARACTER_COLUMN = $GLOBALS['CHARACTER_COLUMN'];
    $LOGIN_COLUMN = $GLOBALS['LOGIN_COLUMN'];
    
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

    if($collection) {
      $_result = $collection->find(array($CHARACTER_COLUMN => $login));

      if($_result) {
        $character = json_decode(json_encode($_result->toArray()), true)[0];

        return $character;
      }
    }
  }
