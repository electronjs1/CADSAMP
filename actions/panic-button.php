<?php
if (count($_POST) > 0 AND isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  require_once '../config.php';
  require 'auth.php';
  date_default_timezone_set('Europe/Moscow');
  $time = time();
  $message = $_POST['message'];
  $query = $db->prepare("SELECT * FROM `notifications`");
  $query->execute();
  $result = $query->fetch();
  if ($message == 'panic' AND $result['panic_active'] == 0) {
    $query = $db->prepare("SELECT `identifier` FROM `users` WHERE `id` = :user_id");
    $values = ['user_id' => $session_user_id];
    $query->execute($values);
    $result = $query->fetch();
    $log = ''.date("d.m.Y\nH:i:s", $time).': Активация тревожной кнопки офицером '.$result['username'].'.';
    $query = $db->prepare("INSERT INTO `calls` (`type`, `location`, `active`, `last_calls_update`, `log`) VALUES ('2', 'Неизвестно.', '1', '$time', '$log')");
    $query->execute();
    $query = $db->prepare("UPDATE `notifications` SET `panic_active` = '1', `last_notifications_update` = '$time'");
    $query->execute();
  } else {
    if ($result['signal_100'] == 0) {
      $query = $db->prepare("UPDATE `notifications` SET `signal_100` = '1', `last_notifications_update` = '$time'");
      $query->execute();
    } else {
      $query = $db->prepare("UPDATE `notifications` SET `signal_100` = '0', `last_notifications_update` = '$time'");
      $query->execute();
    }
  }
  $db = null;
} else {
  header("Location: /");
	die();
} ?>
