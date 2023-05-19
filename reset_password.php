<?php

  if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      die("Valid email is required");
  }
  
  if (isset($_POST['email'])) {
      require_once('database.php');
      
      $email = $mysqli->real_escape_string($_POST["email"]);
      
      $sql = $mysqli->query("SELECT id FROM user WHERE email='$email'");
      if ($sql->num_rows > 0) {
          
          $token = "poitzgdjfkmwfhbughcbdjbfvqz1234567890";
          $token = str_shuffle($token);
          $token = sub($token, 0, 10);
          
          $mysqli->query("UPDATE user SET token='$token', "
                  . "tokenExpire=DATE_ADD(NOW(), INTERVAL 5 MINUTE
                  WHERE email ='$email'");
          
          exit('please check your email inbox');
      } else
          exit('please check your inputs');
  }
?>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <form method="post">
        <label for="email">Reset your password</label>
        <input type="email" name="email" id="email">
        <button>Log in</button>
    </form>
</body>
</html>
