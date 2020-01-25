<?php
/**
 * Created by PhpStorm.
 * User: friedkiwi
 * Date: 18/02/2019
 * Time: 19:03
 */

require_once('config.php');
require_once('lib/lib.php');

if (!is_logged_in()){
    header("Location: pages/login.php");
    exit();
} else {
    header("Location: pages/account.php");
    exit();
}