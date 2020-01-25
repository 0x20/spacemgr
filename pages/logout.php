<?php
/**
 * Created by PhpStorm.
 * User: friedkiwi
 * Date: 18/02/2019
 * Time: 21:09
 */

require_once('../config.php');
require_once('../lib/lib.php');

session_destroy();
header("Location: /index.php");
exit();