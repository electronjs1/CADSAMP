<?php

if (isset($_COOKIE['cad_sid']) AND isset($_COOKIE['cad_u']) AND isset($_COOKIE['cad_bid'])) {
  require_once '../config.php';
  require 'auth.php';

if (isset($_GET['mdtcallstable'])) {
  getmdtcallstable();
} else if (isset($_GET['mdtcalltable'])) {
  getmdtcalltable($session_user_id);
} else if (isset($_GET['mdtstatus'])) {
  getmdtstatus($session_user_id);
} else if (isset($_GET['mdtnotifications'])) {
  getmdtnotifications();
} else if (isset($_GET['mdtpeoplebolo'])) {
  getmdtpeoplebolo();
} else if (isset($_GET['mdtvehiclebolo'])) {
  getmdtvehiclebolo();
} else if (isset($_GET['cadcallstable'])) {
  getcadcallstable();
} else if (isset($_GET['cadnotifications'])) {
  getcadnotifications();
} else if (isset($_GET['cadavailableunits'])) {
  getcadavailableunits();
} else if (isset($_GET['cadunavailableunits'])) {
  getcadunavailableunits();
} else if (isset($_GET['cadpeoplebolo'])) {
  getcadpeoplebolo();
} else if (isset($_GET['cadvehiclebolo'])) {
  getcadvehiclebolo();
} else if (isset($_GET['onlinemap'])) {
  getonlinemap();
}

$db = null;

} else {
  header("Location: /");
  die();
}

function getmdtcallstable() {
  global $db;
  $query = $db->prepare("SELECT * FROM `calls` WHERE `active` = '1'");
  $query->execute();
  $result = $query->fetchAll();
  if (count($result) > 0) { ?>
    <table class="table table-bordered table-dark">
    <thead>
    <tr>
      <th scope="col" style="width: 10px;">Номер</th>
      <th scope="col" style="width: 200px;">Тип вызова</th>
      <th scope="col" style="width: 60px;">Юниты</th>
      <th scope="col">Локация</th>
    </tr>
    </thead>
    <tbody>
    <?php
    date_default_timezone_set('Europe/Moscow');
    for ($i = 0; $i < count($result); $i++) { ?>
      <tr>
        <th scope="row" rowspan="2"><?php echo $result[$i]['id'] ?></th>
        <td><?php if ($result[$i]['type'] == 1) {
          echo '<button type="button" class="btn btn-danger btn-911 disabled" disabled>911</button>';
        } else if ($result[$i]['type'] == 2) {
          echo '<button type="button" class="btn btn-danger btn-panic disabled" disabled>АКТИВАЦИЯ ТРЕВОЖНОЙ КНОПКИ</button>';
        } else if ($result[$i]['type'] == 3) {
          echo '<button type="button" class="btn btn-danger disabled" disabled>ЭКСТРЕННАЯ СИТУАЦИЯ</button>';
        } else if ($result[$i]['type'] == 4) {
          echo '<button type="button" class="btn btn-warning disabled" disabled>ДТП</button>';
        } else if ($result[$i]['type'] == 5) {
          echo '<button type="button" class="btn btn-warning disabled" disabled>ОСТАНОВКА ГРАЖДАНСКОГО</button>';
        } else if ($result[$i]['type'] == 6) {
          echo '<button type="button" class="btn btn-warning disabled" disabled>ОСТАНОВКА ТРАНСПОРТА</button>';
        } else if ($result[$i]['type'] == 7) {
          echo '<button type="button" class="btn btn-warning disabled" disabled>ПРЕСЛЕДОВАНИЕ</button>';
        } else if ($result[$i]['type'] == 8) {
          echo '<button type="button" class="btn btn-danger disabled" disabled>ПЕРЕСТРЕЛКА</button>';
        } else if ($result[$i]['type'] == 9) {
          echo '<button type="button" class="btn btn-warning disabled" disabled>ПРОЧЕЕ</button>';
        } ?></td>
        <?php
        $call = $result[$i]['id'];
        $query = $db->prepare("SELECT * FROM `users` WHERE `active_call` = '$call'");
        $query->execute();
        $results = $query->fetchAll(); ?>
        <td><?php if (count($results) > 0) {
        for ($b = 0; $b < count($results); $b++) {
          echo $results[$b]['identifier'];
          echo ' ';
        }
      } else {
        echo '<p style="color: red; margin: 0;">Нет юнитов.<p>';
      } ?></td>
      <td><?php echo $result[$i]['location']; ?></td>
        </tr>
        <tr>
          <td style="background: #1c1b1d;" colspan="4"><?php echo $result[$i]['log'] ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
    <?php } else {
      echo '<div class="section__inactive">
        <p>Нет активных вызовов.</p>
      </div>';
    }
    
}

function getmdtcalltable($session_user_id) {
  global $db;
  $query = $db->prepare("SELECT * FROM `users` WHERE `id` = :user_id AND `active_call` != 0");
  $values = ['user_id' => $session_user_id];
  $query->execute($values);
  $result = $query->fetchAll();
  if (count($result) > 0) {
    if ($result[0]['notification'] == 1) {
      $query = $db->prepare("UPDATE `users` SET `notification` = 0 WHERE `id` = :user_id");
      $values = ['user_id' => $session_user_id];
      $query->execute($values); ?>
      <script type="text/javascript">
        var audio = document.getElementById('notification');
        audio.volume = 0.3;
        audio.play();
      </script>
    <?php }
    $call = $result[0]['active_call'];
    $query = $db->prepare("SELECT * FROM `calls` WHERE `id` = :call AND `active` = 1");
    $values = ['call' => $call];
    $query->execute($values);
    $result = $query->fetchAll();
  }
  if (count($result) > 0) { ?>
    <div class="section__info">
      <button type="button" class="btn btn-danger disabled" disabled>ПРИКРЕПЛЁН К ВЫЗОВУ</button>
    </div>
  <table class="table table-bordered table-dark">
<thead>
<tr>
<th scope="col" style="width: 10px;">Номер</th>
<th scope="col" style="width: 200px;">Тип вызова</th>
<th scope="col" style="width: 60px;">Юниты</th>
<th scope="col">Локация</th>
</tr>
</thead>
<tbody>
<tr>
<th scope="row" rowspan="2"><?php echo $result[0]['id'] ?></th>
<td><?php if ($result[$i]['type'] == 1) {
          echo '<button type="button" class="btn btn-danger btn-911 disabled" disabled>911</button>';
        } else if ($result[$i]['type'] == 2) {
          echo '<button type="button" class="btn btn-danger btn-panic disabled" disabled>АКТИВАЦИЯ ТРЕВОЖНОЙ КНОПКИ</button>';
        } else if ($result[$i]['type'] == 3) {
          echo '<button type="button" class="btn btn-danger disabled" disabled>ЭКСТРЕННАЯ СИТУАЦИЯ</button>';
        } else if ($result[$i]['type'] == 4) {
          echo '<button type="button" class="btn btn-warning disabled" disabled>ДТП</button>';
        } else if ($result[$i]['type'] == 5) {
          echo '<button type="button" class="btn btn-warning disabled" disabled>ОСТАНОВКА ГРАЖДАНСКОГО</button>';
        } else if ($result[$i]['type'] == 6) {
          echo '<button type="button" class="btn btn-warning disabled" disabled>ОСТАНОВКА ТРАНСПОРТА</button>';
        } else if ($result[$i]['type'] == 7) {
          echo '<button type="button" class="btn btn-warning disabled" disabled>ПРЕСЛЕДОВАНИЕ</button>';
        } else if ($result[$i]['type'] == 8) {
          echo '<button type="button" class="btn btn-danger disabled" disabled>ПЕРЕСТРЕЛКА</button>';
        } else if ($result[$i]['type'] == 9) {
          echo '<button type="button" class="btn btn-warning disabled" disabled>ПРОЧЕЕ</button>';
        } ?></td>
<?php
$call = $result[0]['id'];
$query = $db->prepare("SELECT * FROM `users` WHERE `active_call` = '$call'");
$query->execute();
$results = $query->fetchAll(); ?>
<td><?php if (count($results) > 0) {
for ($b = 0; $b < count($results); $b++) {
  echo $results[$b]['identifier'];
  echo ' ';
}
} else {
echo '<p style="color: #ff0000; margin: 0;">Нет юнитов.<p>';
} ?></td>
<td><?php echo $result[0]['location']; ?></td>
</tr>
</tbody>
</table>
<div class="section__info border-info">
  <h1>По прибытии на место отметьтесь одиночным нажатием</h1>
  <button type="button" class="btn btn-dark select__option" data-value="10-23 | НА МЕСТЕ">10-23 | НА МЕСТЕ</button>
  <button type="button" class="btn btn-dark select__option" data-value="10-8 | ДОСТУПЕН">10-8 | ОТКРЕПИТЬСЯ ОТ ВЫЗОВА</button>
</div>
<?php } else {
echo '<div class="section__inactive">
  <p>Не прикреплён к вызову.</p>
</div>';
}

}

function getmdtstatus($session_user_id) {
  global $db;
  $query = $db->prepare("SELECT `status` FROM `users` WHERE `id` = :user_id");
  $values = ['user_id' => $session_user_id];
  $query->execute($values);
  $result = $query->fetch();
  echo '<p>'.$result['status'].'</p>';
  
}

function getmdtnotifications() {
  global $db;
  $time = time() - 5;
  $query = $db->prepare("SELECT * FROM `notifications`");
  $query->execute();
  $button = $query->fetch();
  if ($button['panic_active'] == 1) { ?>
  <button type="button" class="btn btn-danger">КНОПКА ПАНИКИ АКТИВНА</button>
  <?php if ($button['last_notifications_update'] >= $time) { ?>
    <script type="text/javascript">
      var audio = document.getElementById('panic');
      audio.volume = 0.3;
      audio.play();
    </script>
  <?php }
} else { ?>
  <button type="button" class="btn btn-danger" id="panic-button">Кнопка паники</button>
<?php }
  if ($button['signal_100'] == 1) { ?>
    <script type="text/javascript">
      var audio = document.getElementById('signal100');
      audio.volume = 0.3;
      audio.play();
    </script>
  <?php }

}

function getmdtpeoplebolo() {
  global $db;
  $query = $db->prepare("SELECT * FROM `people_bolo` WHERE `active` = '1'");
  $query->execute();
  $result = $query->fetchAll();
  if (count($result) > 0) { ?>
    <table class="table table-bordered table-dark table-striped" style="background: transparent;">
<thead>
<tr style="white-space: nowrap;">
  <th scope="col">Имя</th>
  <th scope="col">Фамилия</th>
  <th scope="col">Пол</th>
  <th scope="col">Общее описание подозреваемого</th>
  <th scope="col">Обвиняется в</th>
</tr>
</thead>
<tbody>
<?php for ($i = 0; $i < count($result); $i++) { ?>
<tr>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['name'] ?></td>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['surname'] ?></td>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['sex'] ?></td>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['description'] ?></td>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['reason'] ?></td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } else {
echo '<div class="section__inactive">
<p>Нет активных BOLO (люди).</p>
</div>';
}

}

function getmdtvehiclebolo() {
  global $db;
  $query = $db->prepare("SELECT * FROM `vehicle_bolo` WHERE `active` = '1'");
  $query->execute();
  $result = $query->fetchAll();
  if (count($result) > 0) { ?>
  <table class="table table-bordered table-dark table-striped" style="background: transparent;">
<thead>
<tr style="white-space: nowrap;">
<th scope="col">Марка автомобиля</th>
<th scope="col">Цвет автомобиля</th>
<th scope="col">Номера автомобиля</th>
<th scope="col">Особенности</th>
<th scope="col">Последнее место обнаружения</th>
<th scope="col">Последняя дата обнаружения</th>
<th scope="col">Разыскивается за</th>
</tr>
</thead>
<tbody>
<?php for ($i = 0; $i < count($result); $i++) { ?>
<tr>
<td style="background: transparent;" scope="row"><?php echo $result[$i]['model'] ?></td>
<td style="background: transparent;" scope="row"><?php echo $result[$i]['color'] ?></td>
<td style="background: transparent;" scope="row"><?php echo $result[$i]['number'] ?></td>
<td style="background: transparent;" scope="row"><?php echo $result[$i]['features'] ?></td>
<td style="background: transparent;" scope="row"><?php echo $result[$i]['last_place'] ?></td>
<td style="background: transparent;" scope="row"><?php echo $result[$i]['last_date'] ?></td>
<td style="background: transparent;" scope="row"><?php echo $result[$i]['reason'] ?></td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } else {
echo '<div class="section__inactive">
<p>Нет активных BOLO (автомобили).</p>
</div>';
}

}

function getcadcallstable() {
  global $db;
  $query = $db->prepare("SELECT * FROM `calls` WHERE `active` = '1'");
  $query->execute();
  $result = $query->fetchAll();
  if (count($result) > 0) { ?>
    <table class="table table-bordered table-dark">
<thead>
<tr>
  <th scope="col" style="width: 10px;">Номер</th>
  <th scope="col" style="width: 200px;">Тип вызова</th>
  <th scope="col" style="width: 60px;">Юниты</th>
  <th scope="col">Локация</th>
  <th scope="col" style="width: 15px;">Действия</th>
</tr>
</thead>
<tbody>
<?php date_default_timezone_set('Europe/Moscow');
for ($i = 0; $i < count($result); $i++) { ?>
<tr>
  <th scope="row" rowspan="2"><?php echo $result[$i]['id'] ?></th>
  <td><?php if ($result[$i]['type'] == 1) {
      echo '<button type="button" class="btn btn-danger btn-911 disabled" disabled>911</button>';
    } else if ($result[$i]['type'] == 2) {
      echo '<button type="button" class="btn btn-danger btn-panic disabled" disabled>АКТИВАЦИЯ ТРЕВОЖНОЙ КНОПКИ</button>';
    } else if ($result[$i]['type'] == 3) {
      echo '<button type="button" class="btn btn-danger disabled" disabled>ЭКСТРЕННАЯ СИТУАЦИЯ</button>';
    } else if ($result[$i]['type'] == 4) {
      echo '<button type="button" class="btn btn-warning disabled" disabled>ДТП</button>';
    } else if ($result[$i]['type'] == 5) {
      echo '<button type="button" class="btn btn-warning disabled" disabled>ОСТАНОВКА ГРАЖДАНСКОГО</button>';
    } else if ($result[$i]['type'] == 6) {
      echo '<button type="button" class="btn btn-warning disabled" disabled>ОСТАНОВКА ТРАНСПОРТА</button>';
    } else if ($result[$i]['type'] == 7) {
      echo '<button type="button" class="btn btn-warning disabled" disabled>ПРЕСЛЕДОВАНИЕ</button>';
    } else if ($result[$i]['type'] == 8) {
      echo '<button type="button" class="btn btn-danger disabled" disabled>ПЕРЕСТРЕЛКА</button>';
    } else if ($result[$i]['type'] == 9) {
      echo '<button type="button" class="btn btn-warning disabled" disabled>ПРОЧЕЕ</button>';
    } ?></td>
  <?php
  $call = $result[$i]['id'];
  $query = $db->prepare("SELECT * FROM `users` WHERE `active_call` = '$call'");
  $query->execute();
  $results = $query->fetchAll(); ?>
  <td><?php if (count($results) > 0) {
  for ($b = 0; $b < count($results); $b++) {
    echo $results[$b]['identifier'];
    echo ' ';
  }
} else {
  echo '<p style="color: red; margin: 0;">Нет юнитов.<p>';
} ?></td>
  <td><?php echo $result[$i]['location']; ?></td>
  <td>
      <input type="submit" class="table-btn" data-value="<?php echo $result[$i]['id'] ?>" value="Код 4">
      <input type="submit" class="table-btn" data-toggle="modal" data-target="#create-attach" data-value="<?php echo $result[$i]['id'] ?>" value="Прикрепить">
  </td>
</tr>
<tr>
  <td style="background: #1c1b1d;" colspan="4"><?php echo $result[$i]['log'] ?></td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } else {
echo '<div class="section__inactive">
<p>Нет активных вызовов.</p>
</div>';
}

}

function getcadnotifications() {
  global $db;
  $time = time() - 5;
  $query = $db->prepare("SELECT * FROM `notifications`");
  $query->execute();
  $button = $query->fetch();
  if ($button['signal_100'] == 1) { ?>
  <button type="button" class="btn btn-danger" id="signal_100">СИГНАЛ 100 АКТИВЕН</button>
  <script type="text/javascript">
    var audio = document.getElementById('signal100');
    audio.volume = 100.0;
    audio.play();
  </script>
<?php } else { ?>
  <button type="button" class="btn btn-danger" id="signal_100">СИГНАЛ 100</button>
<?php }
if ($button['panic_active'] == 1) {
  if ($button['last_notifications_update'] >= $time) { ?>
  <script type="text/javascript">
    var audio = document.getElementById('panic');
    audio.volume = 100.0;
    audio.play();
  </script>
<?php }
}

}

function getcadavailableunits() {
  global $db;
  $query = $db->prepare("SELECT * FROM `users` WHERE `status` = '10-8 | ДОСТУПЕН'");
  $query->execute();
  $result = $query->fetchAll();
  if (count($result) > 0) { ?>
    <table class="table table-bordered table-dark table-striped" style="background: transparent;">
<thead>
<tr>
  <th scope="col" style="width: 50%; text-align: center;">Имя Фамилия</th>
  <th scope="col" style="width: 50%; text-align: center;">Статус</th>
  <th scope="col" style="width: 50%; text-align: center;">Маркировка</th>
</tr>
</thead>
<tbody>
<?php for ($i = 0; $i < count($result); $i++) { ?>
<tr>
  <th style="background: transparent;" scope="row"><?php echo [$result[$i]['identifier']];$result[$i]['username'] ?></th>
  <th style="background: transparent;"><?php echo $result[$i]['status'] ?></th>
  <th style="background: transparent;"><?php echo $result[$i]['mark'] ?></th>
</tr>
<?php } ?>
</tbody>
</table>
<?php } else {
echo '<div class="section__inactive">
<p>Нет доступных юнитов.</p>
</div>';
}

}

function getcadunavailableunits() {
  global $db;
  $query = $db->prepare("SELECT * FROM `users` WHERE `status` != '10-8 | ДОСТУПЕН' AND `status` != '10-7 | ВНЕ СЛУЖБЫ'");
  $query->execute();
  $result = $query->fetchAll();
  if (count($result) > 0) { ?>
    <table class="table table-bordered table-dark table-striped" style="background: transparent;">
<thead>
<tr>
  <th scope="col" style="width: 50%; text-align: center;">Имя Фамилия</th>
  <th scope="col" style="width: 50%; text-align: center;">Статус</th>
  <th scope="col" style="width: 50%; text-align: center;">Маркировка</th>
</tr>
</thead>
<tbody>
<?php date_default_timezone_set('Europe/Moscow');
for ($i = 0; $i < count($result); $i++) { ?>
<tr>
  <th style="background: transparent;" scope="row"><?php echo $result[$i]['username'] ?></th>
  <th style="background: transparent;" scope="row"><?php echo $result[$i]['status'] ?></th>
  <th style="background: transparent;"><?php echo $result[$i]['mark'] ?></th>
</tr>
<?php } ?>
</tbody>
</table>
<?php } else {
echo '<div class="section__inactive">
<p>Нет недоступных юнитов.</p>
</div>';
}

}

function getcadpeoplebolo() {
  global $db;
  $query = $db->prepare("SELECT * FROM `people_bolo` WHERE `active` = '1'");
  $query->execute();
  $result = $query->fetchAll();
  if (count($result) > 0) { ?>
    <table class="table table-bordered table-dark table-striped" style="background: transparent;">
<thead>
<tr style="white-space: nowrap;">
  <th scope="col">Имя</th>
  <th scope="col">Фамилия</th>
  <th scope="col">Пол</th>
  <th scope="col">Общее описание подозреваемого</th>
  <th scope="col">Обвиняется в</th>
  <th scope="col" style="width: 130px;">Действия</th>
</tr>
</thead>
<tbody>
<?php for ($i = 0; $i < count($result); $i++) { ?>
<tr>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['name'] ?></td>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['surname'] ?></td>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['sex'] ?></td>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['description'] ?></td>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['reason'] ?></td>
  <td style="background: transparent;" scope="row">
    <input type="submit" class="table-btn" data-value="<?php echo $result[$i]['id'] ?>" data-bolo="Человек" value="Удалить">
    <input type="submit" class="table-btn" data-toggle="modal" data-target="#edit-people-bolo" data-value="<?php echo $result[$i]['id'] ?>" data-bolo="Человек" value="Редактировать">
  </td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } else {
echo '<div class="section__inactive">
<p>Нет активных BOLO (люди).</p>
</div>';
}

}

function getcadvehiclebolo() {
  global $db;
  $query = $db->prepare("SELECT * FROM `vehicle_bolo` WHERE `active` = '1'");
  $query->execute();
  $result = $query->fetchAll();
  if (count($result) > 0) { ?>
    <table class="table table-bordered table-dark table-striped" style="background: transparent;">
<thead>
<tr style="white-space: nowrap;">
  <th scope="col">Марка автомобиля</th>
  <th scope="col">Цвет автомобиля</th>
  <th scope="col">Номера автомобиля</th>
  <th scope="col">Особенности</th>
  <th scope="col">Последнее место обнаружения</th>
  <th scope="col">Последняя дата обнаружения</th>
  <th scope="col">Разыскивается за</th>
  <th scope="col" style="width: 130px;">Действия</th>
</tr>
</thead>
<tbody>
<?php for ($i = 0; $i < count($result); $i++) { ?>
<tr>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['model'] ?></td>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['color'] ?></td>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['number'] ?></td>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['features'] ?></td>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['last_place'] ?></td>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['last_date'] ?></td>
  <td style="background: transparent;" scope="row"><?php echo $result[$i]['reason'] ?></td>
  <td style="background: transparent;" scope="row">
    <input type="submit" class="table-btn" data-value="<?php echo $result[$i]['id'] ?>" data-bolo="Автомобиль" value="Удалить">
    <input type="submit" class="table-btn" data-toggle="modal" data-target="#edit-vehicle-bolo" data-value="<?php echo $result[$i]['id'] ?>" data-bolo="Автомобиль" value="Редактировать">
  </td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } else {
echo '<div class="section__inactive">
<p>Нет активных BOLO (автомобили).</p>
</div>';
}

}

function getonlinemap() {
  global $db;
  $query = $db->prepare("SELECT * FROM `units`");
  $query->execute();
  $result = $query->fetchAll();
  if (count($result) > 0) {
    echo json_encode($result);
  }
  
}

?>
