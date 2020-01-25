<?php
/**
 * Created by PhpStorm.
 * User: friedkiwi
 * Date: 20/02/2019
 * Time: 18:11
 */

require_once('../config.php');
require_once('../lib/lib.php');

if (!allow_registration()) {
    header("Location: index.php");
    exit();
}

$top_message = "";
$user_message = "";
$pass_message = "";
$pass_repeat_message = "";

$message_id = $_GET['message'];

if ($message_id == '1') {
    $user_message = '<span style="color: red">Please specify a username.</span>';
} else if ($message_id == '2') {
    $pass_message = '<span style="color: red">Please specify a password.</span>';
} else if ($message_id == '3') {
    $pass_repeat_message = '<span style="color: red">Passwords don\'t match.</span>';
} else if ($message_id == '4') {
    $user_message = '<span style="color: red">User already exists.<br/>If you forgot your password, please contact an admin.</span>';
} else if ($message_id == '5') {
    $top_message = '<span style="color: red">An unexpected error occurred while attempting to create your login. Please contact the board.</span>';
} else if ($message_id == '6') {
    $email_message = '<span style="color: red">Invalid email address.</span>';
}

require("../lib/header.php");
?>
    <div class="container">
<h3>Account Registration</h3>
<hr />
<?php echo ($top_message); ?>
<form method="post" action="create_user.php">
<table>
    <tr>
        <td valign="top">
            <br />Username&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
        </td>
        <td>
            <br /><input type="text" name="username" />
            <?php echo ($user_message); ?><br />
        </td>
    </tr>
    <tr>
        <td valign="top">
            <br />Email Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
        </td>
        <td>
            <br /><input type="text" name="email" />
            <?php echo ($email_message); ?><br />
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
        <td valign="top">
            &nbsp;
        </td>
        <td valign="top">
            <br /><input type="submit" value="Create account." name="action" />
        </td>
    </tr>
</table>
    <p><a href="index.php">Back to login.</a></p>
</form>
    </div>
<?php
require ("../lib/footer.php");
