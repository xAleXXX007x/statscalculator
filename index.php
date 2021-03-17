<?php session_start(); ?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <?php
      if (!isset($_COOKIE['user'])):
    ?>
      <title>Авторизация</title>
    <?php else: ?>
      <title>Перераспределение ACES</title>
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <div class="container mt-4">
      <?php
        if (!isset($_COOKIE['user'])):
      ?>
      <h1>Авторизация</h1>
      <form action="php/login.php" method="POST">
        <input type="text" class="form-control" name="login" id="login" placeholder="Логин"><br>
        <input type="password" class="form-control" name="pass" id="pass" placeholder="Пароль"><br>
        <?php
          if (isset($_SESSION['error'])) {
            echo '<p class="text-danger">'.$_SESSION['error'].'</p>';
            unset($_SESSION['error']);
          }
        ?>
        <div class="col">
          <button class="btn btn-primary" type="submit">Войти</button>
        </div>
      </form>

      <?php else: ?>
        <p><a href="php/exit.php">Выйти</a></p>
        <?php 
          require_once './settings.php';
          include_once './lib/stats.php';
          require_once './vendor/autoload.php';
          $character = init_character($_SESSION['user'][$LOGIN_COLUMN]); 

          $freeEst = get_free_estitence($character);

          $stats = array(
            array("id" => $STAT_STR_COLUMN, "name" => "Сила"),
            array("id" => $STAT_PER_COLUMN, "name" => "Восприятие"),
            array("id" => $STAT_END_COLUMN, "name" => "Выносливость"),
            array("id" => $STAT_REF_COLUMN, "name" => "Рефлексы"),
            array("id" => $STAT_AGI_COLUMN, "name" => "Ловкость"),
            array("id" => $STAT_LCK_COLUMN, "name" => "Удача")
          );

          $skills = array(
            array("id" => $SKILL_PSY_COLUMN, "name" => "Психология"),
            array("id" => $SKILL_MNG_COLUMN, "name" => "Управление"),
            array("id" => $SKILL_THF_COLUMN, "name" => "Воровство"),
            array("id" => $SKILL_SRV_COLUMN, "name" => "Выживание"),
            array("id" => $SKILL_WRK_COLUMN, "name" => "Работа"),
            array("id" => $SKILL_BIO_COLUMN, "name" => "Биология"),
            array("id" => $SKILL_ENG_COLUMN, "name" => "Инженерия"),
            array("id" => $SKILL_MGC_COLUMN, "name" => "Магия"),
            array("id" => $SKILL_RSR_COLUMN, "name" => "Исследование"),
            array("id" => $SKILL_SMT_COLUMN, "name" => "Кузнечество"),
            array("id" => $SKILL_ARC_COLUMN, "name" => "Аркана")
          );
        ?>

        <h5 class="text-center">Доступно перераспределений: <?php echo intval($character[$RESPECS_COLUMN]); ?></h5>
        <h5 class="text-center">Свободная эститенция: <?php echo $freeEst ?></h5>

        <form action="php/respec.php" method="POST">
          <div class="form-group row">
            <div class="col">
              <h2>Характеристики</h2>
            </div>
            <div class="col">
              <h2>Навыки</h2>
            </div>
          </div>
          
          <?php for ($i = 0; $i < max(count($stats), count($skills)); ++$i) {?>
            <div class="form-group row">
            <?php
            $stat = null;
            $skill = null;

            if (array_key_exists($i, $stats)) {
              $stat = $stats[$i];
            }

            if (array_key_exists($i, $skills)) {
              $skill = $skills[$i];
            }

            if (isset($stat)) {?>
              <div class="col">
                <div class="form-group row">
                  <label for="<?php echo $stat["id"] ?>" class="col-4 col-form-label"><?php echo $stat["name"] ?>:</label>
                  <div class="col-3">
                    <input type="number" class="form-control" name="<?php echo $stat["id"] ?>" id="<?php echo $stat["id"] ?>" value="<?php echo $character[$STATS_COLUMN][$stat["id"]] ?>" min="<?php echo $STAT_MIN ?>" max="<?php echo $STAT_MAX ?>" <?php if ($character[$RESPECS_COLUMN] <= 0) { echo 'disabled'; }?>>
                  </div>
                </div>
              </div>
            <?php } else {?>
              <div class="col"></div>
            <?php }
            if (isset($skill)) {?>
              <div class="col">
                <div class="form-group row">
                  <label for="<?php echo $skill["id"] ?>" class="col-4 col-form-label"><?php echo $skill["name"] ?>:</label>
                  <div class="col-3">
                    <input type="number" class="form-control" name="<?php echo $skill["id"] ?>" id="<?php echo $skill["id"] ?>" value="<?php echo $character[$SKILLS_COLUMN][$skill["id"]] ?>" min="<?php echo $SKILL_MIN ?>" max="<?php echo $SKILL_MAX ?>" <?php if ($character[$RESPECS_COLUMN] <= 0) { echo 'disabled'; }?>>
                  </div>
                </div>
              </div>
            <?php } else { ?>
              <div class="col"></div>
            <?php } ?>
            
            </div>
          <?php } 
            if (isset($_SESSION['error'])) {
              echo '<div class="form-group row"><div class="col"><h5 class="text-center text-danger">'.$_SESSION['error'].'</h5></div></div>';
              unset($_SESSION['error']);
            }
          ?>
        
          <div class="form-group row">
            <div class="col-6">
              <div class="form-group row">
                <label for="<?php echo $PERK_COLUMN ?>" class="col-4 col-form-label">Перки:</label>
                <div class="col-3">
                  <input type="number" class="form-control" name="<?php echo $PERK_COLUMN ?>" id="<?php echo $PERK_COLUMN ?>" value="<?php echo $character[$SPECIAL_COLUMN][$PERK_COLUMN] ?>" min="<?php echo $PERK_MIN ?>" max="<?php echo $PERK_MAX ?>" <?php if ($character[$RESPECS_COLUMN] <= 0) { echo 'disabled'; }?>>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <div class="col px-0">
              <button class="btn btn-primary btn-lg btn-block mt-2" type="submit" <?php if ($character[$RESPECS_COLUMN] <= 0) { echo 'disabled'; }?>>Сохранить</button>
            </div>
          </div>
        </form>
      <?php endif; ?>
    </div>
  </body>
</html>
