<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../config.php');
require_once('../lib/lib.php');

if (is_logged_in()) {
    header('Location: ./account.php');
    exit();
}

$action = $_POST['action'];
$email = $_POST['email'];;
$show_reset = false;
if ($action == 'Send reset code') {
    if (validate_email($email)) {
        // send pwreset
        $userid = get_username_from_email($email);
        if ($userid != "") {
            send_reset_code_email($email, $userid, generate_reset_code($userid));
        }
        $email_message = '<p style="color:green">If the email is associated with a user, a password reset code has been sent.</p>';
    } else {
        $email_message = '<p style="color:red">Invalid email address.</p>';
    }
} elseif ($action == 'Enter reset code') {
    if (validate_email($email)) {
        $show_reset = true;
    } else {
        $email_message = '<p style="color:red">Invalid email address.</p>';
    }
} elseif ($_GET['stage'] == 'resetcode') {
    $show_reset = true;
    $reset_code = $_POST['reset_code'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];
    
    if ($password == $password_repeat) {
        // introduce delay to avoid reset code brute forcing
        sleep(3);
        $userid = get_username_from_email($email);
        if ($userid != '') {
            if (validate_reset_code($userid, $reset_code)) {
                if (update_password($userid, $password_repeat)) {
                    spend_reset_code($userid, $reset_code);
                    $_SESSION['user'] = $userid;
                    header('Location: /index.php');
                    exit();
                } else {
                    $reset_code_message = '<p style="color:red">An error occured while resetting the password.</p>';
                }
            } else {
                $reset_code_message = '<p style="color:red">Invalid reset code or email address.</p>';
            }
        } else {
            $reset_code_message = '<p style="color:red">Invalid reset code or email address.</p>';
        }
    } else {
        $pass_message = '<p style="color:red">Passwords do not match.</p>';
    }
}
$email = htmlspecialchars($email);
require('../lib/header.php')
?>
<div class="container">
    <h1>Password reset</h1>
    <hr />
    <?php if(! $show_reset) { ?>
    <form method="post" action='pwreset.php'>
        <table>
            <tr>
                <td valign="top">
                    <br />Email Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                </td>
                <td>
                    <br /><input type="text" name="email" /><br />
                    <?php echo ($email_message); ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <br /><input type="submit" value="Send reset code" name="action"/> <br />
                    <em>or</em> <br />
                    <input type="submit" value="Enter reset code" name="action"/>
                </td>
            </tr>
        </table>
    </form>
    
    <?php 
    }
    if($show_reset) { 
    ?>
    <form method="post" action='pwreset.php?stage=resetcode'>
        <table>
            <tr>
                <td valign="top">
                    <br />Email Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                </td>
                <td>
                    <br /><?php echo ($email); ?><br />
                    <input type="hidden" name="email" value="<?php echo($email); ?>" />
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <br />Reset code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                </td>
                <td>
                    <br /><input type="text" name="reset_code" />
                    <?php echo ($reset_code_message); ?><br />
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <br />Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />

                </td>
                <td>
                    <br /><input type="password" name="password" />
                    <?php echo ($pass_message); ?><br />
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <br />Repeat password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                </td>
                <td>
                    <br /><input type="password" name="password_repeat" />
                    <?php echo ($pass_repeat_message); ?><br />
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <br /><input type="submit" value="Reset password"/> <br />
                </td>
            </tr>
        </table>
    </form>
    <?php } ?>
    
    <p>&nbsp;</p>
    <?php if($show_reset) { ?>
    <p><a href="pwreset.php">Request new reset code</a></p>
    <?php }?>
    <p><a href="index.php">Back to login.</a></p>
</div>
<?php
require '../lib/footer.php';