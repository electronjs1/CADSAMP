<?php include_once 'config.php';
if (isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  include 'actions/auth.php';
  $query = $db->prepare("SELECT * FROM `users` WHERE `id` = :user_id");
  $values = ['user_id' => $session_user_id];
  $query->execute($values);
  $result = $query->fetch();
  if ($result['type'] != 6 AND $result['type'] != 5 AND $result['type'] != 2 AND $result['type'] != 1) {
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
  <title>Database | lscsd.ru</title>
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
      <div class="header-left" style="height: 100vh;">
        <div class="header-left__items">
          <?php
        if ($result['type'] == 6 OR $result['type'] == 5) { ?>
          <div class="header-left__link">
            <a href="/admin.php">
              <div class="header-left__acp header-left__item">
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
              <div class="header-left__database header-left__item header-left__item-active">
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
            <h1>Поиск по имени NCIC</h1>
          </div>
          <div class="section__content">
            <input type="hidden" id="select-civil">
            <div class="select database__select">
              <div class="select_checked">Выберите гражданского</div>
              <ul class="select__dropdown">
                <input type="text" class="search-input">
                <div class="response-result"></div>
              </ul>
            </div>
            <div class="section__search-block">
              <button type="button" class="btn btn-primary" id="search-button">Найти</button>
            </div>
          </div>
          <div class="section__search-result">
            <div class="search-result">

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
        <div class="modal fade" id="edit-pf" tabindex="-1" role="dialog" aria-labelledby="edit-pfLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <form name="edit-pf" id="edit-pf_form">
                <input type="hidden" name="edit-pf-id" id="edit-pf-id">
                <div class="modal-header">
                  <div class="edit__header">
                    <h3 class="modal-title" id="edit-pfLabel">РЕДАКТИРОВАНИЕ ЛИЧНОГО ДЕЛА</h3>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="edit-pf">
                    <div class="form__input">
                      <p>ИМЯ ФАМИЛИЯ:</p>
                      <input type="text" name="name" id="namee" required>
                    </div>
                    <div class="form__input">
                      <p>ДАТА РОЖДЕНИЯ:</p>
                      <input type="text" name="dob" id="dob" required>
                    </div>
                    <div class="form__input">
                      <p>ПОЛ:</p>
                      <input type="hidden" name="sex" id="edit-sex-select">
                      <div class="select form__select edit-pf-sex__select">
                        <div class="select_checked"></div>
                        <ul class="select__dropdown">
                          <li class="select__option" data-value="1">Неизвестно</li>
                          <li class="select__option" data-value="2">Мужской</li>
                          <li class="select__option" data-value="3">Женский</li>
                        </ul>
                      </div>
                    </div>
                    <div class="form__input">
                        <p>РАСА:</p>
                        <input type="hidden" name="race" id="edit-race-select">
                        <div class="select form__select edit-pf-race__select">
                            <div class="select_checked"></div>
                            <ul class="select__dropdown">
                                <li class="select__option" data-value="1">Неизвестно</li>
                                <li class="select__option" data-value="2">Белый / Европеоид</li>
                                <li class="select__option" data-value="3">Афроамериканец</li>
                                <li class="select__option" data-value="4">Латиноамериканец</li>
                                <li class="select__option" data-value="5">Араб</li>
                                <li class="select__option" data-value="6">Азиат</li>
                            </ul>
                        </div>
                    </div>
                    <div class="form__input">
                      <p>СЕМЕЙНОЕ ПОЛОЖЕНИЕ:</p>
                      <input type="hidden" name="marital-status" id="edit-marital-select">
                      <div class="select form__select edit-pf-marital__select">
                        <div class="select_checked"></div>
                        <ul class="select__dropdown">
                          <li class="select__option" data-value="1">Неизвестно</li>
                          <li class="select__option" data-value="2">Женат (-замужем)</li>
                          <li class="select__option" data-value="3">Не женат (-не замужем)</li>
                        </ul>
                      </div>
                    </div>
                    <div class="form__input">
                      <p>МЕСТО ПРОЖИВАНИЯ:</p>
                      <input type="text" name="por" id="por" required>
                    </div>
                    <div class="form__input">
                      <p>ID СКИНА:</p>
                      <input type="text" name="skin" id="skin" required>
                    </div>
                  </div>
                </div>
                <div class="modal-footer" style="justify-content: space-between;">
                  <div class="edit-pf__result">

                  </div>
                  <button type="submit" class="btn btn-primary">Применить</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <audio src="sounds/signal100.mp3" id="signal100"></audio>
    <audio src="sounds/panic.mp3" id="panic"></audio>
  </section>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
  <script src="https://www.google.com/jsapi"></script>
  <script src="https://maps.google.com/maps/api/js?key=AIzaSyBqS0oz9UmAzybBe5WOslQO_qE95TzMFbc"></script>
  <script src="js/main.js"></script>
  <script src="js/SanMap.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
<?php $db = null; ?>