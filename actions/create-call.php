<?php
if (count($_POST) > 0 AND isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  require_once '../config.php';
  require 'auth.php';
  date_default_timezone_set('Europe/Moscow');
  $call_type = htmlspecialchars($_POST['select-call-type']);
  $call_location = trim($_POST['call-location']);
  $call_location = htmlspecialchars($call_location);
  $call_information = trim($_POST['call-information']);
  $call_information = htmlspecialchars($call_information);
  if ($call_type == '') {
    echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
          Выберите тип вызова.
        </div>';
  } else if (mb_strlen($call_location) < 5) {
      echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
            Слишком короткий адрес.
          </div>';
    } else if (mb_strlen($call_location) > 40) {
      echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
            Слишком длинный адрес.
          </div>';
    } else if (mb_strlen($call_information) < 5) {
      echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
            Слишком короткая информация к вызову.
          </div>';
    } else if (mb_strlen($call_information) > 100) {
      echo '<div class="alert alert-danger" style="margin-bottom: 0;" role="alert">
            Слишком длинная информация к вызову.
          </div>';
    } else {
      $log = ''.date("d.m.Y\nH:i:s", time()).': Вызов создан диспетчером.<br>'.date("d.m.Y\nH:i:s", time()).': '.$call_information.'';
      $query = $db->prepare("INSERT INTO `calls` (`type`, `location`, `active`, `last_calls_update`, `log`) VALUES (:type, :location, :active, :last_calls_update, '$log')");
      $values = ['type' => $call_type, 'location' => $call_location, 'active' => 1, 'last_calls_update' => time()];
      $query->execute($values);
      echo 'ok';
    }
    $db = null;
} else {
  header("Location: /");
  die();
} ?>
