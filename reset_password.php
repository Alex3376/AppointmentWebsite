<?php

require_once "functions.php";

if (isset($_GET['email']) && isset($_GET['token'])) {
    require_once('database.php');

    $email = $mysqli->real_escape_string($_GET['email']);
    $token = $mysqli->real_escape_string($_GET['token']);

    $sql = $mysqli->query("SELECT id FROM user WHERE
			email='$email' AND token='$token' AND token<>'' AND tokenExpire > NOW()");

    if ($sql->num_rows > 0) {
        $newPassword = generateNewString();
        $newPasswordEncrypted = password_hash($newPassword, PASSWORD_BCRYPT);
        $mysqli->query("UPDATE user SET token='', password_hash = '$newPasswordEncrypted'
				WHERE email='$email'
			");

        echo "Your New Password Is $newPassword<br><a href='login.php'>Click Here To Log In</a>";
    } else
        redirectToLoginPage();
} else {
    redirectToLoginPage();
}
?>
