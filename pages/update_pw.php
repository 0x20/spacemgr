<?php
/**
 * Created by PhpStorm.
 * User: friedkiwi
 * Date: 18/02/2019
 * Time: 20:27
 */

require_once('../config.php');
require_once('../lib/lib.php');

if (!is_logged_in()) {
    header("Location: login.php");
    exit();
}

$pw_type = $_POST['pwtype'];
$user = $_SESSION['user'];

if ($pw_type == 'ldap') {
    // ldap logic
    $oldpass = $_POST['old_ldap_pass'];
    $newpass = $_POST['new_ldap_pass'];
    $newpass2 = $_POST['new_ldap_pass_repeat'];

    if ($oldpass == '') {
        // fall back
        header('Location: index.php');
        exit();
    }

    if ($newpass != $newpass2) {
        header('Location: account.php?message=2');
        exit();
    }

    if (is_valid_user($user, $oldpass)) {
        if (update_password($user, $newpass)) {
            header('Location: account.php?message=3');
            exit();
        } else {
            header('Location: account.php?message=6');
            exit();
        }
    } else {
        header('Location: account.php?message=1');
        exit();
    }

} else {
    // fall back
    header('Location: index.php');
    exit();
}