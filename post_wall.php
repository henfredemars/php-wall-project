<form role="form" action="index.php" method="POST">
      Name: <input type="text" name="author"><br>
      <textarea class="form-control" rows="5" id="comment" name="comment"></textarea><br>
      <div class="g-recaptcha" data-sitekey="6LdBTAQTAAAAAIVAup0eBvTZISBCqnKfD5IzH71s"></div>
      <br/>
      <input type="submit" value="Post Message to PHP Wall" class="btn btn-default">
</form><br>

<?php

function post_comment($c,$a) {
  $db = connect_comments();
  $a = htmlspecialchars(trim($a));
  $c = htmlspecialchars(trim($c));
  if (empty($a) or empty($c)) {
    echo "<p>You can't post that.</p>";
    return false;
  }
  $date = new MongoDate();
  $document = array("date"=>$date,
    "author"=>$a,"comment"=>$c);
  $db->insert($document);
  return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" and !empty($_POST["g-recaptcha-response"])) {
  if (check_captcha()) {
    if (post_comment((string)$_POST["comment"],(string)$_POST["author"])) {
      header("Location: index.php");
    }
  } else {
    echo "<p>CAPTCHA Failed. Post discarded.</p>";
  }
}

?>
