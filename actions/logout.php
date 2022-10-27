<?php
  if (isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
    require_once '../config.php';
    require 'auth.php';
    $query = $db->prepare("DELETE FROM `sessions` WHERE `session_user_id` = :user_id AND `session_id` = :session_id");
    $values = ['user_id' => $session_user_id, 'session_id' => $session_id];
    $query->execute($values);
    setcookie('cad_sid', '', 0, '/', '', 1);
    setcookie('cad_u', '', 0, '/', '', 1);
    setcookie('cad_bid', '', 0, '/', '', 1);
    setcookie('cad_k', '', 0, '/', '', 1);
    $db = null;
  }
  header("Location: /");
  die(); ?>
