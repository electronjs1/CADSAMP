<?php
include_once 'config.php';
if (isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  include 'actions/auth.php';
  } else { ?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <!-- <meta property="og:image" content="https://cad.lscsd.ru/img/logo.png" />
  <link rel="shortcut icon" href="https://cad.lscsd.ru/img/logo.png" /> -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <title>CAD AND MDT | lscsd.ru</title>
</head>

<body>
  <section>
    <div class="container">
      <form id="signin" name="signin" class="form form_active">
        <div class="form__logo"></div>
        <div class="form__result"></div>
        <div class="form__loader">
          <div class="spinner-border" role="status"></div>
        </div>
        <div class="form__title">
          <h1>База Данных</h1>
        </div>
        <div class="form__input">
          <input type="password" name="password" placeholder="Пароль" required>
        </div>
        <div class="form__input form__autologin">
          <input type="checkbox" name="autologin">
          <label>Запомнить меня</label>
        </div>
        <div class="form__button">
          <input type="submit" value="Войти">
        </div>
        <div class="form__information">
          <p>Нет аккаунта? <a href="#signup">Получить доступ</a></p>
        </div>
      </form>
      <form id="signup" name="signup" class="form">
        <div class="form__result"></div>
        <div class="form__loader">
          <div class="spinner-border" role="status"></div>
        </div>
        <div class="form__title">
          <h1>Получить доступ</h1>
        </div>
        <div class="form__input">
          <input type="text" name="username" placeholder="Никнейм (Duke Harmon)" required>
        </div>
        <div class="form__input">
          <input type="text" name="identifier" placeholder="Идентификатор (1P-6213)" required>
        </div>
        <div class="form__input">
          <input type="text" name="vkpage" placeholder="vk.com/user1234" pattern="vk.com/[a-zA-Z-0-9_]+$" required>
        </div>
        <div class="form__input">
          <input type="password" name="password" placeholder="Пароль" required>
        </div>
        <div class="form__input">
          <input type="password" name="password-check" placeholder="Подтвердите пароль" required>
        </div>
        <div class="form__button">
          <input type="submit" value="Отправить заявку">
        </div>
        <div class="form__information">
          <p>Уже участник? <a href="#signin">Войти</a></p>
        </div>
      </form>
    </div>
  </section>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
  <script src="js/main.js"></script>
</body>

</html>
<?php }
$db = null; ?>