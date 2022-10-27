<?php
if (count($_POST) > 0 AND isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  require_once '../config.php';
  require 'auth.php';
  date_default_timezone_set('Europe/Moscow');
  $time = time();
  if (isset($_POST['model'])) {
  $model = trim($_POST['model']);
  $model = htmlspecialchars($model);
  $color = trim($_POST['color']);
  $color = htmlspecialchars($color);
  $number = trim($_POST['number']);
  $number = htmlspecialchars($number);
  $features = trim($_POST['features']);
  $features = htmlspecialchars($features);
  $last_place = trim($_POST['last-place']);
  $last_place = htmlspecialchars($last_place);
  $last_date = trim($_POST['last-date']);
  $last_date = htmlspecialchars($last_date);
  $reason = trim($_POST['reason']);
  $reason = htmlspecialchars($reason);
  $bolo_id = htmlspecialchars($_POST['edit-vehicle-bolo-id']);
  if (mb_strlen($model) > 20) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком большое название марки.
        </div>';
  } else if (mb_strlen($model) < 4) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткое название марки.
        </div>';
  } else if (mb_strlen($color) > 15) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинное название цвета.
        </div>';
  } else if (mb_strlen($color) < 5) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткое название цвета.
        </div>';
  } else if (mb_strlen($number) > 20) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинные номера.
        </div>';
  } else if (mb_strlen($number) < 4) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткие номера.
        </div>';
  } else if (mb_strlen($features) > 85) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинные особенности автомобиля.
        </div>';
  } else if (mb_strlen($features) < 5) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткие особенности автомобиля.
        </div>';
  } else if (mb_strlen($last_place) > 25) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинное название места последнего обнаружения.
        </div>';
  } else if (mb_strlen($last_place) < 5) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткое название места последнего обнаружения.
        </div>';
  } else if (mb_strlen($last_date) > 20) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинная дата последнего  обнаружения.
        </div>';
  } else if (mb_strlen($last_date) < 5) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткая дата последнего обнаружения.
        </div>';
  } else if (mb_strlen($reason) > 30) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинная причина розыска.
        </div>';
  } else if (mb_strlen($reason) < 5) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткая причина розыска.
        </div>';
  } else {
    $query = $db->prepare("UPDATE `vehicle_bolo` SET `model` = :model, `color` = :color, `number` = :number, `features` = :features, `last_place` = :last_place, `last_date` = :last_date, `reason` = :reason, `last_bolo_update` = '$time' WHERE `id` = :id");
    $values = ['model' => $model, 'color' => $color, 'number' => $number, 'features' => $features, 'last_place' => $last_place, 'last_date' => $last_date, 'reason' => $reason, 'id' => $bolo_id];
    $query->execute($values);
    echo 'ok';
  }
} else if (isset($_POST['description'])) {
  $name = trim($_POST['name']);
  $name = htmlspecialchars($name);
  $surname = trim($_POST['surname']);
  $surname = htmlspecialchars($surname);
  $sex = trim($_POST['sex']);
  $sex = htmlspecialchars($sex);
  $description = trim($_POST['description']);
  $description = htmlspecialchars($description);
  $reason = trim($_POST['reason']);
  $reason = htmlspecialchars($reason);
  $bolo_id = htmlspecialchars($_POST['edit-people-bolo-id']);
  if (mb_strlen($name) > 20) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинное имя.
        </div>';
  } else if (mb_strlen($name) < 3) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткое имя.
        </div>';
  } else if (mb_strlen($surname) > 20) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинная фамилия.
        </div>';
  } else if (mb_strlen($surname) < 4) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткая фамилия.
        </div>';
  } else if (mb_strlen($sex) > 8) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинное название пола.
        </div>';
  } else if (mb_strlen($sex) < 4) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткое название пола.
        </div>';
  } else if (mb_strlen($description) > 250) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинное описание.
        </div>';
  } else if (mb_strlen($description) < 5) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткое описание.
        </div>';
  } else if (mb_strlen($reason) < 5) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткое обвинение.
        </div>';
  } else if (mb_strlen($reason) > 40) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинное обвинение.
        </div>';
  } else {
    $query = $db->prepare("UPDATE `people_bolo` SET `name` = :name, `surname` = :surname, `sex` = :sex, `description` = :description, `reason` = :reason, `last_bolo_update` = '$time' WHERE `id` = :id");
    $values = ['name' => $name, 'surname' => $surname, 'sex' => $sex, 'description' => $description, 'reason' => $reason, 'id' => $bolo_id];
    $query->execute($values);
    echo 'ok';
  }
} else {
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
  $edit_id = htmlspecialchars($_POST['edit-pf-id']);
  if (mb_strlen($name) < 3) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткий никнейм.
        </div>';
  } else if (mb_strlen($name) > 20) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинный никнейм
        </div>';
  } else if (mb_strlen($dob) < 4) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком короткая дата рождения.
        </div>';
  } else if (mb_strlen($dob) > 20) {
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
  } else if (mb_strlen($por) > 50) {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Слишком длинное место проживания.
        </div>';
  } else if (mb_strlen($por) < 8) {
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
    $query = $db->prepare("UPDATE `ncic` SET `name` = :name, `dob` = :dob, `sex` = :sex, `race` = :race, `marrital_status` = :marrital_status, `por` = :por, `skin` = :skin WHERE `id` = :id");
    $values = ['name' => $name, 'dob' => $dob, 'sex' => $sex, 'race' => $race, 'marrital_status' => $marrital_status, 'por' => $por, 'skin' => $skin, 'id' => $edit_id];
    $query->execute($values);
    echo 'ok';
  }
}
$db = null;
} else {
  header("Location: /");
  die();
} ?>
