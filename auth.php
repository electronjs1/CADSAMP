<?php
  $session_user_id = htmlspecialchars($_COOKIE['cad_u']);
  $session_id = htmlspecialchars($_COOKIE['cad_sid']);
  $session_browser = htmlspecialchars($_COOKIE['cad_bid']);
  $query = $db->prepare("SELECT count(*) FROM `sessions` WHERE `session_user_id` = :session_user_id AND `session_id` = :session_id AND md5(`session_browser`) = :session_browser");
  $values = ['session_user_id' => $session_user_id, 'session_id' => $session_id, 'session_browser' => $session_browser];
  $query->execute($values);
  $result = $query->fetchColumn();
  if ($result > 0) {
    $session_ip = htmlspecialchars($_SERVER['REMOTE_ADDR']);
    $session_ip = preg_replace('# {2,}#', ' ', str_replace(',', ' ', $session_ip));
    $query = $db->prepare("SELECT count(*) FROM `sessions` WHERE `session_user_id` = :session_user_id AND `session_id` = :session_id AND `session_ip` = :session_ip");
    $values = ['session_user_id' => $session_user_id, 'session_id' => $session_id, 'session_ip' => $session_ip];
    $query->execute($values);
    $result = $query->fetchColumn();
    $query = $db->prepare("SELECT `type` FROM `users` WHERE `id` = :session_user_id");
    $values = ['session_user_id' => $session_user_id];
    $query->execute($values);
    $type = $query->fetch();
    if ($result == 0 AND isset($_COOKIE['cad_k'])) {
      $key_id = htmlspecialchars($_COOKIE['cad_k']);
      $query = $db->prepare("SELECT count(*) FROM `sessions_keys` WHERE `user_id` = :session_user_id AND `key_id` = :key_id");
      $values = ['session_user_id' => $session_user_id, 'key_id' => $key_id];
      $query->execute($values);
      $result = $query->fetchColumn();
      if ($result > 0) {
        $time = time();
        $session_new_id = md5(uniqid());
        $key_new_id = uniqid(hexdec(substr($session_new_id, 0, 8)));
        $key_new_id = md5($key_id);
        $session_browser = htmlspecialchars($_SERVER['HTTP_USER_AGENT']);
        $query = $db->prepare("UPDATE `sessions` SET `session_id` = '$session_new_id', `session_ip` = :session_ip, `session_browser` = :session_browser, `session_time` = '$time' + 1728000 WHERE `session_user_id` = :session_user_id AND `session_id` = :session_id");
        $values = ['session_ip' => $session_ip, 'session_browser' => $session_browser, 'session_user_id' => $session_user_id, 'session_id' => $session_id];
        $query->execute($values);
        $query = $db->prepare("UPDATE `sessions_keys` SET `key_id` = '$key_new_id', `last_ip` = :session_ip, `last_login` = '$time' WHERE `user_id` = :session_user_id AND `key_id` = :key_id");
        $values = ['user_id' => $session_user_id, 'key_id' => $key_id];
        $query->execute($values);
        $session_browser = md5($session_browser);
        setcookie('cad_sid', $session_new_id, time() + 1728000, '/', '', 1);
        setcookie('cad_u', $session_user_id, time() + 1728000, '/', '', 1);
        setcookie('cad_bid', $session_browser, time() + 1728000, '/', '', 1);
        setcookie('cad_k', $key_new_id, time() + 1728000, '/', '', 1);
        if ($_SERVER['SCRIPT_NAME'] == '/index.php') {
          if ($type['type'] == 6 OR $type['type'] == 5) {
            $db = null;
            header("Location: /admin.php");
          	die();
          } else if ($type['type'] == 4) {
            $db = null;
            header("Location: /cad.php");
          	die();
          } else if ($type['type'] == 3) {
            $db = null;
            header("Location: /mdt.php");
          	die();
          } else if ($type['type'] == 2 OR $type['type'] == 1) {
            $db = null;
            header("Location: /database.php");
          	die();
          }
        } else {
          $db = null;
          header("Refresh:0");
          die();
        }
      } else {
        setcookie('cad_sid', '', 0, '/', '', 1);
        setcookie('cad_u', '', 0, '/', '', 1);
        setcookie('cad_bid', '', 0, '/', '', 1);
        setcookie('cad_k', '', 0, '/', '', 1);
        if ($_SERVER['SCRIPT_NAME'] == '/index.php') {
          $db = null;
          header("Refresh:0");
          die();
        } else {
          $db = null;
          header("Location: /");
          die();
        }
      }
    } else {
      if ($_SERVER['SCRIPT_NAME'] == '/index.php') {
        if ($type['type'] == 6 OR $type['type'] == 5) {
          $db = null;
          header("Location: /admin.php");
          die();
        } else if ($type['type'] == 4) {
          $db = null;
          header("Location: /cad.php");
          die();
        } else if ($type['type'] == 3) {
          $db = null;
          header("Location: /mdt.php");
          die();
        } else if ($type['type'] == 2 OR $type['type'] == 1) {
          $db = null;
          header("Location: /database.php");
          die();
        }
      }
    }
  } else {
    setcookie('cad_sid', '', 0, '/', '', 1);
    setcookie('cad_u', '', 0, '/', '', 1);
    setcookie('cad_bid', '', 0, '/', '', 1);
    setcookie('cad_k', '', 0, '/', '', 1);
    if ($_SERVER['SCRIPT_NAME'] == '/index.php') {
      $db = null;
      header("Refresh:0");
      die();
    } else {
      $db = null;
      header("Location: /");
      die();
    }
  } ?>
