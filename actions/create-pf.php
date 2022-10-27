<?php
if (count($_POST) > 0 AND isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  require_once '../config.php';
  require 'auth.php';
  $name = trim($_POST['name']);
  $name = htmlspecialchars($name);
  $dob = trim($_POST['dob']);
  $dob = htmlspecialchars($dob);
  $sex = trim($_POST['sex']);
  $sex = htmlspecialchars($sex);
  $race = trim($_POST['race']);
  $race = htmlspecialchars($race);
  $marrital_status = trim($_POST['marital-status']);
  $marrital_status = htmlspecialchars($marrital_status);
  $por = trim($_POST['por']);
  $por = htmlspecialchars($por);
  $skin = trim($_POST['skin']);
  $skin = htmlspecialchars($skin);
  $query = $db->prepare("SELECT `name` FROM `ncic` WHERE `name` = :name");
  $values = ['name' => $name];
  $query->execute($values);
  $result = $query->fetchAll();
  if (count($result) > 0) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Такой человек уже есть в базе.
        </div>';
  } else if (mb_strlen($name) < 4) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткий никнейм.
        </div>';
  } else if (mb_strlen($name) > 20) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинный никнейм
        </div>';
  } else if (mb_strlen($dob) < 11) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткая дата рождения.
        </div>';
  } else if (mb_strlen($dob) > 18) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинная дата рождения.
        </div>';
  } else if ($sex != 1 AND $sex != 2 AND $sex != 3) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Некорректно выбран пол.
        </div>';
  } else if ($race != 1 AND $race != 2 AND $race != 3 AND $race != 4 AND $race != 5 AND $race != 6) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Некорректно выбрана раса.
        </div>';
  } else if ($marrital_status != 1 AND $marrital_status != 2 AND $marrital_status != 3) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Некорректно выбрано семейное положение.
        </div>';
  } else if (mb_strlen($por) > 100) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинное место проживания.
        </div>';
  } else if (mb_strlen($por) < 4) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткое место проживания.
        </div>';
  } else if (mb_strlen($skin) > 3) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинный ID скина.
        </div>';
  } else if (!is_numeric($skin)) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          В поле "ID скина" писать только цифры.
        </div>';
  } else {
    if ($marrital_status == 1) {
      $marrital_status = 'Неизвестно';
    } else if ($marrital_status == 2) {
      $marrital_status = 'Женат (-замужем)';
    } else if ($marrital_status == 3) {
      $marrital_status = 'Не женат (-не замужем)';
    }
    if ($race == 1) {
      $race = 'Неизвестно';
    } else if ($race == 2) {
      $race = 'Белый / Европеоид';
    } else if ($race == 3) {
      $race = 'Афроамериканец';
    } else if ($race == 4) {
      $race = 'Латиноамериканец';
    } else if ($race == 5) {
      $race = 'Араб';
    } else if ($race == 6) {
      $race = 'Азиат';
    }
    if ($sex == 1) {
      $sex = 'Неизвестно';
    } else if ($sex == 2) {
      $sex = 'Мужской';
    } else if ($sex == 3) {
      $sex = 'Женский';
    }
    $query = $db->prepare("SELECT CONCAT(`username`, ' ', `identifier`) AS unit FROM `users` WHERE `id` = :user_id");
    $values = ['user_id' => $session_user_id];
    $query->execute($values);
    $result = $query->fetch();
    $query = $db->prepare("INSERT INTO `ncic` (`name`, `dob`, `sex`, `race`, `marrital_status`, `por`, `skin`, `creator`) VALUES (:name, :dob, :sex, :race, :marrital_status, :por, :skin, :creator)");
    $values = ['name' => $name, 'dob' => $dob, 'sex' => $sex, 'race' => $race, 'marrital_status' => $marrital_status, 'por' => $por, 'skin' => $skin, 'creator' => $result['unit']];
    $query->execute($values);
    echo 'ok';
  }
  $db = null;
} else {
  header("Location: /");
  die();
} ?>
