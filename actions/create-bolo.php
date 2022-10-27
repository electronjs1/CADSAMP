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
    $query = $db->prepare("INSERT INTO `vehicle_bolo` (`model`, `color`, `number`, `features`, `last_place`, `last_date`, `reason`, `active`, `last_bolo_update`) VALUES (:model, :color, :number, :features, :last_place, :last_date, :reason, '1', '$time')");
    $values = ['model' => $model, 'color' => $color, 'number' => $number, 'features' => $features, 'last_place' => $last_place, 'last_date' => $last_date, 'reason' => $reason];
    $query->execute($values);
    echo 'ok';
  }
} else {
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
    $query = $db->prepare("INSERT INTO `people_bolo` (`name`, `surname`, `sex`, `description`, `reason`, `active`, `last_bolo_update`) VALUES (:name, :surname, :sex, :description, :reason, '1', '$time')");
    $values = ['name' => $name, 'surname' => $surname, 'sex' => $sex, 'description' => $description, 'reason' => $reason];
    $query->execute($values);
    echo 'ok';
  }
}
$db = null;
} else {
  header("Location: /");
  die();
} ?>
