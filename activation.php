<?php
$message = '';
if (!empty($_GET['code']) && isset($_GET['code'])) {
	include_once 'config.php';
	$code = htmlspecialchars($_GET['code']);
	$query = $db->prepare("SELECT * FROM `users` WHERE `activation_code` = :code");
	$values = ['code' => $code];
	$query->execute($values);
	$result = $query->fetchAll();
	if (count($result) > 0) {
		if ($result[0]['activation'] == 1) {
			$query = $db->prepare("UPDATE `users` SET `activation` = 2 WHERE `activation_code` = :code");
			$values = ['code' => $code];
			$query->execute($values);
			$message = 'Учётная запись успешно активирована.';
		} else if ($result[0]['activation'] == 2) {
			$message = 'Учётная запись уже активирована.';
		}
} else {
	$message = 'Неправильный код активации.';
}
$db = null;
} ?>

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
	<title>Активация учётной записи | lscsd.ru</title>
</head>

<body>
	<section>
		<div class="container">
			<div class="form form_active">
				<?php echo $message; ?>
			</div>
		</div>
	</section>
</body>

</html>