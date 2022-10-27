<?php
if (count($_POST) > 0) {
  require_once '../config.php';
  $email = trim($_POST['email']);
  $email = htmlspecialchars($email);
  $password = $_POST['password'];
  $query = $db->prepare("SELECT count(*) FROM `users` WHERE `email` = :email");
  $values = ['email' => $email];
  $query->execute($values);
  $result = $query->fetchColumn();
  if ($email == '') {
    echo '<div class="alert alert-danger" role="alert">
          Заполните поле с email.
          </div>';
  } else if ($password == '') {
    echo '<div class="alert alert-danger" role="alert">
          Заполните поле с паролем.
          </div>';
} else if ($result > 0) {
    $query = $db->prepare("SELECT * FROM `users` WHERE `email` = :email");
    $values = ['email' => $email];
    $query->execute($values);
    $result = $query->fetch(PDO::FETCH_OBJ);
   // if (password_verify($password, $result->password)) {
   if ($password == $result->password) {        
      if ($result->activation == 0 OR $result->activation == 1) {
        echo '<div class="alert alert-danger" role="alert">
              Вы ещё находитесь на рассмотрении.
              </div>';
            } else if ($result->activation == 2) {
              $session_user_id = $result->id;
              $session_id = md5(uniqid());
              $session_ip = htmlspecialchars($_SERVER['REMOTE_ADDR']);
              $session_ip = preg_replace('# {2,}#', ' ', str_replace(',', ' ', $session_ip));
              $session_browser = htmlspecialchars($_SERVER['HTTP_USER_AGENT']);
              $time = time();
              if (isset($_POST['autologin'])) {
                $key_id = uniqid(hexdec(substr($session_id, 0, 8)));
                $key_id = md5($key_id);
                $query = $db->prepare("INSERT INTO `sessions` (`session_id`, `session_user_id`, `session_ip`, `session_browser`, `session_time`) VALUES ('$session_id', '$session_user_id', :session_ip, :session_browser, '$time' + 1728000)");
                $values = ['session_ip' => $session_ip, 'session_browser' => $session_browser];
                $query->execute($values);
                $query = $db->prepare("INSERT INTO `sessions_keys` (`key_id`, `user_id`, `last_ip`, `last_login`) VALUES ('$key_id', '$session_user_id', :session_ip, '$time')");
                $values = ['session_ip' => $session_ip];
                $query->execute($values);
                $session_browser = md5($session_browser);
                setcookie('cad_k', $key_id, time() + 1728000, '/', '.cad.lscsd.ru',1);
                setcookie('cad_sid', $session_id, time() + 1728000, '/', '.cad.lscsd.ru',1);
                setcookie('cad_u', $session_user_id, time() + 1728000, '/', '.cad.lscsd.ru',1);
                setcookie('cad_bid', $session_browser, time() + 1728000, '/', '/', '.cad.lscsd.ru',1);
              } else {
                $query = $db->prepare("INSERT INTO `sessions` (`session_id`, `session_user_id`, `session_ip`, `session_browser`, `session_time`) VALUES ('$session_id', '$session_user_id', :session_ip, :session_browser, '$time' + 3600)");
                $values = ['session_ip' => $session_ip, 'session_browser' => $session_browser];
                $query->execute($values);
                $session_browser = md5($session_browser);
                setcookie('cad_sid', $session_id, time() + 3600, '/', '.cad.lscsd.ru',1);
                setcookie('cad_u', $session_user_id, time() + 3600, '/', '.cad.lscsd.ru',1);
                setcookie('cad_bid', $session_browser, time() + 3600, '/', '.cad.lscsd.ru',1);
              }
                echo 'ok';
              }
            } else {
      echo '<div class="alert alert-danger" role="alert">
            Неверный пароль.
            </div>';
    }
  } else {
    echo '<div class="alert alert-danger" role="alert">
          Пользователя с таким email не существует.
          </div>';
  }
  $db = null;
} else {
  header("Location: /");
	die();
} ?>
