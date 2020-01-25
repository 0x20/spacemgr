<?php
/**
 * Created by PhpStorm.
 * User: friedkiwi
 * Date: 18/02/2019
 * Time: 19:36
 */


require_once('../config.php');
require_once('../lib/lib.php');

if (is_logged_in()) {
    header('Location: ./account.php');
    exit();
}

if ($_POST['username'] != '' && $_POST['password'] != '') {
    $message = '';
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if (is_valid_user($user, $pass)) {
        $_SESSION['user'] = $user;
        header('Location: /index.php');
        exit();
    } else {
        $message = 'Invalid username and/or password.';
    }
}


$user = $_POST['username'];

require('../lib/header.php')
?>
<div class="container">
    <h3>Login</h3>
    <hr />
    <p style="color: red;">
        <?php echo ($message);  ?>
    </p>
    <form method="post">
        <table>
            <tr>
                <td>
                    <br />Username&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                </td>
                <td>
                    <br /><input type="text" name="username" value="<?php echo($user); ?>"/><br />
                </td>
            </tr>
            <tr>
                <td>
                    <br />Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                </td>
                <td>
                    <br /><input type="password" name="password" /><br />
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
                <td>
                    <br /><input type="submit" value="Log in"/><br /><br />
                </td>
            </tr>
        </table>
    </form>
    <p>
        <?php  if (allow_registration()) {?>
            <a href="register.php">Register new account</a><br />
        <?php } ?>
            <a href="pwreset.php">Reset password</a><br />
    </p>
</div>
<?php
require('../lib/footer.php')
?>