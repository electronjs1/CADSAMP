<?php
if (count($_POST) > 0 AND isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  require_once '../config.php';
  require 'auth.php';
  date_default_timezone_set('Europe/Moscow');
  $time = time();
  $query = $db->prepare("SELECT `type` FROM `users` WHERE `id` = :admin_id");
  $values = ['admin_id' => $session_user_id];
  $query->execute($values);
  $results = $query->fetch();
  $username = trim($_POST['username']);
  $username = htmlspecialchars($username);
  $query = $db->prepare("SELECT * FROM `users` WHERE `username` = :username");
  $values = ['username' => $username];
  $query->execute($values);
  $result = $query->fetchAll();
  if (count($result) > 0 AND $results['type'] == 6 OR count($result) > 0 AND $results['type'] == 5) {
    $user_id = $result[0]['id'];
  if (isset($_POST['new-password'])) {
    $new_password = $_POST['new-password'];
    $new_password_verify = $_POST['new-password-verify'];
      if (strlen($new_password) < 6 OR strlen($new_password) > 14) {
        echo '<div class="alert alert-danger" role="alert">
              Пароль должен содержать не меньше 6 и не больше 14 символов.
              </div>';
      } else if ($new_password != $new_password_verify) {
        echo '<div class="alert alert-danger" role="alert">
              Пароли не совпадают.
              </div>';
      } else if ($result[0]['type'] == 6 AND $results['type'] != 6) {
          echo '<div class="alert alert-danger" role="alert">
                Вы не можете поменять пароль основателю.
                </div>';
        } else if ($result[0]['type'] == 5 AND $results['type'] != 6) {
          echo '<div class="alert alert-danger" role="alert">
                Вы не можете поменять пароль администратору.
                </div>';
        } else if (password_verify($new_password, $result[0]['password'])) {
          echo '<div class="alert alert-danger" role="alert">
                Вы не можете поменять пароль на тот же.
                </div>';
        } else {
          $new_password = password_hash($new_password, PASSWORD_DEFAULT);
          $log_action = 'Изменил пароль пользователя '.$username.'.';
          $query = $db->prepare("DELETE FROM `sessions` WHERE `session_user_id` = '$user_id'");
          $query->execute();
          $query = $db->prepare("DELETE FROM `sessions_keys` WHERE `user_id` = '$user_id'");
          $query->execute();
          $query = $db->prepare("UPDATE `users` SET `password` = '$new_password' WHERE `id` = '$user_id'");
          $query->execute();
          $query = $db->prepare("INSERT INTO `log` (`user_id`, `log_ip`, `log_time`, `log_action`) VALUES (:admin_id, :log_ip, '$time', :log_action)");
          $values = ['admin_id' => $session_user_id, 'log_ip' => $session_ip, 'log_action' => $log_action];
          $query->execute($values);
          echo 'Пароль успешно изменён.';
        }
    } else if (isset($_POST['new-identifier'])) {
      $new_identifier = trim($_POST['new-identifier']);
      $new_identifier = htmlspecialchars($new_identifier);
        if (strlen($new_identifier) != 7) {
          echo '<div class="alert alert-danger" role="alert">
                Идентификатор должен содержать 7 символов.
                </div>';
        } else if ($result[0]['type'] == 6 AND $results['type'] != 6) {
            echo '<div class="alert alert-danger" role="alert">
                  Вы не можете поменять идентификатор основателю.
                  </div>';
          } else if ($result[0]['type'] == 5 AND $results['type'] != 6) {
            echo '<div class="alert alert-danger" role="alert">
                  Вы не можете поменять идентификатор администратору.
                  </div>';
          } else if ($new_identifier == $result[0]['identifier']) {
            echo '<div class="alert alert-danger" role="alert">
                  Вы не можете поменять идентификатор на тот же.
                  </div>';
          } else {
            $log_action = 'Изменил идентификатор пользователя '.$username.' с "'.$result[0]['identifier'].'" на "'.$new_identifier.'".';
            $query = $db->prepare("UPDATE `users` SET `identifier` = :identifier WHERE `id` = '$user_id'");
            $values = ['identifier' => $new_identifier];
            $query->execute($values);
            $query = $db->prepare("INSERT INTO `log` (`user_id`, `log_ip`, `log_time`, `log_action`) VALUES (:admin_id, :log_ip, '$time', :log_action)");
            $values = ['admin_id' => $session_user_id, 'log_ip' => $session_ip, 'log_action' => $log_action];
            $query->execute($values);
            echo 'Идентификатор успешно изменён.';
          }
    } else if (isset($_POST['new-username'])) {
      $new_username = trim($_POST['new-username']);
      $new_username = htmlspecialchars($new_username);
        if (strlen($new_username) > 24) {
          echo '<div class="alert alert-danger" role="alert">
                Слишком длинный никнейм.
                </div>';
        } else if (strlen($new_username) < 6) {
          echo '<div class="alert alert-danger" role="alert">
                Слишком короткий никнейм.
                </div>';
        } else if ($result[0]['type'] == 6 AND $results['type'] != 6) {
            echo '<div class="alert alert-danger" role="alert">
                  Вы не можете поменять никнейм основателю.
                  </div>';
          } else if ($result[0]['type'] == 5 AND $results['type'] != 6) {
            echo '<div class="alert alert-danger" role="alert">
                  Вы не можете поменять никнейм администратору.
                  </div>';
          } else if ($new_username == $result[0]['username']) {
            echo '<div class="alert alert-danger" role="alert">
                  Вы не можете поменять никнейм на тот же.
                  </div>';
          } else {
            $log_action = 'Изменил никнейм пользователя с "'.$username.'" на "'.$new_username.'".';
            $query = $db->prepare("UPDATE `users` SET `username` = :username WHERE `id` = '$user_id'");
            $values = ['username' => $new_username];
            $query->execute($values);
            $query = $db->prepare("INSERT INTO `log` (`user_id`, `log_ip`, `log_time`, `log_action`) VALUES (:admin_id, :log_ip, '$time', :log_action)");
            $values = ['admin_id' => $session_user_id, 'log_ip' => $session_ip, 'log_action' => $log_action];
            $query->execute($values);
            echo 'Никнейм успешно изменён.';
          }
    } else if (isset($_POST['new-type'])) {
      $new_type = htmlspecialchars($_POST['new-type']);
        if ($result[0]['type'] == 6 AND $results['type'] != 6) {
            echo '<div class="alert alert-danger" role="alert">
                  Вы не можете поменять роль основателю.
                  </div>';
          } else if ($result[0]['type'] == 5 AND $results['type'] != 6) {
            echo '<div class="alert alert-danger" role="alert">
                  Вы не можете поменять роль администратору.
                  </div>';
          } else if ($new_type == $result[0]['type']) {
            echo '<div class="alert alert-danger" role="alert">
                  Вы не можете поменять роль на ту же.
                  </div>';
          } else if ($new_type == 6 AND $results['type'] != 6) {
            echo '<div class="alert alert-danger" role="alert">
                  Вы не можете поменять роль на основателя.
                  </div>';
          } else if ($new_type == 5 AND $results['type'] != 6) {
            echo '<div class="alert alert-danger" role="alert">
                  Вы не можете поменять роль на администратора.
                  </div>';
          } else if ($new_type == '') {
            echo '<div class="alert alert-danger" role="alert">
                  Выберите роль.
                  </div>';
          } else {
            if ($new_type == 6) {
              $response = 'Основатель';
            } else if ($new_type == 5) {
              $response = 'Администратор';
            } else if ($new_type == 4) {
              $response = 'Диспетчер';
            } else if ($new_type == 3) {
              $response = 'Офицер';
            } else if ($new_type == 2) {
              $response = 'SADoC';
            } else if ($new_type == 1) {
              $response = 'Government';
            }
            $log_action = 'Изменил роль пользователя '.$username.' на "'.$response.'".';
            $query = $db->prepare("UPDATE `users` SET `type` = :type WHERE `id` = '$user_id'");
            $values = ['type' => $new_type];
            $query->execute($values);
            $query = $db->prepare("INSERT INTO `log` (`user_id`, `log_ip`, `log_time`, `log_action`) VALUES (:admin_id, :log_ip, '$time', :log_action)");
            $values = ['admin_id' => $session_user_id, 'log_ip' => $session_ip, 'log_action' => $log_action];
            $query->execute($values);
            echo 'Роль успешно изменена.';
          }
    } else if (isset($_POST['username-delete'])) {
        if ($result[0]['type'] == 6 AND $results['type'] != 6) {
            echo '<div class="alert alert-danger" role="alert">
                  Вы не можете удалить аккаунт основателя.
                  </div>';
          } else if ($result[0]['type'] == 5 AND $results['type'] != 6) {
            echo '<div class="alert alert-danger" role="alert">
                  Вы не можете удалить аккаунт администратору.
                  </div>';
          } else {
            $log_action = 'Удалил пользователя '.$username.'.';
            $query = $db->prepare("DELETE FROM `users` WHERE `id` = '$user_id'");
            $query->execute();
            $query = $db->prepare("DELETE FROM `sessions` WHERE `session_user_id` = '$user_id'");
            $query->execute();
            $query = $db->prepare("DELETE FROM `sessions_keys` WHERE `user_id` = '$user_id'");
            $query->execute();
            $query = $db->prepare("INSERT INTO `log` (`user_id`, `log_ip`, `log_time`, `log_action`) VALUES (:admin_id, :log_ip, '$time', :log_action)");
            $values = ['admin_id' => $session_user_id, 'log_ip' => $session_ip, 'log_action' => $log_action];
            $query->execute($values);
            echo 'Аккаунт успешно удалён.';
          }
    } else if (isset($_POST['type'])) {
            $request_id = htmlspecialchars($_POST['request-id']);
            $type = htmlspecialchars($_POST['type']);
            $query = $db->prepare("SELECT * FROM `users` WHERE `id` = :id AND `activation` = 0");
            $values = ['id' => $request_id];
            $query->execute($values);
            $activation = $query->fetchAll();
            if ($type == '') {
              echo '<div class="alert alert-danger" role="alert">
                    Выберите роль.
                    </div>';
                  } else if ($type == 6 AND $results['type'] != 6) {
                    echo '<div class="alert alert-danger" role="alert">
                          Вы не можете выдать роль основателя.
                          </div>';
                  } else if ($type == 5 AND $results['type'] != 6) {
                    echo '<div class="alert alert-danger" role="alert">
                          Вы не можете выдать роль администратора.
                          </div>';
                        } else {
                          if (count($activation) > 0) {
                            if ($type == 6) {
                              $response = 'Основатель';
                            } else if ($type == 5) {
                              $response = 'Администратор';
                            } else if ($type == 4) {
                              $response = 'Диспетчер';
                            } else if ($type == 3) {
                              $response = 'Офицер';
                            } else if ($type == 2) {
                              $response = 'SADoC';
                            } else if ($type == 1) {
                              $response = 'Government';
                            }
                            include '../smtp/Send_Mail.php';
                            $to = $activation[0]['email'];
                            $subject = "Ответ на запрос доступа к CAD.LSCSD.RU";
                            $subject = base64_encode($subject);
                            $subject = "=?utf-8?B?{$subject}?=";
                            $body = 'Здравствуйте, '.$activation[0]['username'].'! Мы рады сообщить Вам, что Ваша заявка на получение доступа к CAD.LSCSD.RU была одобрена. Для того, чтобы закончить этап регистрации Вам необходимо перейти по ссылке ниже. <br/> <a href="https://cad.lscsd.ru/activation/'.$activation[0]['activation_code'].'">https://cad.lscsd.ru/activation/'.$activation[0]['activation_code'].'</a> <br/> <br/> Если Вы получили это письмо по ошибке, пожалуйста, проигнорируйте его.';
                            Send_Mail($to, $subject, $body);
                            $log_action = 'Одобрил запрос доступа для '.$activation[0]['username'].' с ролью '.$response.'.';
                            $query = $db->prepare("UPDATE `users` SET `activation` = 1, `type` = :type WHERE `id` = '$user_id'");
                            $values = ['type' => $type];
                            $query->execute($values);
                            $query = $db->prepare("INSERT INTO `log` (`user_id`, `log_ip`, `log_time`, `log_action`) VALUES (:admin_id, :log_ip, '$time', :log_action)");
                            $values = ['admin_id' => $session_user_id, 'log_ip' => $session_ip, 'log_action' => $log_action];
                            $query->execute($values);
                            echo 'ok';
                          } else {
                            echo '<div class="alert alert-success" role="alert">
                                  Данный пользователь не нуждается в активации.
                                  </div>';
                          }
                        }
          } else if (isset($_POST['information'])) {
            $request_id = htmlspecialchars($_POST['request-id']);
            $information = trim($_POST['information']);
            $information = htmlspecialchars($information);
            $query = $db->prepare("SELECT * FROM `users` WHERE `id` = :id AND `activation` = 0");
            $values = ['id' => $request_id];
            $query->execute($values);
            $activation = $query->fetchAll();
            if (count($activation) > 0) {
              if ($request_id == 6) {
                $response = 'Основатель';
              } else if ($request_id == 5) {
                $response = 'Администратор';
              } else if ($request_id == 4) {
                $response = 'Диспетчер';
              } else if ($request_id == 3) {
                $response = 'Офицер';
              } else if ($request_id == 2) {
                $response = 'SADoC';
              } else if ($request_id == 1) {
                $response = 'Government';
              }
              include '../smtp/Send_Mail.php';
              $to = $activation[0]['email'];
              $subject = "Ответ на запрос доступа к CAD.LSCSD.RU";
              $subject = base64_encode($subject);
              $subject = "=?utf-8?B?{$subject}?=";
              $body = 'Здравствуйте, '.$activation[0]['username'].'! К сожалению, Ваша заявка на получение доступа к CAD.LSCSD.RU была отклонена. Причина: '.$information.'. <br/> <br/> Если Вы получили это письмо по ошибке, пожалуйста, проигнорируйте его.';
              Send_Mail($to, $subject, $body);
              $log_action = 'Отклонил запрос доступа для '.$activation[0]['username'].' с причиной "'.$information.'".';
              $query = $db->prepare("DELETE FROM `users` WHERE `id` = :id");
              $values = ['id' => $request_id];
              $query->execute($values);
              $query = $db->prepare("INSERT INTO `log` (`user_id`, `log_ip`, `log_time`, `log_action`) VALUES (:admin_id, :log_ip, '$time', :log_action)");
              $values = ['admin_id' => $session_user_id, 'log_ip' => $session_ip, 'log_action' => $log_action];
              $query->execute($values);
              echo 'ok';
          } else {
            echo '<div class="alert alert-success" role="alert">
                  Данный пользователь не нуждается в активации.
                  </div>';
          }
        }
  } else {
    echo '<div class="alert alert-danger" role="alert">
          Такого пользователя не существует.
          </div>';
  }
  $db = null;
} else {
  header("Location: /");
  die();
} ?>
