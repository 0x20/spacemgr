<?php
/**
 * Created by PhpStorm.
 * User: friedkiwi
 * Date: 18/02/2019
 * Time: 19:07
 */

// globals:

$navigation = array();


function is_logged_in() {
    if (is_null($_SESSION['user']))
        return false;

    return $_SESSION['user'] != '';
}

function is_valid_user($username, $password) {
    $errormsg = "";
    return pam_auth($username, $password, $errormsg, false);
}


function update_password($username, $newpassword) {
    global $CONFIG;
    
    $user_param = escapeshellarg($username);
    $newpass_param = escapeshellarg($newpassword);
    
    $result = shell_exec("sudo samba-tool user setpassword $user_param --newpassword=$newpass_param");
    
    if (trim($result) == 'Changed password OK') {
        return true;
    } else {
        return false;
    }
}


function ip_in_range( $ip, $range ) {
    if ( strpos( $range, '/' ) == false ) {
        $range .= '/32';
    }
    // $range is in IP/CIDR format eg 127.0.0.1/24
    list( $range, $netmask ) = explode( '/', $range, 2 );
    $range_decimal = ip2long( $range );
    $ip_decimal = ip2long( $ip );
    $wildcard_decimal = pow( 2, ( 32 - $netmask ) ) - 1;
    $netmask_decimal = ~ $wildcard_decimal;
    return ( ( $ip_decimal & $netmask_decimal ) == ( $range_decimal & $netmask_decimal ) );
}

function allow_registration() {
    global $CONFIG;

    $client_ip = $_SERVER["REMOTE_ADDR"];

    foreach ($CONFIG["ALLOWED_CREATION_IPS"] as $range) {
        if (ip_in_range($client_ip, $range))
            return true;
    }

    return false;
}

function get_db_conn() {
    global $CONFIG;
    $host = $CONFIG['pg_host'];
    $user = $CONFIG['pg_user'];
    $pass = $CONFIG['pg_pass'];
    $db = $CONFIG['pg_db'];
    return pg_connect("host=$host dbname=$db user=$user password=$pass");
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function get_user_email($username) {
    $email = "";
    $username_esc = pg_escape_string($username);
    $conn = get_db_conn();
    $result = pg_query($conn, "SELECT email FROM userdata WHERE username='$username_esc';");
    if (!$result) {
        pg_close($conn);
        return $email;
    }
    $row = pg_fetch_row($result);
    if (!$row) {
        pg_close($conn);
        return $email;
    }
    $email = $row[0];
    pg_close($conn);
    return $email;
}

function user_exists($username) {
    $user_esc = pg_escape_string($username);
    $conn = get_db_conn();
    $result = pg_query($conn, "SELECT * FROM userdata WHERE username='$user_esc'");
    if (!$result)
        return false;
    if ($row = pg_fetch_row($result))
        return true;
    else
        return false;
}

function update_email($username, $new_email) {
    $user_esc = pg_escape_string($username);
    $email_esc = pg_escape_string($new_email);
    
    $conn = get_db_conn();
    $result = pg_query($conn, "UPDATE userdata SET email='$email_esc' WHERE username='$user_esc';");
    
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function get_username_from_email($email) {
    $email_esc = pg_escape_string($email);
    $conn = get_db_conn();
    $username = '';
    
    $result = pg_query($conn, "SELECT username FROM userdata WHERE email='$email_esc'");
    
    if ($result) {
        if ($row = pg_fetch_row($result)) {
            $username = $row[0];
        }
    }
    
    pg_close($conn);
    return $username;
}

function generate_reset_code($username) {
    $reset_code = rand(10000000, 99999999);
    $user_escape = pg_escape_string($username);
    
    $conn = get_db_conn();
    
    $result = pg_query("INSERT INTO resetcodes(username, resetcode, expiration_date) VALUES ('$user_escape', $reset_code, NOW() + interval '1 day')");
    
    if ($result) {
        pg_close($conn);
        return $reset_code;
    } else {
        pg_close($conn);
        return -1;
    }
}

function validate_reset_code($username, $resetcode) {
    $reset_escape = pg_escape_string($resetcode);
    $user_escape = pg_escape_string($username);
    $is_valid_code = false;
    $conn = get_db_conn();
    
    $result = pg_query("SELECT * FROM resetcodes WHERE username='$user_escape' AND resetcode=NULLIF('$reset_escape', '')::int AND expiration_date > NOW() AND used = false;");
    
    if($result) {
        if ($row = pg_fetch_row($result)) {
            $is_valid_code = true;
        }
    }
    
    pg_close($conn);
    return $is_valid_code;
}

function spend_reset_code($username, $resetcode) {
    $reset_escape = pg_escape_string($resetcode);
    $user_escape = pg_escape_string($username);
    $conn = get_db_conn();
    
    $result = pg_query("UPDATE resetcodes SET used=true WHERE username='$user_escape' AND resetcode=NULLIF('$reset_escape', '')::int");
    
    pg_close($conn);
    
}

function send_reset_code_email($email, $username, $resetcode) {
    if ($resetcode < 10000000) {
        return;
    }
}

function create_user($username, $email, $pass) {
    $conn = get_db_conn();
    
   
    $user_shellesc = escapeshellarg($username);
    $pass_shellesc = escapeshellarg($pass);
    
    $ldap_create_res = shell_exec("sudo /usr/sbin/kadmin.local addprinc -pw $pass_shellesc $user_shellesc");
    
    $user_db_esc = pg_escape_string($username);
    $email_db_esc = pg_escape_string($email);
    $result = pg_query($conn, "INSERT INTO userdata(username,email) VALUES('$user_db_esc','$email_db_esc')");
    if ($result)
        return true;
    else
        return false;

}