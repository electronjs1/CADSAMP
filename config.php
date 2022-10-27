<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=u1690650_cad.lscsd', 'u1690650_cad.lsc', 'UwM-cYw-3ui-idw');
    $db->exec("SET NAMES UTF8");
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
} ?>
