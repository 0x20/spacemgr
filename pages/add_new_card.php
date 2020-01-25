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

$caid = $_POST['caid'];
$carddesc = $_POST['carddesc'];
$user = $_SESSION['user'];

if ($_POST['action'] != 'Add new card.') {
    header('Location: cards.php');
    exit();
}

// 1. check if card exists in DB
// err 1: card already added

if (caid_exists($caid)) {
    header('Location: addcard.php?message=1');
    exit();
}

add_access_card_for_user($user, $caid, $carddesc);
header('Location: cards.php?message=1');