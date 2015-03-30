<form action="login.php" method="POST">
Username: 
<input type="text" name="username">
Password: 
<input type="password" name="password">
<input type="submit" value="Submit Login" class="btn btn-default">
</form>


<?php
include("util.php");
include("password.php");

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = (string)$_POST["username"];
  $password = (string)$_POST["password"];
  $db = connect_logins();
  $hits = $db->count(array("username"=>$username));
  if ($hits==1) {
    $cursor = $db->find(array("username"=>$username));
    $document = $cursor->getNext();
    sleep(3);
    if (password_verify($password,$document["password"])) {
      $_SESSION["username"] = $username;
      echo "<p>You are now logged in.</p>";
    } else {
      echo "<p>Authentication failed.</p>";
    }
  } else {
    echo "<p>Authentication failed.</p>";
  }
} else {
  if (isset($_SESSION["username"])) {
    echo "<p>Currently logged in as ".$_SESSION["username"]."</p>";
  } else {
    echo "<p>Not logged in.</p>";
  }
}

?>
