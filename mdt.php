<?php include_once 'config.php';
if (isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  include 'actions/auth.php';
  $query = $db->prepare("SELECT * FROM `users` WHERE `id` = :user_id");
  $values = ['user_id' => $session_user_id];
  $query->execute($values);
  $result = $query->fetch();
  if ($result['type'] != 6 AND $result['type'] != 5 AND $result['type'] != 4 AND $result['type'] != 3) {
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
  <title>Mobile Data Terminal (MDT) | lscsd.ru</title>
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
              <div class="header-left__database header-left__item header-left__item-active">
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
          <div class="panic-block">
            <div class="panic-block__button" id="notifications">

            </div>
            <div class="panic-block__description">
              <p>Активируйте одиночным нажатием в экстренной ситуации или при прямой угрозе Вашей жизни в случае, если
                Вы не можете передать информацию по рации.</p>
            </div>
          </div>
          <div class="unit-information">
            <div class="unit-information__description">
              <h3>Юнит <?php echo $result['identifier']; ?></h3>
              <h3><?php echo $result['username']; ?></h3>
            </div>
            <div class="unit-information__status" id="status">

            </div>
            <div class="unit-information__button-status">
              <div class="select unit-information__select">
                <div class="select_checked">Выберите статус</div>
                <ul class="select__dropdown">
                  <li class="select__option" data-value="10-8 | ДОСТУПЕН">10-8 | ДОСТУПЕН</li>
                  <li class="select__option" data-value="10-7 | ВНЕ СЛУЖБЫ">10-7 | ВНЕ СЛУЖБЫ</li>
                  <li class="select__option" data-value="10-6 | ЗАНЯТ">10-6 | ЗАНЯТ</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="block-buttons block-border">
            <div class="block-buttons__button">
              <form action="https://forum.mh-rp.ru/threads/Уголовный-кодекс.3868/" target='btn btn-dark'>
                <button type="button" class="btn btn-dark">УГОЛОВНЫЙ КОДЕКС</button>
              </form>
            </div>
            <div class="block-buttons__button">
              <form action="https://forum.mh-rp.ru/threads/Административный-кодекс.3845/">
                <button type="button" class="btn btn-dark">АДМИНИСТРАТИВНЫЙ КОДЕКС</button>
              </form>
            </div>
            <div class="block-buttons__button">
              <form action="https://forum.mh-rp.ru/threads/Уголовно-процессуальный-кодекс.3838/">
                <button type="button" class="btn btn-dark">ДОРОЖНЫЙ КОДЕКС</button>
              </form>
            </div>
            <div class="block-buttons__button">
              <form action="https://lscsd.ru/index.php?forums/los-santos-county-sheriff-manual.175/">
                <button type="button" class="btn btn-dark">СПРАВОЧНИК ПОЛИЦЕЙСКОГО</button>
              </form>
            </div>
            <div class="block-buttons__button">
              <form action="https://imgur.com/a/7ciDJEw">
                <button type="button" class="btn btn-dark">ФОНЕТИЧЕСКИЙ СЛОВАРЬ</button>
              </form>
            </div>
          </div>
          <div class="block-buttons">
            <div class="block-buttons__button_without_merg">
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#vehicle-boloo">BOLO
                (Автомобили)</button>
            </div>
            <div class="block-buttons__button__down">
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#people-boloo">BOLO
                (Люди)</button>
            </div>
          </div>
          <div class="modal fade" id="people-boloo" tabindex="-1" role="dialog" aria-labelledby="people-boloLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 1075px;" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="create__header">
                    <h3 class="modal-title" id="people-boloLabel">BOLO (ЛЮДИ)</h3>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="section__table" id="pbolo">

                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="vehicle-boloo" tabindex="-1" role="dialog" aria-labelledby="vehicle-boloLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 1380px;" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="create__header">
                    <h3 class="modal-title" id="vehicle-boloLabel">BOLO (АВТОМОБИЛИ)</h3>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="section__table" id="vbolo">

                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="section">
          <div class="section__title">
            <h1>Активные вызовы</h1>
          </div>
          <div class="section__table">
            <div id="calls-table">

            </div>
          </div>
          <div class="section__title">
            <h1>Активный вызов</h1>
          </div>
          <div class="section__table">
            <div id="call-table">

            </div>
          </div>
        </div>
      </div>
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
            <div class="search-result__buttons">
              <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#create-violation">Добавить
                нарушение</button>
              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#create-warning">Добавить
                предупреждение</button>
              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#create-pf">Создать личное
                дело</button>
            </div>
            <div class="modal fade" id="create-violation" tabindex="-1" role="dialog"
              aria-labelledby="create-violationLabel" aria-hidden="true">
              <div class="modal-dialog" role="document" style="max-width: 850px;">
                <div class="modal-content">
                  <form name="create-violation" id="create-violation_form">
                    <div class="modal-header">
                      <div class="create__header">
                        <div class="create__logo">
                          <img src="img/department.png">
                          <img src="img/department2.png">
                        </div>
                        <h3 class="modal-title" id="create-violationLabel">ДОБАВИТЬ НАРУШЕНИЕ</h3>
                      </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="create">
                        <table class="table table-bordered" style="color: #fff;">
                          <tbody>
                            <tr>
                              <?php
      date_default_timezone_set('Europe/Moscow');
      $time = time();
      $user_id = htmlspecialchars($_COOKIE['cad_u']);
      $query = $db->prepare("SELECT * FROM `users` WHERE `id` = :user_id");
      $values = ['user_id' => $user_id];
      $query->execute($values);
      $result = $query->fetch(); ?>
                              <td style="padding-top: 20px; background: transparent;">SAN ANDREAS DEPARTMENT OF JUSTICE
                                // СУДЕБНОЕ УВЕДОМЛЕНИЕ</td>
                              <td style="width: 25%; white-space: nowrap; background: transparent;">ДАТА:
                                <?php echo date("d.m.Y", $time); ?><br>
                                ВРЕМЯ: <?php echo date("H:i", $time); ?></td>
                            </tr>
                            <tr>
                              <td style="padding-top: 20px; background: transparent;">ДЛЯ НАРУШЕНИЙ ПЕНАЛ КОДА И
                                ДОРОЖНЫХ ЗАКОНОВ</td>
                              <td style="background: transparent; white-space: no-wrap;">ОФИЦЕР
                                <?php echo $result['username']; ?><br>
                                ПОЗЫВНОЙ <?php echo $result['identifier']; ?></td>
                            </tr>
                          </tbody>
                        </table>
                        <input type="hidden" name="violation-select-civil" id="violation-select-civil">
                        <div class="select create-violation__select create__select">
                          <div class="select_checked">Выберите гражданского</div>
                          <ul class="select__dropdown">
                            <input type="text" class="search-input">
                            <div class="response-result"></div>
                          </ul>
                        </div>
                        <div class="form__input create__input">
                          <input type="text" name="name-article" placeholder="Введите полное название статьи" required>
                        </div>
                        <div class="form__input create__input">
                          <input type="text" name="name-street" placeholder="Введите основную улицу" required>
                        </div>
                        <div class="form__input form__autoarrest">
                          <input type="checkbox" name="autoarrest">
                          <label>Арест</label>
                        </div>
                        <div class="autoarrest__description">
                          <p>Отметьте в случае, если нарушение подразумевает арест человека и он будет арестован.
                            Отсутствие отметки означает, что за нарушение был выписан штраф, а человек был отпущен.</p>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" style="justify-content: space-between;">
                      <div class="create-violation__result">

                      </div>
                      <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="modal fade" id="create-warning" tabindex="-1" role="dialog"
              aria-labelledby="create-warningLabel" aria-hidden="true">
              <div class="modal-dialog" role="document" style="max-width: 850px;">
                <div class="modal-content">
                  <form name="create-warning" id="create-warning_form">
                    <div class="modal-header">
                      <div class="create__header">
                        <div class="create__logo">
                          <img src="img/department.png">
                          <img src="img/department2.png">
                        </div>
                        <h3 class="modal-title" id="create-warningLabel">ДОБАВИТЬ ПРЕДУПРЕЖДЕНИЕ</h3>
                      </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="create">
                        <table class="table table-bordered" style="color: #fff;">
                          <tbody>
                            <tr>
                              <?php
      date_default_timezone_set('Europe/Moscow');
      $time = time();
      $user_id = htmlspecialchars($_COOKIE['cad_u']);
      $query = $db->prepare("SELECT * FROM `users` WHERE `id` = :user_id");
      $values = ['user_id' => $user_id];
      $query->execute($values);
      $result = $query->fetch(); ?>
                              <td style="padding-top: 20px; background: transparent;">SAN ANDREAS DEPARTMENT OF JUSTICE
                                // СУДЕБНОЕ УВЕДОМЛЕНИЕ</td>
                              <td style="width: 25%; white-space: nowrap; background: transparent;">ДАТА:
                                <?php echo date("d.m.Y", $time); ?><br>
                                ВРЕМЯ: <?php echo date("H:i", $time); ?></td>
                            </tr>
                            <tr>
                              <td style="padding-top: 20px; background: transparent;">ДЛЯ НАРУШЕНИЙ ПЕНАЛ КОДА И
                                ДОРОЖНЫХ ЗАКОНОВ</td>
                              <td style="background: transparent; white-space: no-wrap;">ОФИЦЕР
                                <?php echo $result['username']; ?><br>
                                ПОЗЫВНОЙ <?php echo $result['identifier']; ?></td>
                            </tr>
                          </tbody>
                        </table>
                        <input type="hidden" name="warning-select-civil" id="warning-select-civil">
                        <div class="select create-warning__select create__select">
                          <div class="select_checked">Выберите гражданского</div>
                          <ul class="select__dropdown">
                            <input type="text" class="search-input">
                            <div class="response-result"></div>
                          </ul>
                        </div>
                        <div class="form__input create__input">
                          <input type="text" name="name-article" placeholder="Введите полное название статьи" required>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" style="justify-content: space-between;">
                      <div class="create-warning__result">

                      </div>
                      <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="modal fade" id="create-pf" tabindex="-1" role="dialog" aria-labelledby="create-pfLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form name="create-pf" id="create-pf_form">
                    <div class="modal-header">
                      <div class="create__header">
                        <div class="create__logo">
                          <img src="img/department.png">
                        </div>
                        <h3 class="modal-title" id="create-pfLabel">СОЗДАНИЕ ЛИЧНОГО ДЕЛА</h3>
                      </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="create-pf">
                        <div class="form__input">
                          <p>ИМЯ ФАМИЛИЯ:</p>
                          <input type="text" name="name" required placeholder="Jhon Jhonson">
                        </div>
                        <div class="form__input">
                          <p>ДАТА РОЖДЕНИЯ:</p>
                          <input type="text" name="dob" required placeholder="Январь 01, 1999">
                        </div>
                        <div class="form__input">
                          <p>ПОЛ:</p>
                          <input type="hidden" name="sex" id="create-sex-select">
                          <div class="select form__select create-pf-sex__select">
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
                            <input type="hidden" name="race" id="create-race-select">
                            <div class="select form__select create-pf-race__select">
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
                          <input type="hidden" name="marital-status" id="create-marital-select">
                          <div class="select form__select create-pf-marital__select">
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
                          <input type="text" name="por" required placeholder="Место проживания">
                        </div>
                        <div class="form__input">
                          <p>ID СКИНА:</p>
                          <input type="text" name="skin" required placeholder="111">
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" style="justify-content: space-between;">
                      <div class="create-pf__result">

                      </div>
                      <button type="submit" class="btn btn-primary">Создать</button>
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
      </div>
    </div>
    <audio src="sounds/signal100.mp3" id="signal100"></audio>
    <audio src="sounds/panic.mp3" id="panic"></audio>
    <audio src="sounds/notification.mp3" id="notification"></audio>
  </section>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
  <script src="js/main.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
<?php include_once 'config.php';
include 'actions/auth.php';
if (isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  $db = null;
  $query = $db->prepare("SELECT * FROM `users` WHERE `id` = :user_id");
  $values = ['user_id' => $session_user_id];
  $query->execute($values);
  $result = $query->fetch();
  if ($result['type'] != 6 AND $result['type'] != 5 AND $result['type'] != 4 AND $result['type'] != 3) {
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
  <title>MDT | PATROL</title>
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
              <div class="header-left__database header-left__item header-left__item-active">
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
          <div class="panic-block">
            <div class="panic-block__button" id="notifications">

            </div>
            <div class="panic-block__description">
              <p>Активируйте одиночным нажатием в экстренной ситуации или при прямой угрозе Вашей жизни в случае, если
                Вы не можете передать информацию по рации.</p>
            </div>
          </div>
          <div class="unit-information">
            <div class="unit-information__description">
              <h3>Юнит <?php echo $result['identifier']; ?></h3>
              <h3><?php echo $result['username']; ?></h3>
            </div>
            <div class="unit-information__status" id="status">

            </div>
            <div class="unit-information__button-status">
              <div class="select unit-information__select">
                <div class="select_checked">Выберите статус</div>
                <ul class="select__dropdown">
                  <li class="select__option" data-value="10-8 | ДОСТУПЕН">10-8 | ДОСТУПЕН</li>
                  <li class="select__option" data-value="10-7 | ВНЕ СЛУЖБЫ">10-7 | ВНЕ СЛУЖБЫ</li>
                  <li class="select__option" data-value="10-6 | ЗАНЯТ">10-6 | ЗАНЯТ</li>
                </ul>
              </div>
              <div class="form__input">
                <p>МАРКИРОВКА:</p>
                <input type="text" name="mark" required placeholder="2W10">
              </div>
              </div>
            </div>
          </div>
          <div class="block-buttons block-border">
            <div class="block-buttons__button">
              <form action="https://forum.mh-rp.ru/threads/Уголовный-кодекс.3868/">
                <button type="button" class="btn btn-dark">УГОЛОВНЫЙ КОДЕКС</button>
              </form>
            </div>
            <div class="block-buttons__button">
              <form action="https://forum.mh-rp.ru/threads/Административный-кодекс.3845/">
                <button type="button" class="btn btn-dark">АДМИНИСТРАТИВНЫЙ КОДЕКС</button>
              </form>      
            </div>
            <div class="block-buttons__button">
              <form action="https://forum.mh-rp.ru/threads/Уголовно-процессуальный-кодекс.3838/">
                <button type="button" class="btn btn-dark">ДОРОЖНЫЙ КОДЕКС</button>
              </form>
            </div>
            <div class="block-buttons__button">
              <form action="https://lscsd.ru/index.php?forums/los-santos-county-sheriff-manual.175/">
                <button type="button" class="btn btn-dark">СПРАВОЧНИК ПОЛИЦЕЙСКОГО</button>
              </form>
            </div>
            <div class="block-buttons__button">
              <form action="https://imgur.com/a/7ciDJEw">
                <button type="button" class="btn btn-dark">ФОНЕТИЧЕСКИЙ СЛОВАРЬ</button>
              </form>
            </div>
          </div>
          <div class="block-buttons">
            <div class="block-buttons__button_without_merg">
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#vehicle-boloo">BOLO
                (Автомобили)</button>
            </div>
            <div class="block-buttons__button__down">
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#people-boloo">BOLO
                (Люди)</button>
            </div>
          </div>
          <div class="modal fade" id="people-boloo" tabindex="-1" role="dialog" aria-labelledby="people-boloLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 1075px;" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="create__header">
                    <h3 class="modal-title" id="people-boloLabel">BOLO (ЛЮДИ)</h3>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="section__table" id="pbolo">

                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="vehicle-boloo" tabindex="-1" role="dialog" aria-labelledby="vehicle-boloLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 1380px;" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="create__header">
                    <h3 class="modal-title" id="vehicle-boloLabel">BOLO (АВТОМОБИЛИ)</h3>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="section__table" id="vbolo">

                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="section">
          <div class="section__title">
            <h1>Активные вызовы</h1>
          </div>
          <div class="section__table">
            <div id="calls-table">

            </div>
          </div>
          <div class="section__title">
            <h1>Активный вызов</h1>
          </div>
          <div class="section__table">
            <div id="call-table">

            </div>
          </div>
        </div>
      </div>
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
            <div class="search-result__buttons">
              <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#create-violation">Добавить
                нарушение</button>
              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#create-warning">Добавить
                предупреждение</button>
              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#create-pf">Создать личное
                дело</button>
            </div>
            <div class="modal fade" id="create-violation" tabindex="-1" role="dialog"
              aria-labelledby="create-violationLabel" aria-hidden="true">
              <div class="modal-dialog" role="document" style="max-width: 850px;">
                <div class="modal-content">
                  <form name="create-violation" id="create-violation_form">
                    <div class="modal-header">
                      <div class="create__header">
                        <div class="create__logo">
                          <img src="img/department.png">
                          <img src="img/department2.png">
                        </div>
                        <h3 class="modal-title" id="create-violationLabel">ДОБАВИТЬ НАРУШЕНИЕ</h3>
                      </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="create">
                        <table class="table table-bordered" style="color: #fff;">
                          <tbody>
                            <tr>
                              <?php
      date_default_timezone_set('Europe/Moscow');
      $time = time();
      $user_id = htmlspecialchars($_COOKIE['cad_u']);
      $query = $db->prepare("SELECT * FROM `users` WHERE `id` = :user_id");
      $values = ['user_id' => $user_id];
      $query->execute($values);
      $result = $query->fetch(); ?>
                              <td style="padding-top: 20px; background: transparent;">SAN ANDREAS DEPARTMENT OF JUSTICE
                                // СУДЕБНОЕ УВЕДОМЛЕНИЕ</td>
                              <td style="width: 25%; white-space: nowrap; background: transparent;">ДАТА:
                                <?php echo date("d.m.Y", $time); ?><br>
                                ВРЕМЯ: <?php echo date("H:i", $time); ?></td>
                            </tr>
                            <tr>
                              <td style="padding-top: 20px; background: transparent;">ДЛЯ НАРУШЕНИЙ ПЕНАЛ КОДА И
                                ДОРОЖНЫХ ЗАКОНОВ</td>
                              <td style="background: transparent; white-space: no-wrap;">ОФИЦЕР
                                <?php echo $result['username']; ?><br>
                                ПОЗЫВНОЙ <?php echo $result['identifier']; ?></td>
                            </tr>
                          </tbody>
                        </table>
                        <input type="hidden" name="violation-select-civil" id="violation-select-civil">
                        <div class="select create-violation__select create__select">
                          <div class="select_checked">Выберите гражданского</div>
                          <ul class="select__dropdown">
                            <input type="text" class="search-input">
                            <div class="response-result"></div>
                          </ul>
                        </div>
                        <div class="form__input create__input">
                          <input type="text" name="name-article" placeholder="Введите полное название статьи" required>
                        </div>
                        <div class="form__input create__input">
                          <input type="text" name="name-street" placeholder="Введите основную улицу" required>
                        </div>
                        <div class="form__input form__autoarrest">
                          <input type="checkbox" name="autoarrest">
                          <label>Арест</label>
                        </div>
                        <div class="autoarrest__description">
                          <p>Отметьте в случае, если нарушение подразумевает арест человека и он будет арестован.
                            Отсутствие отметки означает, что за нарушение был выписан штраф, а человек был отпущен.</p>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" style="justify-content: space-between;">
                      <div class="create-violation__result">

                      </div>
                      <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="modal fade" id="create-warning" tabindex="-1" role="dialog"
              aria-labelledby="create-warningLabel" aria-hidden="true">
              <div class="modal-dialog" role="document" style="max-width: 850px;">
                <div class="modal-content">
                  <form name="create-warning" id="create-warning_form">
                    <div class="modal-header">
                      <div class="create__header">
                        <div class="create__logo">
                          <img src="img/department.png">
                          <img src="img/department2.png">
                        </div>
                        <h3 class="modal-title" id="create-warningLabel">ДОБАВИТЬ ПРЕДУПРЕЖДЕНИЕ</h3>
                      </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="create">
                        <table class="table table-bordered" style="color: #fff;">
                          <tbody>
                            <tr>
                              <?php
      date_default_timezone_set('Europe/Moscow');
      $time = time();
      $user_id = htmlspecialchars($_COOKIE['cad_u']);
      $query = $db->prepare("SELECT * FROM `users` WHERE `id` = :user_id");
      $values = ['user_id' => $user_id];
      $query->execute($values);
      $result = $query->fetch(); ?>
                              <td style="padding-top: 20px; background: transparent;">SAN ANDREAS DEPARTMENT OF JUSTICE
                                // СУДЕБНОЕ УВЕДОМЛЕНИЕ</td>
                              <td style="width: 25%; white-space: nowrap; background: transparent;">ДАТА:
                                <?php echo date("d.m.Y", $time); ?><br>
                                ВРЕМЯ: <?php echo date("H:i", $time); ?></td>
                            </tr>
                            <tr>
                              <td style="padding-top: 20px; background: transparent;">ДЛЯ НАРУШЕНИЙ ПЕНАЛ КОДА И
                                ДОРОЖНЫХ ЗАКОНОВ</td>
                              <td style="background: transparent; white-space: no-wrap;">ОФИЦЕР
                                <?php echo $result['username']; ?><br>
                                ПОЗЫВНОЙ <?php echo $result['identifier']; ?></td>
                            </tr>
                          </tbody>
                        </table>
                        <input type="hidden" name="warning-select-civil" id="warning-select-civil">
                        <div class="select create-warning__select create__select">
                          <div class="select_checked">Выберите гражданского</div>
                          <ul class="select__dropdown">
                            <input type="text" class="search-input">
                            <div class="response-result"></div>
                          </ul>
                        </div>
                        <div class="form__input create__input">
                          <input type="text" name="name-article" placeholder="Введите полное название статьи" required>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" style="justify-content: space-between;">
                      <div class="create-warning__result">

                      </div>
                      <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="modal fade" id="create-pf" tabindex="-1" role="dialog" aria-labelledby="create-pfLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form name="create-pf" id="create-pf_form">
                    <div class="modal-header">
                      <div class="create__header">
                        <div class="create__logo">
                          <img src="img/department.png">
                        </div>
                        <h3 class="modal-title" id="create-pfLabel">СОЗДАНИЕ ЛИЧНОГО ДЕЛА</h3>
                      </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="create-pf">
                        <div class="form__input">
                          <p>ИМЯ ФАМИЛИЯ:</p>
                          <input type="text" name="name" required>
                        </div>
                        <div class="form__input">
                          <p>ДАТА РОЖДЕНИЯ:</p>
                          <input type="text" name="dob" required>
                        </div>
                        <div class="form__input">
                          <p>ПОЛ:</p>
                          <input type="hidden" name="sex" id="create-sex-select">
                          <div class="select form__select create-pf-sex__select">
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
                            <input type="hidden" name="race" id="create-race-select">
                            <div class="select form__select create-pf-race__select">
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
                          <input type="hidden" name="marital-status" id="create-marital-select">
                          <div class="select form__select create-pf-marital__select">
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
                          <input type="text" name="por" required>
                        </div>
                        <div class="form__input">
                          <p>ID СКИНА:</p>
                          <input type="text" name="skin" required>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" style="justify-content: space-between;">
                      <div class="create-pf__result">

                      </div>
                      <button type="submit" class="btn btn-primary">Создать</button>
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
      </div>
    </div>
    <audio src="sounds/signal100.mp3" id="signal100"></audio>
    <audio src="sounds/panic.mp3" id="panic"></audio>
    <audio src="sounds/notification.mp3" id="notification"></audio>
  </section>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
  <script src="js/main.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
<?php $db = null; ?>