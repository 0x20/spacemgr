<?php
/**
 * Created by PhpStorm.
 * User: friedkiwi
 * Date: 21/02/2019
 * Time: 08:24
 */

require_once('../config.php');
require_once('../lib/lib.php');

if (!allow_registration()) {
    header("Location: index.php");
    exit();
}

if ($_POST['action'] != 'Create account.') {
    header('Location: /pages/register.php');
    exit();
}

$user = $_POST['username'];
$pass = $_POST['password'];
$pass_repeat = $_POST['password_repeat'];
$email = $_POST['email'];

if ($user == "") {
    header("Location: /pages/register.php?message=1");
    exit();
}

if ($pass == "") {
    header("Location: /pages/register.php?message=2");
    exit();
}

if (!validate_email($email)) {
    header("Location: /pages/register.php?message=6");
    exit();
}

if ($pass != $pass_repeat) {
    header("Location: /pages/register.php?message=3");
    exit();
}

if (user_exists($user)) {
    header("Location: /pages/register.php?message=4");
    exit();
}

if (create_user($user, $email, $pass)) {
    $_SESSION['user'] = $user;
    header("Location: /pages/index.php");
    exit();
} else {
    header("Location: /pages/register.php?message=5");
    exit();
}