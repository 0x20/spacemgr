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

$message_id = $_GET['message'];

if ($message_id == '1') {
    $caid_message = '<span style="color: red">Specified card already exists in database.</span>';
}

require('../lib/header.php');

?>

    <div class="container">
        <h1>Add new access card</h1>
        <hr />
        <form method="post" action="add_new_card.php">
            <table>
                <tr>
                    <td valign="top">
                        <br />Card description&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                    </td>
                    <td>
                        <br /><input type="text" name="carddesc" />

                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <br />Card ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                    </td>
                    <td>
                        <br /><input type="text" name="caid" />
                        <?php echo ($caid_message); ?><br />
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        &nbsp;
                    </td>
                    <td valign="top">
                        <br /><input type="submit" value="Add new card." name="action" />
                    </td>
                </tr>
            </table>
            <p><br /><a href="cards.php">Back to card overview.</a></p>
        </form>
    </div>

<?php

require('../lib/footer.php');