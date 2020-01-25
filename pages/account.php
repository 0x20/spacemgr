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

$ldap_pass_msg = '';
$new_ldap_pass_msg = '';
$new_ldap_pass_success_msg = '';
$new_ntlm_pass_msg = '';
$new_ntlm_pass_success_msg = '';
$user = $_SESSION['user'];
$message_id = $_GET['message'];

if ($message_id == '1') {
    $ldap_pass_msg = '<p style="color:red">Invalid password entered.</p>';
} else if($message_id == '2') {
    $new_ldap_pass_msg = '<p style="color:red">Passwords don\'t match.</p>';
} else if($message_id == '3') {
    $new_ldap_pass_success_msg = '<p style="color:green">LDAP password successfully updated.</p>';
} else if($message_id == '4') {
    $new_ntlm_pass_msg = '<p style="color:red">Passwords don\'t match.</p>';
} else if($message_id == '5') {
    $new_ntlm_pass_success_msg = '<p style="color:green">NTLM password successfully updated.</p>';
} else if($message_id == '6') {
    $new_ldap_pass_success_msg = '<p style="color:red">Unknown error while updating password.</p>';
} else if($message_id == '7') {
    $new_ntlm_pass_success_msg = '<p style="color:red">Unknown error while updating NTLM password.</p>';
} else if($message_id == '8') {
    $new_email_msg = '<p style="color:red">Invalid email address.</p>';
} else if($message_id == '9') {
    $email_pass_msg = '<p style="color:red">Password is incorrect</p>';
} else if($message_id == '10') {
    $new_email_success_msg = '<p style="color:green">Email address successfully updated.</p>';
} else if($message_id == '11') {
    $new_email_success_msg = '<p style="color:red">Unknown error while updating email address.</p>';
}

$current_email = get_user_email($user);

$navigation['account'] = 'class="active"';
require('../lib/header.php');
?>
<div class="container">
<h1>Account Manager</h1>
<hr />
<h2>Change password</h2>
<form method="post" action="update_pw.php">
    <input type="hidden" name="pwtype" value="ldap" />
    <table>
        <tr>
            <td valign="top" align="right">
                <br />Old password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
            </td>
            <td>
                <br /><input type="password" name="old_ldap_pass" /> <br/> <?php echo($ldap_pass_msg); ?>
            </td>
        </tr>
        <tr>
            <td valign="top" align="right">
                <br />New password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
            </td>
            <td>
                <br /><input type="password" name="new_ldap_pass" /> <br/>
            </td>
        </tr>
        <tr>
            <td valign="top" align="right">
                <br />Repeat new password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
            </td>
            <td>
                <br /><input type="password" name="new_ldap_pass_repeat" /> <br/> <?php echo($new_ldap_pass_msg); ?>
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                <br /><input type="submit" value="Change password" /><br /><br />
                <?php echo($new_ldap_pass_success_msg); ?>
            </td>
        </tr>
    </table>
</form>
<h2>Contact details</h2>
<form method="post" action="update_contact.php">
    <table>
        <tr valign="top" align="right">
            <td>
                <br />Current email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
            </td>
            <td align="left">
                <br /><a href="mailto:<?php echo($current_email); ?>"><?php echo($current_email); ?></a>
            </td>
        </tr>
        <tr>
            <td valign="top" align="right">
                <br />New email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
            </td>
            <td>
                <br /><input type="text" name="new_email" /> <br/> <?php echo($new_email_msg); ?>
            </td>
        </tr>
        <tr>
            <td valign="top" align="right">
                <br />Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
            </td>
            <td>
                <br /><input type="password" name="pass" /> <br/> <?php echo($email_pass_msg); ?>
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                <br /><input type="submit" value="Change contact details" /><br /><br />
                <?php echo($new_email_success_msg); ?>
            </td>
        </tr>
    </table>
</form>
</div>
<?php

require('../lib/footer.php');
