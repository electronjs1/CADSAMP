<?php
if (count($_POST) > 0) {
  require_once '../config.php';
  $username = trim($_POST['username']);
  $username = htmlspecialchars($username);
  $email = trim($_POST['email']);
  $email = htmlspecialchars($email);
  $identifier = trim($_POST['identifier']);
  $identifier = htmlspecialchars($identifier);
  $vkpage = trim($_POST['vkpage']);
  $vkpage = htmlspecialchars($vkpage);
  $password = $_POST['password'];
  $password_check = $_POST['password-check'];
  $query = $db->prepare("SELECT count(*) FROM `users` WHERE `username` = :username");
  $values = ['username' => $username];
  $query->execute($values);
  $result = $query->fetchColumn();
  /*$query = $db->prepare("SELECT count(*) FROM `users` WHERE `email` = :email");
  $values = ['email' => $email];
  $query->execute($values);
  $result_email = $query->fetchColumn();*/
  $query = $db->prepare("SELECT count(*) FROM `users` WHERE `identifier` = :identifier");
  $values = ['identifier' => $identifier];
  $query->execute($values);
  $result_identifier = $query->fetchColumn();
  $query = $db->prepare("SELECT count(*) FROM `users` WHERE `vkpage` = :vkpage");
  $values = ['vkpage' => $vkpage];
  $query->execute($values);
  $result_vkpage = $query->fetchColumn();
  if ($result > 0) {
    $query = $db->prepare("SELECT `activation` FROM `users` WHERE `username` = :username");
    $values = ['username' => $username];
    $query->execute($values);
    $result = $query->fetch();
    if ($result[0] == 0 OR $result[0] == 1) {
      echo '<div class="alert alert-danger" role="alert">
            Этот пользователь уже на рассмотрении.
            </div>';
    } else if ($result[0] == 2) {
      echo '<div class="alert alert-danger" role="alert">
            Этот пользователь уже имеет доступ.
            </div>';
    }
  } /*else if ($result_email > 0) {
    $query = $db->prepare("SELECT `activation` FROM `users` WHERE `email` = :email");
    $values = ['email' => $email];
    $query->execute($values);
    $result = $query->fetch();
    if ($result[0] == 0 OR $result[0] == 1) {
      echo '<div class="alert alert-danger" role="alert">
            Пользователь с таким email уже на рассмотрении.
            </div>';
    } else if ($result[0] == 2) {
      echo '<div class="alert alert-danger" role="alert">
            Пользователь с таким email уже имеет доступ.
            </div>';
  }
}*/ else if ($result_identifier > 0) {
  $query = $db->prepare("SELECT `activation` FROM `users` WHERE `identifier` = :identifier");
  $values = ['identifier' => $identifier];
  $query->execute($values);
  $result = $query->fetch();
  if ($result[0] == 0 OR $result[0] == 1) {
    echo '<div class="alert alert-danger" role="alert">
          Пользователь с таким идентификатором уже на рассмотрении.
          </div>';
  } else if ($result[0] == 2) {
    echo '<div class="alert alert-danger" role="alert">
          Пользователь с таким идентификатором уже имеет доступ.
          </div>';
}
} else if (strlen($username) > 24) {
    echo '<div class="alert alert-danger" role="alert">
          Слишком длинный никнейм.
          </div>';
  } else if (strlen($username) < 6) {
    echo '<div class="alert alert-danger" role="alert">
          Слишком короткий никнейм.
          </div>';
  } else if (strlen($identifier) < 3 || strlen($identifier) > 20) {
    echo '<div class="alert alert-danger" role="alert">
          Идентификатор должен состоять минимум из 3 и максимум из 20 символов.
          </div>';
  } else if ($username == '') {
    echo '<div class="alert alert-danger" role="alert">
          Заполните поле с никнеймом.
          </div>';
  } else if ($email == '') {
    echo '<div class="alert alert-danger" role="alert">
          Заполните поле с email.
          </div>';
  } else if ($identifier == '') {
    echo '<div class="alert alert-danger" role="alert">
          Заполните поле с идентификатором.
          </div>';
  } else if ($vkpage == '') {
    echo '<div class="alert alert-danger" role="alert">
          Заполните поле с ссылкой на ваш Вк.
          </div>';
  } else if ($password == '') {
    echo '<div class="alert alert-danger" role="alert">
          Заполните поле с паролем.
          </div>';
  } else if ($password_check == '') {
    echo '<div class="alert alert-danger" role="alert">
          Заполните поле с подтверждением пароля.
          </div>';
  } else if (strlen($password) < 6 OR strlen($password) > 24) {
    echo '<div class="alert alert-danger" role="alert">
          Пароль должен содержать не меньше 6 и не больше 24 символов.
          </div>';
  } else if ($password != $password_check) {
    echo '<div class="alert alert-danger" role="alert">
          Введённые пароли не совпадают.
          </div>';
  } else {
    //$password = password_hash($password, PASSWORD_DEFAULT);
    $activation_code = $email;
    $query = $db->prepare("INSERT INTO `users` (`username`, /*`email`,*/ `vkpage`, `password`, `status`, `last_user_update`, `active_call`, `notification`, `identifier`, `type`, `activation`, `activation_code`) VALUES (:username, /*:email,*/ :vkpage, '$password', '10-7 | ВНЕ СЛУЖБЫ', '0', '0', '0', :identifier, '0', '0', '$activation_code')");
    $values = ['username' => $username, /*'email' => $email,*/ 'identifier' => $identifier, 'vkpage' => $vkpage];
    $query->execute($values);
    echo '<div class="alert alert-success" role="alert">
          Запрос успешно зарегистрирован. Ответ будет отправлен администраторам на рассмотрение.
          </div>';
  }
  $db = null;
} else {
  header("Location: /");
	die();
} ?>
