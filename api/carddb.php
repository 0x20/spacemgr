<?php

/**
 * Created by PhpStorm.
 * User: friedkiwi
 * Date: 21/02/2019
 * Time: 08:24
 */

require_once('../config.php');
require_once('../lib/lib.php');

header('Content-Type: text/plain');

$cards = get_all_known_active_cards();

foreach ($cards as $card) {
    echo "$card\n";
}