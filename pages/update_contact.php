<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../config.php');
require_once('../lib/lib.php');

if (!is_logged_in()) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$new_email = $_POST['new_email'];
$password = $_POST['pass'];

if (is_valid_user($user, $password)) {
    if (!validate_email($new_email)) {
        header('Location: account.php?message=8');
        exit();
    } else {
        if (update_email($user, $new_email)) {
            header('Location: account.php?message=10');
        } else {
            header('Location: account.php?message=11');
        }
        exit();
    }
} else {
    header('Location: account.php?message=9');
    exit();
}