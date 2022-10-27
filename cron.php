<?php require_once 'config.php';
date_default_timezone_set('Europe/Moscow');
$time = time();
$query = $db->prepare("DELETE FROM `sessions` WHERE `session_time` <= '$time'");
$query->execute();
$query = $db->prepare("DELETE FROM `sessions_keys` WHERE '$time' - `last_login` >= 1728000");
$query->execute();
$db = null; ?>
