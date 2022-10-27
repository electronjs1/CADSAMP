<?php
if (count($_POST) > 0 AND isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
    require_once '../config.php';
    require 'auth.php';
    $json = json_decode(file_get_contents("php://input"), true);
    $active_call = htmlspecialchars($json['id']);
    $time = time();
    $query = $db->prepare("SELECT * FROM `calls` WHERE `id` = :active_call");
    $values = ['active_call' => $active_call];
    $query->execute($values);
    $result = $query->fetch();
    if ($json['message'] == 'Код 4') {
      if ($result['type'] == 2) {
        $query = $db->prepare("UPDATE `notifications` SET `panic_active` = '0', `last_notifications_update` = '$time'");
        $values = ['active_call' => $active_call];
        $query->execute($values);
      }
      $query = $db->prepare("UPDATE `users` SET `active_call` = '0', `status` = '10-8 | ДОСТУПЕН', `last_user_update` = '$time', `notification` = '0' WHERE `active_call` = :active_call");
      $values = ['active_call' => $active_call];
      $query->execute($values);
      $query = $db->prepare("UPDATE `calls` SET `active` = '0', `last_calls_update` = '$time' WHERE `id` = :active_call");
      $values = ['active_call' => $active_call];
      $query->execute($values);
    } else if ($json['message'] == 'Удалить') {
      if ($json['type'] == 'Человек') {
        $query = $db->prepare("UPDATE `people_bolo` SET `active` = '0', `last_bolo_update` = '$time' WHERE `id` = :active_call");
        $values = ['active_call' => $active_call];
        $query->execute($values);
      } else {
        $query = $db->prepare("UPDATE `vehicle_bolo` SET `active` = '0', `last_bolo_update` = '$time' WHERE `id` = :active_call");
        $values = ['active_call' => $active_call];
        $query->execute($values);
      }
    } else if ($json['message'] == 'Редактировать') {
      if ($json['type'] == 'Человек') {
        $query = $db->prepare("SELECT * FROM `people_bolo` WHERE `id` = :active_call");
        $values = ['active_call' => $active_call];
        $query->execute($values);
        $result = $query->fetch();
        echo json_encode($result);
      } else if ($json['type'] == 'Автомобиль') {
        $query = $db->prepare("SELECT * FROM `vehicle_bolo` WHERE `id` = :active_call");
        $values = ['active_call' => $active_call];
        $query->execute($values);
        $result = $query->fetch();
        echo json_encode($result);
      } else {
        $query = $db->prepare("SELECT * FROM `ncic` WHERE `id` = :active_call");
        $values = ['active_call' => $active_call];
        $query->execute($values);
        $result = $query->fetch();
        echo json_encode($result);
      }
    } else {
      $unit = htmlspecialchars($json['unit']);
      $query = $db->prepare("SELECT `active_call` FROM `users` WHERE `identifier` = :unit AND `active_call` = '0'");
      $values = ['unit' => $unit];
      $query->execute($values);
      $results = $query->fetchAll();
      if (count($results) > 0) {
      $answer = ["message"=>"ok"];
      echo json_encode($answer);
      $log = ''.$result['log'].'<br>'.date("d.m.Y\nH:i:s", time()).': Юнит прикреплён диспетчером: '.$unit.'.';
      $query = $db->prepare("UPDATE `users` SET `active_call` = :active_call, `last_user_update` = '$time', `notification` = '1', `status` = '10-7 | НА ВЫЗОВЕ' WHERE `identifier` = :unit");
      $values = ['active_call' => $active_call, 'unit' => $unit];
      $query->execute($values);
      $query = $db->prepare("UPDATE `calls` SET `log` = :log, `last_calls_update` = '$time' WHERE `id` = :active_call");
      $values = ['active_call' => $active_call, 'log' => $log];
      $query->execute($values);
    } else {
      $answer = ["message"=>"bad"];
      echo json_encode($answer);
    }
}
$db = null;
} else {
  header("Location: /");
	die();
} ?>
