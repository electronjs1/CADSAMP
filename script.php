<?php
require_once 'config.php';

if (isset($_GET['win'])) {
    $win = htmlspecialchars($_GET['win']);
    $win = trim($win);
}

if (isset($_GET['proc'])) {
    $proc = htmlspecialchars($_GET['proc']);
    $proc = trim($proc);
}

if (isset($_GET['coordx'])) {
    $coordx = htmlspecialchars($_GET['coordx']);
    $coordx = trim($coordx);
}

if (isset($_GET['coordy'])) {
    $coordy = htmlspecialchars($_GET['coordy']);
    $coordy = trim($coordy);
}

if (isset($_GET['username'])) {
    $username = htmlspecialchars($_GET['username']);
    $username = trim($username);
    $query = $db->prepare("SELECT `win`, `proc` FROM `units` WHERE `username` = :username");
    $values = ['username' => $username];
    $query->execute($values);
    $result = $query->fetchAll();

    if (count($result) > 0) {
        if ($result[0]['win'] != 0 AND $result[0]['proc'] != 0) {
            echo 'error protect';
        } else if (isset($win) AND isset($proc)) {
            $query = $db->prepare("UPDATE `units` SET `win` = :win, `proc` = :proc WHERE `username` = :username");
            $values = ['win' => $win, 'proc' => $proc, 'username' => $username];
            $query->execute($values);
        } else {
            echo 'error winproc';
        }
    } else {
        echo 'error user';
    }
} else if (isset($win)) {
    $query = $db->prepare("SELECT `username` FROM `units` WHERE `win` = :win AND `proc` = :proc");
    $values = ['win' => $win, 'proc' => $proc];
    $query->execute($values);
    $result = $query->fetchAll();

    if (count($result) > 0 AND isset($coordx) AND isset($coordy)) {
        $time = time();
        $query = $db->prepare("UPDATE `units` SET `coordx` = :coordx, `coordy` = :coordy, `coordtime` = '$time' WHERE `win` = :win AND `proc` = :proc");
        $values = ['coordx' => $coordx, 'coordy' => $coordy, 'win' => $win, 'proc' => $proc];
        $query->execute($values);
    } else if (count($result) > 0) {
        echo(md5($win. "lanisoft"));
    } else {
        echo 'error user';
    }
} else {
    echo 'error null';
}
$db = null; ?>