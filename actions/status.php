<?php
if (count($_POST) > 0 AND isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  require_once '../config.php';
  require 'auth.php';
  date_default_timezone_set('Europe/Moscow');
  $time = time();
  $status = json_decode(file_get_contents("php://input"), true);
  $query = $db->prepare("SELECT * FROM `users` WHERE `id` = :user_id");
  $values = ['user_id' => $session_user_id];
  $query->execute($values);
  $result = $query->fetch();
  $active_call = $result['active_call'];
  if ($active_call != 0 AND $status['status'] != '10-23 | НА МЕСТЕ') {
    $query = $db->prepare("SELECT `log` FROM `calls` WHERE `id` = '$active_call'");
    $query->execute();
    $log = $query->fetch();
    $log = ''.$log['log'].'<br>'.date("d.m.Y\nH:i:s", $time).': Юнит самостоятельно откреплён: '.$result['identifier'].'.';
    $query = $db->prepare("UPDATE `calls` SET `log` = '$log', `last_calls_update` = '$time' WHERE `id` = '$active_call'");
    $query->execute();
    $query = $db->prepare("UPDATE `users` SET `status` = :status, `last_user_update` = '$time', `notification` = '0', `active_call` = '0' WHERE `id` = :user_id");
    $values = ['status' => $status['status'], 'user_id' => $session_user_id];
    $query->execute($values);
  } else if ($active_call != 0 AND $status['status'] == '10-23 | НА МЕСТЕ' AND $status['status'] != $result['status']) {
    $query = $db->prepare("SELECT `log` FROM `calls` WHERE `id` = '$active_call'");
    $query->execute();
    $log = $query->fetch();
    $log = ''.$log['log'].'<br>'.date("d.m.Y\nH:i:s", $time).': Юнит прибыл на вызов: '.$result['identifier'].'.';
    $query = $db->prepare("UPDATE `calls` SET `log` = '$log', `last_calls_update` = '$time' WHERE `id` = '$active_call'");
    $query->execute();
    $query = $db->prepare("UPDATE `users` SET `status` = :status, `last_user_update` = '$time' WHERE `id` = :user_id");
    $values = ['status' => $status['status'], 'user_id' => $session_user_id];
    $query->execute($values);
  } else if ($status['status'] == '10-8 | ДОСТУПЕН' OR $status['status'] == '10-7 | ВНЕ СЛУЖБЫ' OR $status['status'] == '10-6 | ЗАНЯТ') {
    $query = $db->prepare("UPDATE `users` SET `status` = :status, `last_user_update` = '$time' WHERE `id` = :user_id");
    $values = ['status' => $status['status'], 'user_id' => $session_user_id];
    $query->execute($values);
}
$db = null;
} else {
  header("Location: /");
	die();
} ?>
