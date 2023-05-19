<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="/js/validation.js" defer></script>
</head>
<body>
    
    <h1>Signup</h1>
    
    <form action="signup.php" method="post" id="signup" novalidate>
        <input type="hidden" name="addUser">
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name">
        </div>
        
        <div>
            <label for="email">email</label>
            <input type="email" id="email" name="email">
        </div>
        
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        
        <div>
            <label for="password_confirmation">Repeat password</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>
        
        <button>Sign up</button>
        <p><a href="login.php">Log in</a>
    </form>
    
</body>
</html>



<?php
if(isset($_POST["addUser"])){
  if (empty($_POST["name"])) {
      die("Name is required");
  } else {

  }

  if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      die("Valid email is required");
  }

  if (strlen($_POST["password"]) < 5) {
      die("Password must be at least 5 characters");
  }

  if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
      die("Password must contain at least one letter");
  }

  if ( ! preg_match("/[0-9]/", $_POST["password"])) {
      die("Password must contain at least one number");
  }

  if ($_POST["password"] !== $_POST["password_confirmation"]) {
      die("Passwords must match");
  }

	$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

  //$mysqli = require __DIR__ . "/database.php";

    require_once('database.php');

   /*$sql="insert into user (name, email, password_hash) values ('".$name."','".$email."','".$password."')";
   if (!$mysqli->query($sql)){
    	echo("Error description: " . $mysqli -> error); 
   } else {
     header("Location: signup_success.html");
     exit();
   }*/
   
  $sql = "INSERT INTO user (name, email, password_hash)
          VALUES (?, ?, ?)";

  $stmt = $mysqli->prepare($sql);
  
  //if ( ! $stmt->prepare($sql)) {
      //die("SQL error: " . $mysqli->error);
  //}

  $stmt->bind_param("sss",
                    $_POST["name"],
                    $_POST["email"],
                    $password_hash);

  if ($stmt->execute()) {

      header("Location: signup_success.html");
      exit;

  } else {

      if ($mysqli->errno === 1062) {
          die("email already taken");
      } else {
          die($mysqli->error . " " . $mysqli->errno);
      }
  }
    
}
?>

