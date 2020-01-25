<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../config.php');
require_once('../lib/lib.php');

$user = $_SESSION['user'];
$navigation['cards'] = 'class="active"';
require('../lib/header.php');
?>
<div class="container">
<h1>Access Cards</h1>
<hr />
<p>The following cards have been added to your account:</p>
<table class="table">
    <thead>
        <tr>
            <td>Card ID</td>
            <td>Description</td>
            <td>Last Seen</td>
            <td>Actions</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>123456</td>
            <td>TfL Oyster</td>
            <td>2019-09-17 18:29</td>
            <td><a href="#">Disable</a> <a href="#">Delete</a></td>
        </tr>
        <tr>
            <td>654987 <br/>(disabled)
            </td>
            <td>Uni Canteen Pass</td>
            <td>2019-09-01 14:21</td>
            <td><a href="#">Enable</a> <a href="#">Delete</a></td>
        </tr>
    </tbody>
</table>
</div>
<?php

require('../lib/footer.php');