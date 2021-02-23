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
    $STAT_MIN = $GLOBALS['STAT_MIN'];
    $STAT_MAX = $GLOBALS['STAT_MAX'];
    $SKILL_MIN = $GLOBALS['SKILL_MIN'];
    $SKILL_MAX = $GLOBALS['SKILL_MAX'];
    $EST_COLUMN = $GLOBALS['EST_COLUMN'];
    $SKILL_COST = $GLOBALS['SKILL_COST'];
    $PERK_COLUMN = $GLOBALS['PERK_COLUMN'];

    $est = intval($characterData[$EST_COLUMN]);
    $estSum = 0;

    foreach($stats as $stat) {
      $statValue = intval($characterData[$stat]);

      if ($statValue < $STAT_MIN) {
        return "Характеристика {$stat} меньше минимума в {$STAT_MIN}.";
      }

      if ($statValue > $STAT_MAX) {
        return "Характеристика {$stat} больше максимума в {$STAT_MAX}.";
      }

      $estSum += $statValue;
    }

    foreach($skills as $skill) {
      $skillValue = intval($characterData[$skill]);

      if ($skillValue < $SKILL_MIN) {
        return "Навык {$skill} меньше минимума в {$SKILL_MIN}.";
      }

      if ($skillValue > $SKILL_MAX) {
        return "Навык {$skill} больше максимума в {$SKILL_MAX}.";
      }

      $estSum += $SKILL_COST[intval($skillValue)];
    }

    $estSum += intval($characterData[$PERK_COLUMN]);

    if ($estSum > $est) {
      $diff = $estSum - $est;
      return "Доступно эститенции: {$est}, затрачено: {$estSum}. Превышение на {$diff}";
    }

    return '';
  }

  
  function get_free_estitence($user) {
    global $stats, $skills;
    $EST_COLUMN = $GLOBALS['EST_COLUMN'];
    $SKILL_COST = $GLOBALS['SKILL_COST'];
    $PERK_COLUMN = $GLOBALS['PERK_COLUMN'];

    $characterData = get_current_character_data($user);
    $est = intval($characterData[$EST_COLUMN]);
    $estSum = 0;

    foreach($stats as $stat) {
      $statValue = intval($characterData[$stat]);

      $estSum += $statValue;
    }

    foreach($skills as $skill) {
      $skillValue = intval($characterData[$skill]);

      $estSum += $SKILL_COST[intval($skillValue)];
    }

    $estSum += intval($characterData[$PERK_COLUMN]);

    return $est - $estSum;
  }

  function get_current_character_data($user) {
    global $stats, $skills;
    $EST_COLUMN = $GLOBALS['EST_COLUMN'];
    $PERK_COLUMN = $GLOBALS['PERK_COLUMN'];

    $characterData = array();
    $characterData[$EST_COLUMN] = $user[$EST_COLUMN];

    foreach ($stats as $stat) {
      $characterData[$stat] = $user[$stat];
    }

    foreach ($skills as $skill) {
      $characterData[$skill] = $user[$skill];
    }

    $characterData[$PERK_COLUMN] = $user[$PERK_COLUMN];

    return $characterData;
  }

  function get_character_data($user) {
    global $stats, $skills;
    $EST_COLUMN = $GLOBALS['EST_COLUMN'];
    $PERK_COLUMN = $GLOBALS['PERK_COLUMN'];

    $characterData = array();
    $characterData[$EST_COLUMN] = $user[$EST_COLUMN];

    foreach ($stats as $stat) {
      $characterData[$stat] = $_POST[$stat];
    }

    foreach ($skills as $skill) {
      $characterData[$skill] = $_POST[$skill];
    }

    $characterData[$PERK_COLUMN] = $_POST[$PERK_COLUMN];

    return $characterData;
  }

  function get_user_stats($user, $characterData) {
    global $stats, $skills;
    $PERK_COLUMN = $GLOBALS['PERK_COLUMN'];

    foreach ($stats as $stat) {
      $user[$stat] = $characterData[$stat];
    }

    foreach ($skills as $skill) {
      $user[$skill] = $characterData[$skill];
    }

    $user[$PERK_COLUMN] = $characterData[$PERK_COLUMN];

    return $user;
  }
