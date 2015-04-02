<?php

function connect() {
  $m = new MongoClient();
  return $m->phpwall;
}

function inc_pages_served() {
  $db = connect();
  $db = $db->stats;
  $cursor = $db->find(array("pages_served"=>array('$exists'=>true)));
  if ($cursor->count() == 0) {
    $db->insert(array("pages_served"=>1));
  } else {
    $options = array("upsert" => true);
    $query = array('$inc'=>array("pages_served"=>1));
    $db->update(array(),$query,$options);
  }
}

function check_captcha() {
  $gurl = "https://www.google.com/recaptcha/api/siteverify";
  $secret = "pieintheskydogs";
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
  return ($json["success"] == true);
}

function nosuchuser($user,$db) {
  return ($db->count(array("username"=>$user)) == 0);
}

