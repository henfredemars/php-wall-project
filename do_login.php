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

function check_ip_recent($ip,$db) {
  $time = new MongoDate();
  $db = $db->login_attempts;
  $cursor = $db->find(array("ip"=>$ip));
  $cursor->sort(array("time" => -1));
  if ($cursor->count() >= 1) {
    $document = $cursor->getNext();
    return ($time->sec-$document["time"]->sec < 15);
  } else {
    return false;
  }
}

function add_login_attempt($ip,$db) {
  $db = $db->login_attempts;
  $db->insert(array("ip"=>$ip,"time"=>new MongoDate()));
}

session_start();
function handle() {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = connect();
    if (check_ip_recent($_SERVER["REMOTE_ADDR"],$db)) {
      echo "<p>Last login attempt was too recent. Please wait and try again.</p>";
      return;
    } else {
      add_login_attempt($_SERVER["REMOTE_ADDR"],$db);
    }
    $username = (string)$_POST["username"];
    $password = (string)$_POST["password"];
    $db = $db->logins;
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
}

handle();

?>
