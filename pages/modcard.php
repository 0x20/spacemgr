<?php


/**
 * Created by PhpStorm.
 * User: friedkiwi
 * Date: 21/02/2019
 * Time: 08:24
 */

require_once('../config.php');
require_once('../lib/lib.php');

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$caid = $_GET['caid'];
$action = $_GET['action'];
$user = $_SESSION['user'];

if ($caid == '') {
    header('Location: cards.php');
    exit();
}

if ($action == '') {
    header('Location: cards.php');
    exit();
}

if ($user == '') {
    header('Location: login.php');
    exit();
}

if ($action == 'disable') {
    disable_access_card_for_user($user, $caid);
}

if ($action == 'enable') {
    enable_access_card_for_user($user, $caid);
}

if ($action == 'delete') {
    delete_access_card_for_user($user, $caid);
}

header('Location: cards.php');
exit();