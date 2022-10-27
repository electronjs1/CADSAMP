<?php
if (count($_POST) > 0 AND isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  require_once '../config.php';
  require 'auth.php';
  $name_civil = htmlspecialchars($_POST['violation-select-civil']);
  $name_article = trim($_POST['name-article']);
  $name_article = htmlspecialchars($name_article);
  $name_street = trim($_POST['name-street']);
  $name_street = htmlspecialchars($name_street);
  $query = $db->prepare("SELECT CONCAT(`username`, ' ', `identifier`) AS unit FROM `users` WHERE `id` = :user_id");
  $values = ['user_id' => $session_user_id];
  $query->execute($values);
  $results = $query->fetch();
  $query = $db->prepare("SELECT `name` FROM `ncic` WHERE `name` = :name_civil");
  $values = ['name_civil' => $name_civil];
  $query->execute($values);
  $result = $query->fetchAll();
  if (count($result) > 0) {
    if (mb_strlen($name_article) < 5) {
      echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
            Слишком короткое название статьи.
          </div>';
    } else if (mb_strlen($name_article) > 200) {
      echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
            Слишком длинное название статьи.
          </div>';
    } else if (mb_strlen($name_street) > 100) {
      echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
            Слишком длинное название улицы.
          </div>';
    } else if (mb_strlen($name_street) < 5) {
      echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
            Слишком короткое название улицы.
          </div>';
    } else if (isset($_POST['autoarrest'])) {
      $query = $db->prepare("INSERT INTO `ncic_arrests` (`name`, `reason`, `date`, `creator`) VALUES (:name, :reason, :date_time, :creator)");
      $values = ['name' => $name_civil, 'reason' => $name_article, 'date_time' => time(), 'creator' => $results['unit']];
      $query->execute($values);
      echo 'ok';
    } else {
      $query = $db->prepare("INSERT INTO `ncic_violations` (`name`, `reason`, `date`, `creator`, `place`) VALUES (:name, :reason, :date_time, :creator, :place)");
      $values = ['name' => $name_civil, 'reason' => $name_article, 'date_time' => time(), 'creator' => $results['unit'], 'place' => $name_street];
      $query->execute($values);
      echo 'ok';
    }
  } else {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Такого человека нет в базе.
        </div>';
  }
  $db = null;
} else {
  header("Location: /");
  die();
} ?>
