<?php
/**
 * Created by PhpStorm.
 * User: friedkiwi
 * Date: 18/02/2019
 * Time: 19:37
 */

require_once('../config.php');
require_once('../lib/lib.php');

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}


$message_id = $_GET['message'];
$user = $_SESSION['user'];

$navigation['wifi'] = 'class="active"';
require('../lib/header.php');

?>
<div class="container">
<h1>Space Wifi</h1>
<hr />
<h2>Spacenet/spacefed credentials</h2>
<p>Spacenet is a system of federated Wifi login details used across a large number of hackerspaces.
    To use spacenet, you'd have to set your password below, after which you can log into spacenet using the username
<b><?php echo $user;?>@hackerspace.gent</b> and the password you've just set. </p>
<form method="post" action="update_spacenet_pw.php">
    <table>
        <tr>
            <td valign="top" align="right">
                <br />Current user password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
            </td>
            <td>
                <br /><input type="password" name="ldap_pass" /> <br/> <?php echo($ldap_pass_msg); ?>
            </td>
        </tr>
        <tr>
            <td valign="top" align="right">
                <br />New Wifi password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
            </td>
            <td>
                <br /><input type="password" name="new_wifi_pass" /> <br/>
            </td>
        </tr>
        <tr>
            <td valign="top" align="right">
                <br />Repeat new Wifi password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
            </td>
            <td>
                <br /><input type="password" name="new_wifi_pass_repeat" /> <br/> <?php echo($new_wifi_pass_message); ?>
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                <br /><input type="submit" value="Change password" /><br /><br />
                <?php echo($new_wifi_pass_success_message); ?>
            </td>
        </tr>
    </table>
</form>
<h2>Legacy device wifi</h2>
<p>The old space wifi network infrastructure obviously still works, and can be used with the password <b>unicorns</b> using: </p>
    <ul>
        <li>hackerspace.gent</li>
        <li>0x20</li>
    </ul>
</div>
<?php

require('../lib/footer.php');
