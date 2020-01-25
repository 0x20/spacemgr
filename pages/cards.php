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

$known_cards = get_access_cards_for_user($user);

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
    <?php foreach($known_cards as $card) { ?>
        <tr>
            <td><?php echo $card['caid']; ?></td>
            <td><?php echo $card['carddesc']; ?></td>
            <td><?php echo $card['lastseen']; ?></td>
            <td>
                <?php if ($card['enabled'] == 't') { ?>
                <a href="#">Disable</a>
                <?php } else { ?>
                <a href="#">Enable</a>
                <?php }?>
                <a href="#">Delete</a>
            </td>
        </tr>
    <?php }?>
    </tbody>
</table>

    <a href="#">Register new card</a>

</div>
<?php

require('../lib/footer.php');