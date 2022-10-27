<?php include_once 'config.php';


if (isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  include 'actions/auth.php';
  $query = $db->prepare("SELECT * FROM `users` WHERE `id` = :user_id");
  $values = ['user_id' => $session_user_id];
  $query->execute($values);
  $result = $query->fetch();
  if ($result['type'] != 6 AND $result['type'] != 5) {
    $db = null;
    header("Location: /");
  	die();
  }
} else {
  $db = null;
  header("Location: /");
	die();
} ?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <!-- <meta property="og:image" content="https://cad.lscsd.ru/img/logo.png" />
  <link rel="shortcut icon" href="https://cad.lscsd.ru/img/logo.png" /> -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/general.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <title>Administration Panel | lscsd.ru</title>
</head>

<body>
  <header class="header-top">
    <div class="header-top__logo"></div>
    <div class="header-top__user">
      <span class="header-top__item"><?php echo ''.$result['username'].' '.$result['identifier'].''; ?></span>
      <nav class="header-top__nav">
        <ul>
          <li data-toggle="modal" data-target="#change-user-password">Сменить пароль</li>
          <li><a href="/actions/logout.php">Выйти</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <section class="content">
    <nav>
      <div class="header-left">
        <div class="header-left__items">
          <?php
        if ($result['type'] == 6 OR $result['type'] == 5) { ?>
          <div class="header-left__link">
            <a href="/admin.php">
              <div class="header-left__acp header-left__item header-left__item-active">
                <span>ACP</span>
              </div>
            </a>
          </div>
          <?php } ?>
          <?php
      if ($result['type'] == 6 OR $result['type'] == 5 OR $result['type'] == 4) { ?>
          <div class="header-left__link">
            <a href="/cad.php">
              <div class="header-left__database header-left__item">
                <span>CAD</span>
              </div>
            </a>
          </div>
          <?php } ?>
          <?php
      if ($result['type'] == 6 OR $result['type'] == 5 OR $result['type'] == 4 OR $result['type'] == 3) { ?>
          <div class="header-left__link">
            <a href="/mdt.php">
              <div class="header-left__database header-left__item">
                <span>MDT</span>
              </div>
            </a>
          </div>
          <?php } ?>
          <?php
      if ($result['type'] == 6 OR $result['type'] == 5 OR $result['type'] == 2 OR $result['type'] == 1) { ?>
          <div class="header-left__link">
            <a href="/database.php">
              <div class="header-left__database header-left__item">
                <span>DATABASE</span>
              </div>
            </a>
          </div>
          <?php } ?>
        </div>
      </div>
    </nav>
    <div class="container">
      <div class="sections">
        <div class="section">
          <div class="section__title">
            <h1>Статистика</h1>
          </div>
          <div class="section__statistics">
            <div class="section__statistic">
              <?php
          $query = $db->prepare("SELECT count(*) FROM `users` WHERE `activation` = 2");
          $query->execute();
          $results = $query->fetchColumn(); ?>
              <div class="section__name">
                <span>Всего пользователей</span>
              </div>
              <div class="section__number">
                <h1><?php echo $results; ?></h1>
              </div>
            </div>
            <?php
        $query = $db->prepare("SELECT count(*) FROM `users` WHERE `type` = 6 OR `type` = 5");
        $query->execute();
        $results = $query->fetchColumn(); ?>
            <div class="section__statistic">
              <div class="section__name">
                <span>Администраторов</span>
              </div>
              <div class="section__number">
                <h1><?php echo $results; ?></h1>
              </div>
            </div>
            <?php
        $query = $db->prepare("SELECT count(*) FROM `users` WHERE `type` = 4");
        $query->execute();
        $results = $query->fetchColumn(); ?>
            <div class="section__statistic">
              <div class="section__name">
                <span>Диспетчеров</span>
              </div>
              <div class="section__number">
                <h1><?php echo $results; ?></h1>
              </div>
            </div>
            <?php
        $query = $db->prepare("SELECT count(*) FROM `users` WHERE `type` = 3");
        $query->execute();
        $results = $query->fetchColumn(); ?>
            <div class="section__statistic">
              <div class="section__name">
                <span>Полиции</span>
              </div>
              <div class="section__number">
                <h1><?php echo $results; ?></h1>
              </div>
            </div>
            <?php
        $query = $db->prepare("SELECT count(*) FROM `users` WHERE `type` = 2");
        $query->execute();
        $results = $query->fetchColumn(); ?>
            <div class="section__statistic">
              <div class="section__name">
                <span>SADoC</span>
              </div>
              <div class="section__number">
                <h1><?php echo $results; ?></h1>
              </div>
            </div>
            <?php
        $query = $db->prepare("SELECT count(*) FROM `users` WHERE `type` = 1");
        $query->execute();
        $results = $query->fetchColumn(); ?>
            <div class="section__statistic">
              <div class="section__name">
                <span>Government</span>
              </div>
              <div class="section__number">
                <h1><?php echo $results; ?></h1>
              </div>
            </div>
          </div>
          <div class="block-buttons">
            <div class="block-buttons__button">
              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#members">СПИСОК
                ПОЛЬЗОВАТЕЛЕЙ</button>
            </div>
            <div class="block-buttons__button">
              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#log">ЛОГ
                АДМИНИСТРАТОРА</button>
            </div>
          </div>
          <div class="modal fade" id="members" tabindex="-1" role="dialog" aria-labelledby="membersLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 1075px;" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="members__header">
                    <h3 class="modal-title" id="membersLabel">СПИСОК ПОЛЬЗОВАТЕЛЕЙ</h3>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <?php
    $query = $db->prepare("SELECT * FROM `users` WHERE `activation` = '2'");
    $query->execute();
    $results = $query->fetchAll(); ?>
                  <div class="section__table">
                    <table class="table table-bordered table-dark table-striped" style="background: transparent;">
                      <thead>
                        <tr style="white-space: nowrap;">
                          <th scope="col">Никнейм</th>
                          <th scope="col">Email</th>
                          <th scope="col">Идентификатор</th>
                          <th scope="col">Роль</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
  for ($i = 0; $i < count($results); $i++) { ?>
                        <tr>
                          <td style="background: transparent;" scope="row"><?php echo $results[$i]['username'] ?></td>
                          <td style="background: transparent;" scope="row"><?php echo $results[$i]['email'] ?></td>
                          <td style="background: transparent;" scope="row"><?php echo $results[$i]['identifier'] ?></td>
                          <td style="background: transparent;" scope="row"><?php
    if ($results[$i]['type'] == 6) {
      echo 'Основатель';
    } else if ($results[$i]['type'] == 5) {
      echo 'Администратор';
    } else if ($results[$i]['type'] == 4) {
      echo 'Диспетчер';
    } else if ($results[$i]['type'] == 3) {
      echo 'Офицер';
    } else if ($results[$i]['type'] == 2) {
      echo 'SADoC';
    } else if ($results[$i]['type'] == 1) {
      echo 'Government';
    } ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="log" tabindex="-1" role="dialog" aria-labelledby="logLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 1075px;" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="log__header">
                    <h3 class="modal-title" id="logLabel">ЛОГ АДМИНИСТРАТОРА (ПОСЛЕДНИЕ 30 ДЕЙСТВИЙ)</h3>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <?php
    date_default_timezone_set('Europe/Moscow');
    $query = $db->prepare("SELECT * FROM `log` ORDER BY `id` DESC LIMIT 30");
    $query->execute();
    $results = $query->fetchAll(); ?>
                  <div class="section__table">
                    <table class="table table-bordered table-dark table-striped" style="background: transparent;">
                      <thead>
                        <tr style="white-space: nowrap;">
                          <th scope="col">Никнейм</th>
                          <th scope="col">IP-адрес</th>
                          <th scope="col">Дата</th>
                          <th scope="col">Действие</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
  for ($i = 0; $i < count($results); $i++) { ?>
                        <tr>
                          <td style="background: transparent;" scope="row"><?php
    $id = $results[$i]['user_id'];
    $query = $db->prepare("SELECT `username` FROM `users` WHERE `id` = '$id'");
    $query->execute();
    $name = $query->fetch();
    echo $name['username']; ?></td>
                          <td style="background: transparent;" scope="row"><?php echo $results[$i]['log_ip'] ?></td>
                          <td style="background: transparent;" scope="row">
                            <?php echo date("d.m.Y\nH:i", $results[$i]['log_time']) ?></td>
                          <td style="background: transparent;" scope="row"><?php echo $results[$i]['log_action'] ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sections">
        <div class="section">
          <div class="section__title">
            <h1>Управление аккаунтами</h1>
          </div>
          <div class="section__management">
            <div class="section__settings">
              <form name="change-password" id="change-password">
                <div class="form__input">
                  <input type="text" name="username" placeholder="Введите никнейм" required>
                </div>
                <div class="form__input">
                  <input type="password" name="new-password" placeholder="Введите новый пароль" required>
                </div>
                <div class="form__input">
                  <input type="password" name="new-password-verify" placeholder="Подтвердите новый пароль" required>
                </div>
                <button type="submit" class="btn btn-primary">Изменить</button>
                <div class="form__result">

                </div>
              </form>
            </div>
            <div class="section__settings">
              <form name="change-identifier" id="change-identifier">
                <div class="form__input">
                  <input type="text" name="username" placeholder="Введите никнейм" required>
                </div>
                <div class="form__input">
                  <input type="text" name="new-identifier" placeholder="Введите новый идентификатор" required>
                </div>
                <button type="submit" class="btn btn-primary">Изменить</button>
                <div class="form__result">

                </div>
              </form>
            </div>
            <div class="section__settings">
              <form name="change-username" id="change-username">
                <div class="form__input">
                  <input type="text" name="username" placeholder="Введите никнейм" required>
                </div>
                <div class="form__input">
                  <input type="text" name="new-username" placeholder="Введите новый никнейм" required>
                </div>
                <button type="submit" class="btn btn-primary">Изменить</button>
                <div class="form__result">

                </div>
              </form>
            </div>
            <div class="section__settings">
              <form name="change-type" id="change-type">
                <div class="form__input">
                  <input type="text" name="username" placeholder="Введите никнейм" required>
                </div>
                <input type="hidden" name="new-type" id="new-type">
                <div class="form__input">
                  <div class="select select__role">
                    <div class="select_checked">Выберите роль</div>
                    <ul class="select__dropdown">
                      <?php if ($result['type'] == 6) { ?>
                      <li class="select__option" data-value="6">Основатель</li>
                      <li class="select__option" data-value="5">Администратор</li>
                      <?php } ?>
                      <li class="select__option" data-value="4">Диспетчер</li>
                      <li class="select__option" data-value="3">Офицер</li>
                      <li class="select__option" data-value="2">SADoC</li>
                      <li class="select__option" data-value="1">Government</li>
                    </ul>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Изменить</button>
                <div class="form__result">

                </div>
              </form>
            </div>
          </div>
          <div class="section__management">
            <div class="section__settings">
              <form name="delete-username" id="delete-username">
                <div class="form__input">
                  <input type="hidden" name="username-delete" value="verify">
                  <input type="text" name="username" placeholder="Введите никнейм" required>
                </div>
                <button type="submit" class="btn btn-primary">Удалить аккаунт</button>
                <div class="form__result">

                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="sections">
        <div class="section">
          <div class="section__title">
            <h1>Запросы доступа</h1>
          </div>
          <?php
          $query = $db->prepare("SELECT * FROM `users` WHERE `activation` = '0' OR `activation` = '1'");
          $query->execute();
          $results = $query->fetchAll(); ?>
          <div class="section__table">
            <table class="table table-bordered table-dark table-striped" style="background: transparent;">
              <thead>
                <tr style="white-space: nowrap;">
                  <th scope="col">Никнейм</th>
                  <th scope="col">Email</th>
                  <th scope="col">Идентификатор</th>
                  <th scope="col">Действия</th>
                </tr>
              </thead>
              <tbody>
                <?php
        for ($i = 0; $i < count($results); $i++) { ?>
                <tr>
                  <td style="background: transparent;" scope="row"><?php echo $results[$i]['username'] ?></td>
                  <td style="background: transparent;" scope="row"><?php echo $results[$i]['email'] ?></td>
                  <td style="background: transparent;" scope="row"><?php echo $results[$i]['identifier'] ?></td>
                  <td style="background: transparent;" scope="row">
                    <?php if ($results[$i]['activation'] == 1) {
              echo 'В процессе активации.';
            } else {  ?>
                    <input type="submit" class="table-btn" data-toggle="modal" data-target="#accept"
                      data-value="<?php echo $results[$i]['id'] ?>" data-name="<?php echo $results[$i]['username'] ?>"
                      value="Одобрить">
                    <input type="submit" class="table-btn" data-toggle="modal" data-target="#denied"
                      data-value="<?php echo $results[$i]['id'] ?>" data-name="<?php echo $results[$i]['username'] ?>"
                      value="Отклонить">
                    <?php } ?>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal fade" id="accept" tabindex="-1" role="dialog" aria-labelledby="acceptLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <form name="accept" id="accept-form">
              <div class="modal-header">
                <div class="accept__header">
                  <h3 class="modal-title" id="logLabel">ОДОБРЕНИЕ ЗАПРОСА</h3>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="username" id="username1">
                <input type="hidden" name="request-id" id="request-id">
                <input type="hidden" name="type" id="type">
                <div class="select select__type">
                  <div class="select_checked">Выберите роль</div>
                  <ul class="select__dropdown">
                    <?php if ($result['type'] == 6) { ?>
                    <li class="select__option" data-value="6">Основатель</li>
                    <li class="select__option" data-value="5">Администратор</li>
                    <?php } ?>
                    <li class="select__option" data-value="4">Диспетчер</li>
                    <li class="select__option" data-value="3">Офицер</li>
                    <li class="select__option" data-value="2">SADoC</li>
                    <li class="select__option" data-value="1">Government</li>
                  </ul>
                </div>
              </div>
              <div class="modal-footer" style="justify-content: space-between;">
                <div class="accept__result">

                </div>
                <button type="submit" class="btn btn-primary">Одобрить</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="denied" tabindex="-1" role="dialog" aria-labelledby="deniedLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <form name="denied" id="denied-form">
              <div class="modal-header">
                <div class="denied__header">
                  <h3 class="modal-title" id="logLabel">ОТКЛОНЕНИЕ ЗАПРОСА</h3>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="username" id="username2">
                <input type="hidden" name="request-id" id="denied-id">
                <div class="form__input">
                  <input type="text" name="information" placeholder="Введите причину" required>
                </div>
              </div>
              <div class="modal-footer" style="justify-content: space-between;">
                <div class="denied__result">

                </div>
                <button type="submit" class="btn btn-primary">Отклонить</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="change-user-password" tabindex="-1" role="dialog"
        aria-labelledby="change-passwordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <form name="change-password" id="change-password_form">
              <input type="hidden" name="change-password-id" id="change-password-id">
              <div class="modal-header">
                <div class="edit__header">
                  <h3 class="modal-title" id="change-passwordLabel">СМЕНА ПАРОЛЯ</h3>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="change-password">
                  <div class="form__input">
                    <p>ТЕКУЩИЙ ПАРОЛЬ:</p>
                    <input type="password" name="password" required>
                  </div>
                  <div class="form__input">
                    <p>НОВЫЙ ПАРОЛЬ:</p>
                    <input type="password" name="new-password" required>
                  </div>
                  <div class="form__input">
                    <p style="width: 165px;">ПОДТВЕРДИТЕ НОВЫЙ ПАРОЛЬ:</p>
                    <input type="password" name="new-password-verify" required>
                  </div>
                </div>
              </div>
              <div class="modal-footer" style="justify-content: space-between;">
                <div class="change-password__result">

                </div>
                <button type="submit" class="btn btn-primary">Сменить</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
  </section>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
  <script src="js/main.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
<?php $db = null; ?>