<?php include_once 'config.php';
if (isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  include 'actions/auth.php';
  $query = $db->prepare("SELECT * FROM `users` WHERE `id` = :user_id");
  $values = ['user_id' => $session_user_id];
  $query->execute($values);
  $result = $query->fetch();
  if ($result['type'] != 6 AND $result['type'] != 5 AND $result['type'] != 4) {
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
  <title>CAD | DISP</title>
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
              <div class="header-left__database header-left__item header-left__item-active">
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
            <h1>Активные вызовы</h1>
          </div>
          <div class="section__table">
            <div id="calls-table">

            </div>
          </div>
          <div class="block-buttons" style="margin-top: 0; justify-content: flex-start;">
            <div class="block-buttons__button">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-call">НОВЫЙ
                ВЫЗОВ</button>
            </div>
            <div class="block-buttons__button" id="notifications">

            </div>
          </div>
        </div>
        <div class="section">
          <div class="section__title">
            <h1>КАРТА ШТАТА</h1>
          </div>
          <div class="section__map">
            <div id="map-canvas"></div>
          </div>
        </div>
      </div>
      <div class="sections">
        <div class="section">
          <div class="section__title">
            <h1>Доступные юниты</h1>
          </div>
          <div class="section__table">
            <div id="available-units">

            </div>
          </div>
        </div>
        <div class="section">
          <div class="section__title">
            <h1>Недоступные юниты</h1>
          </div>
          <div class="section__table">
            <div id="unavailable-units">

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
            <div class="modal fade" id="create-call" tabindex="-1" role="dialog" aria-labelledby="create-callLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px;">
                <div class="modal-content">
                  <form name="create-call" id="create-call_form">
                    <div class="modal-header">
                      <div class="create__header">
                        <h3 class="modal-title" id="create-callLabel">НОВЫЙ ВЫЗОВ</h3>
                      </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="create">
                        <div class="form__input create-call">
                          <p>Тип вызова:</p>
                          <input type="hidden" name="select-call-type" id="select-call-type">
                          <div class="select create-call__select create__select">
                            <div class="select_checked"></div>
                            <ul class="select__dropdown">
                              <li class="select__option" data-value="1">911</li>
                              <li class="select__option" data-value="3">ЭКСТРЕННАЯ СИТУАЦИЯ</li>
                              <li class="select__option" data-value="4">ДТП</li>
                              <li class="select__option" data-value="5">ОСТАНОВКА ГРАЖДАНСКОГО</li>
                              <li class="select__option" data-value="6">ОСТАНОВКА ТРАНСПОРТА</li>
                              <li class="select__option" data-value="7">ПРЕСЛЕДОВАНИЕ</li>
                              <li class="select__option" data-value="8">ПЕРЕСТРЕЛКА</li>
                              <li class="select__option" data-value="9">ПРОЧЕЕ</li>
                            </ul>
                          </div>
                        </div>
                        <div class="form__input create-call">
                          <p>Адрес:</p>
                          <input type="text" name="call-location">
                        </div>
                        <div class="form__input create-call" style="align-items: start;">
                          <p>Информация по вызову:</p>
                          <textarea name="call-information" rows="8" cols="80"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" style="justify-content: space-between;">
                      <div class="create-call__result">

                      </div>
                      <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="modal fade" id="create-attach" tabindex="-1" role="dialog" aria-labelledby="create-attachLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="create__header">
                      <h3 class="modal-title" id="create-attachLabel">ПРИКРЕПИТЬ ЮНИТА</h3>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="create">
                      <input type="hidden" name="call-attach" id="call-attach">
                      <input type="hidden" name="select-unit" id="select-unit">
                      <div class="select create-attach__select create__select">
                        <div class="select_checked">Выберите юнита</div>
                        <ul class="select__dropdown">
                          <input type="text" class="search-unit" style="width: 92%;">
                          <div class="response-result"></div>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer" style="justify-content: space-between;">
                    <div class="create-attach__result">

                    </div>
                    <button type="submit" class="btn btn-primary" id="create-attach__submit">Прикрепить</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sections">
        <div class="section">
          <div class="section__title">
            <h1>Активные BOLO</h1>
          </div>
          <div class="section__table">
            <div id="people-bolo">

            </div>
          </div>
          <div class="section__table">
            <div id="vehicle-bolo">

            </div>
            <div class="modal fade" id="create-vehicle-bolo" tabindex="-1" role="dialog"
              aria-labelledby="create-vehicle-boloLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <form name="create-vehicle-bolo" id="create-vehicle-bolo_form">
                    <div class="modal-header">
                      <div class="create__header">
                        <h3 class="modal-title" id="create-vehicle-boloLabel">СОЗДАНИЕ BOLO (АВТОМОБИЛЬ)</h3>
                      </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="create-vehicle-bolo">
                        <div class="form__input">
                          <p>МАРКА АВТОМОБИЛЯ:</p>
                          <input type="text" name="model" required>
                        </div>
                        <div class="form__input">
                          <p>ЦВЕТ АВТОМОБИЛЯ:</p>
                          <input type="text" name="color" required>
                        </div>
                        <div class="form__input">
                          <p>НОМЕРА АВТОМОБИЛЯ:</p>
                          <input type="text" name="number" required>
                        </div>
                        <div class="form__input">
                          <p>ОСОБЕННОСТИ:</p>
                          <input type="text" name="features" required>
                        </div>
                        <div class="form__input">
                          <p style="width: 165px;">ПОСЛЕДНЕЕ МЕСТО ОБНАРУЖЕНИЯ:</p>
                          <input type="text" name="last-place" required>
                        </div>
                        <div class="form__input">
                          <p style="width: 165px;">ПОСЛЕДНЯЯ ДАТА ОБНАРУЖЕНИЯ:</p>
                          <input type="text" name="last-date" required>
                        </div>
                        <div class="form__input">
                          <p>РАЗЫСКИВАЕТСЯ ЗА:</p>
                          <input type="text" name="reason" required>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" style="justify-content: space-between;">
                      <div class="create-vehicle-bolo__result">

                      </div>
                      <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="modal fade" id="create-people-bolo" tabindex="-1" role="dialog"
              aria-labelledby="create-people-boloLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <form name="create-people-bolo" id="create-people-bolo_form">
                    <div class="modal-header">
                      <div class="create__header">
                        <h3 class="modal-title" id="create-people-boloLabel">СОЗДАНИЕ BOLO (ЧЕЛОВЕК)</h3>
                      </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="create-people-bolo">
                        <div class="form__input">
                          <p>ИМЯ:</p>
                          <input type="text" name="name" required>
                        </div>
                        <div class="form__input">
                          <p>ФАМИЛИЯ:</p>
                          <input type="text" name="surname" required>
                        </div>
                        <div class="form__input">
                          <p>ПОЛ:</p>
                          <input type="text" name="sex" required>
                        </div>
                        <div class="form__input">
                          <p style="width: 165px;">ОБЩЕЕ ОПИСАНИЕ ПОДОЗРЕВАЕМОГО:</p>
                          <input type="text" name="description" required>
                        </div>
                        <div class="form__input">
                          <p>ОБВИНЯЕТСЯ В:</p>
                          <input type="text" name="reason" required>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" style="justify-content: space-between;">
                      <div class="create-people-bolo__result">

                      </div>
                      <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="modal fade" id="edit-vehicle-bolo" tabindex="-1" role="dialog"
              aria-labelledby="edit-vehicle-boloLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <form name="edit-vehicle-bolo" id="edit-vehicle-bolo_form">
                    <input type="hidden" name="edit-vehicle-bolo-id" id="edit-vehicle-bolo-id">
                    <div class="modal-header">
                      <div class="edit__header">
                        <h3 class="modal-title" id="edit-vehicle-boloLabel">РЕДАКТИРОВАНИЕ BOLO (АВТОМОБИЛЬ)</h3>
                      </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="edit-vehicle-bolo">
                        <div class="form__input">
                          <p>МАРКА АВТОМОБИЛЯ:</p>
                          <input type="text" name="model" id="model" required>
                        </div>
                        <div class="form__input">
                          <p>ЦВЕТ АВТОМОБИЛЯ:</p>
                          <input type="text" name="color" id="color" required>
                        </div>
                        <div class="form__input">
                          <p>НОМЕРА АВТОМОБИЛЯ:</p>
                          <input type="text" name="number" id="number" required>
                        </div>
                        <div class="form__input">
                          <p>ОСОБЕННОСТИ:</p>
                          <input type="text" name="features" id="features" required>
                        </div>
                        <div class="form__input">
                          <p style="width: 165px;">ПОСЛЕДНЕЕ МЕСТО ОБНАРУЖЕНИЯ:</p>
                          <input type="text" name="last-place" id="last-place" required>
                        </div>
                        <div class="form__input">
                          <p style="width: 165px;">ПОСЛЕДНЯЯ ДАТА ОБНАРУЖЕНИЯ:</p>
                          <input type="text" name="last-date" id="last-date" required>
                        </div>
                        <div class="form__input">
                          <p>РАЗЫСКИВАЕТСЯ ЗА:</p>
                          <input type="text" name="reason" id="reason-vehicle" required>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" style="justify-content: space-between;">
                      <div class="edit-vehicle-bolo__result">

                      </div>
                      <button type="submit" class="btn btn-primary">Применить</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="modal fade" id="edit-people-bolo" tabindex="-1" role="dialog"
              aria-labelledby="edit-people-boloLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <form name="edit-people-bolo" id="edit-people-bolo_form">
                    <input type="hidden" name="edit-people-bolo-id" id="edit-people-bolo-id">
                    <div class="modal-header">
                      <div class="edit__header">
                        <h3 class="modal-title" id="edit-people-boloLabel">РЕДАКТИРОВАНИЕ BOLO (ЧЕЛОВЕК)</h3>
                      </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="edit-people-bolo">
                        <div class="form__input">
                          <p>ИМЯ:</p>
                          <input type="text" name="name" id="name" required>
                        </div>
                        <div class="form__input">
                          <p>ФАМИЛИЯ:</p>
                          <input type="text" name="surname" id="surname" required>
                        </div>
                        <div class="form__input">
                          <p>ПОЛ:</p>
                          <input type="text" name="sex" id="sex" required>
                        </div>
                        <div class="form__input">
                          <p style="width: 165px;">ОБЩЕЕ ОПИСАНИЕ ПОДОЗРЕВАЕМОГО:</p>
                          <input type="text" name="description" id="description" required>
                        </div>
                        <div class="form__input">
                          <p>ОБВИНЯЕТСЯ В:</p>
                          <input type="text" name="reason" id="reason-people" required>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" style="justify-content: space-between;">
                      <div class="edit-people-bolo__result">

                      </div>
                      <button type="submit" class="btn btn-primary">Применить</button>
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
          <div class="block-buttons" style="margin-top: 0; justify-content: flex-start;">
            <div class="block-buttons__button">
              <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#create-vehicle-bolo">Новый
                BOLO (Автомобиль)</button>
            </div>
            <div class="block-buttons__button">
              <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#create-people-bolo">Новый
                BOLO (Человек)</button>
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