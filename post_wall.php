<form role="form" action="index.php" method="POST">
      Name: <input type="text" name="author"> Deletion Password: <input type="password" name="password">
      Delete this Password Now?&nbsp<input name="delete" type="checkbox" value="delete"><br>
      <textarea class="form-control" rows="5" id="comment" name="comment"></textarea><br>
      <div class="g-recaptcha" data-sitekey="6LdBTAQTAAAAAIVAup0eBvTZISBCqnKfD5IzH71s"></div>
      <br/>
      <input type="submit" value="Post Message to PHP Wall" class="btn btn-default">
</form><br>

<?php

function post_comment($c,$a,$p) {
  $db = connect()->comments;
  $a = htmlspecialchars(trim($a));
  $c = htmlspecialchars(trim($c));
  if (empty($a) or empty($c)) {
    echo "<p>You can't post that.</p>";
    return false;
  }
  if (empty($p)) {
    $p = md5(rand());
  }
  $date = new MongoDate();
  if ($db->find(array("deletionpassword"=>$p,"author"=>$a))->count() > 0) {
    echo "<p>Password for this author is already in use.</p>";
    return false;
  }
  $document = array("date"=>$date,
    "author"=>$a,"comment"=>$c,"deletionpassword"=>$p);
  $db->insert($document);
  return true;
}

function delete_comment($a,$p) {
  $db = connect()->comments;
  $status = $db->remove(array("author"=>$a,"deletionpassword"=>$p));
  if ($status === true) {
    return false;
  } else if ($status["n"] > 0) {
    return true;
  } else {
    return false;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ((string)$_POST["delete"] != "delete") {
    if (check_captcha()) {
      if (post_comment((string)$_POST["comment"],(string)$_POST["author"],(string)$_POST["password"])) {
        header("Location: index.php");
      }
    } else {
      echo "<p>CAPTCHA Failed. Post discarded.</p>";
    }
  } else { //Delete
    if (check_captcha()) {
      $password = (string)$_POST["password"];
      $author = (string)$_POST["author"];
      if (empty($author)) {
        echo "<p>You must specify an author to delete a post.</p>";
      } else {
        if (delete_comment($author,$password)) {
          echo "<p>Post was deleted.</p>";
          echo "<META HTTP-EQUIV=Refresh CONTENT=\"3\"; URL=\"index.php/\">";
        } else {
          echo "<p>Failed to delete a post.</p>";
        }
      }
    } else {
      echo "<p>CAPTCHA Failed. Nothing was deleted.</p>";
    }
  }
}

?>
