<?php

function connect_comments() {
  $m = new MongoClient();
  $db = $m->wall->comments;
  return $db;
}

function connect_logins() {
  $m = new MongoClient();
  $db = $m->wall->logins;
  return $db;
}

function check_captcha() {
  $gurl = "https://www.google.com/recaptcha/api/siteverify";
  $secret = "supersecret";
  $remoteip = $_SERVER['REMOTE_ADDR'];
  $data = array('secret' => $secret, 'response' => $_POST['g-recaptcha-response'],'remoteip' => $remoteip);

  // use key 'http' even if you send the request to https://...
  $options = array(
      'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
          'method'  => 'POST',
          'content' => http_build_query($data),
      ),
  );
  $context  = stream_context_create($options);
  $result = file_get_contents($gurl, false, $context);
  $json = json_decode($result,true);
  return $json["success"];
}

function nosuchuser($user,$db) {
  return ($db->count(array("username"=>$user)) == 0);
}
