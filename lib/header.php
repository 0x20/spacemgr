<?php
/**
 * Created by PhpStorm.
 * User: friedkiwi
 * Date: 11/09/2019
 * Time: 14:10
 */


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Space Manager</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">Space Manager</a>
        </div>
        <?php if (is_logged_in()){ ?>
        <ul class="nav navbar-nav">
            
            <li <?php echo($navigation['account']); ?>><a href="/pages/account.php">Credentials</a></li>
            <li <?php echo($navigation['cards']); ?>><a href="/pages/cards.php">Access Cards</a></li>
        </ul>
        <?php } ?>
        <ul class="nav navbar-nav navbar-right">
            <?php if (is_logged_in()){ ?>
            <li><a href="/pages/logout.php">Logout <?php echo($user); ?></a></li>
            <?php } else {  ?>
            <li class="active"><a href="#">Login</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>