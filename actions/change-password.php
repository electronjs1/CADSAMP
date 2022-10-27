<?php
if (count($_POST) > 0 AND isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  require_once '../config.php';
  require 'auth.php';
  $password = $_POST['password'];
  $new_password = $_POST['new-password'];
  $new_password_verify = $_POST['new-password-verify'];
  $query = $db->prepare("SELECT `password` FROM `users` WHERE `id` = :user_id");
  $values = ['user_id' => $session_user_id];
  $query->execute($values);
  $result = $query->fetch();
    if (strlen($new_password) < 6 OR strlen($new_password) > 14) {
      echo '<div class="alert alert-danger" role="alert">
            Пароль должен содержать не меньше 6 и не больше 14 символов.
            </div>';
    } else if ($new_password != $new_password_verify) {
      echo '<div class="alert alert-danger" role="alert">
            Пароли не совпадают.
            </div>';
    } else if (password_verify($new_password, $result['password'])) {
        echo '<div class="alert alert-danger" role="alert">
              Вы не можете поменять пароль на тот же.
              </div>';
      } else if (password_verify($password, $result['password'])) {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $query = $db->prepare("DELETE FROM `sessions` WHERE `session_user_id` = :user_id AND `session_id` != :session_id");
        $values = ['user_id' => $session_user_id, 'session_id' => $session_id];
        $query->execute($values);
        $query = $db->prepare("UPDATE `users` SET `password` = '$new_password' WHERE `id` = :user_id");
        $values = ['user_id' => $session_user_id];
        $query->execute($values);
        echo 'ok';
      } else {
        echo '<div class="alert alert-danger" role="alert">
              Неверно введён текущий пароль.
              </div>';
      }
      $db = null;
} else {
  header("Location: /");
  die();
} ?>
