<?php
  $GLOBALS['DB_ADDRESS'] = "localhost";
  $GLOBALS['DB_USER'] = "";
  $GLOBALS['DB_PASSWORD'] = "";
  $GLOBALS['DB_NAME'] = "users";

  $GLOBALS['COOKIE_TIME'] = 3600 * 24 * 365;

  $GLOBALS['USERS_TABLE'] = "users";
  $GLOBALS['LOGIN_COLUMN'] = "user_login";
  $GLOBALS['PASSWORD_COLUMN'] = "user_password";
  $GLOBALS['BANNED_COLUMN'] = "banned";

  $GLOBALS['RESPECS_COLUMN'] = "respecs";

  $GLOBALS['EST_COLUMN'] = "estitence";
  $GLOBALS['PERK_COLUMN'] = "perk";
  $GLOBALS['STAT_STR_COLUMN'] = "strength";
  $GLOBALS['STAT_PER_COLUMN'] = "perception";
  $GLOBALS['STAT_END_COLUMN'] = "endurance";
  $GLOBALS['STAT_REF_COLUMN'] = "reflexes";
  $GLOBALS['STAT_AGI_COLUMN'] = "agility";
  $GLOBALS['STAT_LCK_COLUMN'] = "luck";

  $GLOBALS['SKILL_PSY_COLUMN'] = "psychology";
  $GLOBALS['SKILL_MNG_COLUMN'] = "management";
  $GLOBALS['SKILL_THF_COLUMN'] = "thievery";
  $GLOBALS['SKILL_SRV_COLUMN'] = "survival";
  $GLOBALS['SKILL_WRK_COLUMN'] = "work";
  $GLOBALS['SKILL_BIO_COLUMN'] = "biology";
  $GLOBALS['SKILL_ENG_COLUMN'] = "engineering";
  $GLOBALS['SKILL_MGC_COLUMN'] = "magic";
  $GLOBALS['SKILL_RSR_COLUMN'] = "research";
  $GLOBALS['SKILL_SMT_COLUMN'] = "smithing";
  $GLOBALS['SKILL_ARC_COLUMN'] = "arcane";

  $GLOBALS['STAT_MIN'] = 0;
  $GLOBALS['STAT_MAX'] = 25;
  $GLOBALS['SKILL_MIN'] = 0;
  $GLOBALS['SKILL_MAX'] = 3;
  $GLOBALS['SKILL_COST'] = array(
    0 => 0,
    1 => 3,
    2 => 7,
    3 => 12,
  );

  $GLOBALS['PERK_MIN'] = 0;
  $GLOBALS['PERK_MAX'] = 120;
?>
