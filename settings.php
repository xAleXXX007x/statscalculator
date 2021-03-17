<?php
  $GLOBALS['MONGODB_ADDRESS'] = "localhost";
  $GLOBALS['MONGODB_USER'] = "";
  $GLOBALS['MONGODB_PASSWORD'] = "";
  $GLOBALS['MONGODB_NAME'] = "users";

  $GLOBALS['DB_ADDRESS'] = "localhost:3307";
  $GLOBALS['DB_USER'] = "root";
  $GLOBALS['DB_PASSWORD'] = "";
  $GLOBALS['DB_NAME'] = "users";

  $GLOBALS['COOKIE_TIME'] = 3600 * 24 * 365;

  $GLOBALS['USERS_TABLE'] = "users";
  $GLOBALS['LOGIN_COLUMN'] = "user_login";
  $GLOBALS['PASSWORD_COLUMN'] = "user_password";
  $GLOBALS['BANNED_COLUMN'] = "banned";

  $GLOBALS['CHARACTER_COLUMN'] = "character";

  $GLOBALS['RESPECS_COLUMN'] = "re-specs";

  $GLOBALS['SPECIAL_COLUMN'] = "special_stats";
  $GLOBALS['EST_COLUMN'] = "est";
  $GLOBALS['PERK_COLUMN'] = "extra_perk_points";
  $GLOBALS['STATS_COLUMN'] = "attributes";
  $GLOBALS['STAT_STR_COLUMN'] = "STR";
  $GLOBALS['STAT_PER_COLUMN'] = "PER";
  $GLOBALS['STAT_END_COLUMN'] = "END";
  $GLOBALS['STAT_REF_COLUMN'] = "REF";
  $GLOBALS['STAT_AGI_COLUMN'] = "AGI";
  $GLOBALS['STAT_LCK_COLUMN'] = "LUCK";

  $GLOBALS['SKILLS_COLUMN'] = "skills";
  $GLOBALS['SKILL_PSY_COLUMN'] = "Psychology";
  $GLOBALS['SKILL_MNG_COLUMN'] = "Management";
  $GLOBALS['SKILL_THF_COLUMN'] = "Thievery";
  $GLOBALS['SKILL_SRV_COLUMN'] = "Survival";
  $GLOBALS['SKILL_WRK_COLUMN'] = "Hardworking";
  $GLOBALS['SKILL_BIO_COLUMN'] = "Biology";
  $GLOBALS['SKILL_ENG_COLUMN'] = "Engineering";
  $GLOBALS['SKILL_MGC_COLUMN'] = "Magic";
  $GLOBALS['SKILL_RSR_COLUMN'] = "Research";
  $GLOBALS['SKILL_SMT_COLUMN'] = "Blacksmith";
  $GLOBALS['SKILL_ARC_COLUMN'] = "Magical";

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
