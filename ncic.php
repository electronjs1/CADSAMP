<?php
if (count($_POST) > 0 AND isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  require_once '../config.php';
  require 'auth.php';
  $name = htmlspecialchars($_POST['name']);
  $query = $db->prepare("SELECT * FROM `ncic` WHERE `name` = :name");
  $values = ['name' => $name];
  $query->execute($values);
  $result = $query->fetchAll();
  if ($name == '') {
    echo '<p style="color: red; margin-left: 10px;">ГРАЖДАНСКИЙ НЕ ВЫБРАН!</p>';
  } else if (count($result) > 0) {
    $query = $db->prepare("SELECT * FROM `ncic_arrests` WHERE `name` = :name");
    $values = ['name' => $name];
    $query->execute($values);
    $arrests = $query->fetchAll();
    $arrest = '';
    $query = $db->prepare("SELECT * FROM `ncic_violations` WHERE `name` = :name");
    $values = ['name' => $name];
    $query->execute($values);
    $violations = $query->fetchAll();
    $violation = '';
    $query = $db->prepare("SELECT * FROM `ncic_warnings` WHERE `name` = :name");
    $values = ['name' => $name];
    $query->execute($values);
    $warnings = $query->fetchAll();
    $warning = '';
    $spoiler_arrest = '';
    $spoiler_violation = '';
    $spoiler_warning = '';
    if (count($arrests) > 0) {
      $arrest = '<div class="search-result__arrests"><p>Количество: '.count($arrests).'</p>';
      for ($i = 0; $i < count($arrests); $i++) {
        $arrest .= '<br><p style="color: red;">'.$arrests[$i]['reason'].'</p>
        <p style="margin-left: 10px;">Дата ареста: '.date("d.m.Y", $arrests[$i]['date']).'</p>
        <p style="margin-left: 10px;">Офицер: '.$arrests[$i]['creator'].'</p>';
      }
      $arrest .= '</div>';
      $spoiler_arrest = 'search-result__spoiler';
    } else {
      $arrest = '<p style="color: green;">ЗАПИСИ НЕ НАЙДЕНЫ</p>';
    }
    if (count($violations) > 0) {
      $violation = '<div class="search-result__violations"><p>Количество: '.count($violations).'</p>';
      for ($i = 0; $i < count($violations); $i++) {
        $violation .= '<br><p style="color: orange;">'.$violations[$i]['reason'].'</p>
        <p style="margin-left: 10px;">Дата выдачи: '.date("d.m.Y", $violations[$i]['date']).'</p>
        <p style="margin-left: 10px;">Выдавший офицер: '.$violations[$i]['creator'].'</p>
        <p style="margin-left: 10px;">Нарушение зафиксировано на: '.$violations[$i]['place'].'</p>';
      }
      $violation .= '</div>';
      $spoiler_violation = 'search-result__spoiler';
    } else {
      $violation = '<p style="color: green;">ЗАПИСИ НЕ НАЙДЕНЫ</p>';
    }
    if (count($warnings) > 0) {
      $warning = '<div class="search-result__warnings"><p>Количество: '.count($warnings).'</p>';
      for ($i = 0; $i < count($warnings); $i++) {
        $warning .= '<br><p style="color: gray;">'.$warnings[$i]['reason'].'</p>
        <p style="margin-left: 10px;">Дата выдачи: '.date("d.m.Y", $warnings[$i]['date']).'</p>
        <p style="margin-left: 10px;">Выдавший офицер: '.$warnings[$i]['creator'].'</p>';
      }
      $warning .= '</div>';
      $spoiler_warning = 'search-result__spoiler';
    } else {
      $warning = '<p style="color: green;">НЕТ ПРЕДУПРЕЖДЕНИЙ</p>';
    }
    echo '<div class="search-result__passport-card">
      <div class="search-result__description">
        <p>STATE OF SAN ANDREAS</p>
      </div>
      <div class="search-result__title">
        <h1>PASSPORT CARD №'.$result[0]['id'].'</h1>
      </div>
      <div class="search-result__block">
        <div class="search-result__information">
        <div class="search-result__item">
          <p>ИМЯ ФАМИЛИЯ:</p> <p>'.$result[0]['name'].'.</p>
        </div>
        <div class="search-result__item">
          <p>ДАТА РОЖДЕНИЯ:</p> <p>'.$result[0]['dob'].'.</p>
        </div>
        <div class="search-result__item">
          <p>ПОЛ:</p> <p>'.$result[0]['sex'].'.</p>
        </div>
        <div class="search-result__item">
          <p>РАСА:</p> <p>'.$result[0]['race'].'.</p>
        </div>
        <div class="search-result__item">
          <p>СЕМЕЙНОЕ ПОЛОЖЕНИЕ:</p> <p>'.$result[0]['marrital_status'].'.</p>
        </div>
        <div class="search-result__item">
          <p>МЕСТО ПРОЖИВАНИЯ:</p> <p>'.$result[0]['por'].'.</p>
        </div>
        </div>
        <div class="search-result__logo">
          <img src="https://cad.lscsd.ru/mugshots/'.$result[0]['skin'].'.jpg">
        </div>
      </div>
      <div class="search-result__description">
        <p>UNITED STATES DEPARTMENT OF STATE</p><br>
        <p style="font-size: 11px;">Создал '.$result[0]['creator'].'<p>
      </div>
    </div>
    <div class="search-result__records">
      <p class="'.$spoiler_arrest.' search-result__arrest">АРЕСТЫ:</p>
      '.$arrest.'
    </div>
    <div class="search-result__records">
      <p class="'.$spoiler_violation.' search-result__violation">НАРУШЕНИЯ:</p>
      '.$violation.'
    </div>
    <div class="search-result__records">
      <p class="'.$spoiler_warning.' search-result__warning">ПРЕДУПРЕЖДЕНИЯ:</p>
      '.$warning.'
    </div>
    <div class="search-result__records">
      <button type="button" class="btn btn-dark table-btn" data-toggle="modal" data-target="#edit-pf" data-value="'.$result[0]['id'].'" data-bolo="Личное дело" value="Редактировать">Редактировать личное дело</button>
    </div>';
  }
  $db = null;
} else {
  header("Location: /");
  die();
} ?>
