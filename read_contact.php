    <form action="contact.php" method="POST">
      <div class="g-recaptcha" data-sitekey="6LdBTAQTAAAAAIVAup0eBvTZISBCqnKfD5IzH71s"></div>
      <br/>
      <input type="submit" value="Get Contact Information" class="btn btn-default">
    </form><br>

<?php
include_once("util.php");

inc_pages_served();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (check_captcha()) {
    echo "<p>Human-ness verified. You may email me at admin.frog.boom0625@dfgh.net<p>";
  } else {
    echo "<p>CAPTCHA Failed. Are you sure that you're a human?</p>";
  }
}

?>
