<?php
if (count($_POST) > 0 AND isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  require_once '../config.php';
  require 'auth.php';
  $q = htmlspecialchars($_POST['q']);
  $query = $db->prepare("SELECT `identifier` FROM `users` WHERE `identifier` LIKE :q AND `status` = '10-8 | ДОСТУПЕН'");
  $values = ['q' => "%$q%"];
  $query->execute($values);
  $result = $query->fetchAll();
  if (count($result) > 0) {
    $query = $db->prepare("SELECT `identifier` FROM `users` WHERE `identifier` LIKE :q AND `status` = '10-8 | ДОСТУПЕН'");
    $values = ['q' => "%$q%"];
    $query->execute($values);
    $result = $query->fetchAll();
    for ($i = 0; $i < count($result); $i++) {
      echo '<li class="select__option" data-value="'.$result[$i]['identifier'].'">'.$result[$i]['identifier'].'</li>';
    }
  } else {
    echo '<li class="select__option">Не найдено по запросу "'.$q.'"</li>';
  }
  $db = null;
} else {
  header("Location: /");
	die();
} ?>
