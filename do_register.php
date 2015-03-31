<form action="register.php" method="POST">
<div style="padding-bottom: 25px;">
Username: 
<input type="text" name="username">
Password: 
<input type="password" name="password"><br></div>
<div class="g-recaptcha" data-sitekey="6LdBTAQTAAAAAIVAup0eBvTZISBCqnKfD5IzH71s"></div><br>
<input type="submit" value="Register New Account" class="btn btn-default">
</form>


<?php
include("util.php");
include("password.php");

function handle() {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = connect()->logins;
    $username = (string)$_POST["username"];
    $_password = (string)$_POST["password"];
    $password = password_hash($_password, PASSWORD_BCRYPT);
    $date = new MongoDate();
    if (trim($_password) == false) {
      echo "<p>Your password should not be empty.</p>";
      return;
    } else if (trim($username) == false) {
      echo "<p>You must have a username!</p>";
      return;
    } else if (!nosuchuser($username,$db)) {
      echo "<p>User already exists!</p>";
      return;
    } else if (!check_captcha()) {
      echo "<p>Human-ness test failed. Are you human?</p>";
      return;
    }
    $hits = $db->insert(array("username"=>$username,"password"=>$password,"date"=>$date));
    echo "<p>Welcome. Your account has been created as $username.</p>";
  }
}

handle();

?>
