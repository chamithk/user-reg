<?php
/* (A) ALREADY SIGNED IN - TO HOME PAGE
if (isset($_SESSION["user"])) {
	header("Location: HOME.PAGE");
	exit();
}
*/

// (B) PROCESS REGISTRATION
if (count($_POST)>0) {
  require "2-user-lib.php";
  $pass = $USR->register($_POST["name"], $_POST["email"], $_POST["pass"]);
  if ($pass) {
    // header("Location: HOME.PAGE");
    exit("SUCCESSFUL!");
  }
}

// (C) REGISTRATION FORM ?>
<!DOCTYPE html>
<html>
  <head>
    <title>User Registration</title>
    <link rel="stylesheet" href="3-register.css">
    <script src="3-register.js"></script>
  </head>
  <body>
    <!-- (C1) ERROR MESSAGE (IF ANY) -->
    <?php
    if (isset($pass) && $pass==false) {
      echo "<div class='error'>$USR->error</div>";
    } ?>

    <!-- (C2) REGISTRATION FORM -->
    <form method="post" id="register" onsubmit="return check()">
      <h2>REGISTER</h2>
      <input type="text" name="name" placeholder="Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="pass" placeholder="Password" required>
      <input type="password" name="cpass" placeholder="Confirm Password" required>
      <input type="submit" value="Register">
    </form>
  </body>
</html>