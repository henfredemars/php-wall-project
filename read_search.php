
<div>
<form action="search.php" method="POST">
Search string:<br>
<input type="text" name="searchstr">
<input type="submit" value="Post Search" class="btn btn-default">
</form>
</div><br>

<?php

include_once("util.php");

inc_pages_served();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $db = connect()->comments;
  $search = (string)$_POST["searchstr"];
  $where = array('comment' => array('$regex' => new MongoRegex("/$search/i")));
  $cursor = $db->find($where)->sort(array("date" => -1));
  foreach ($cursor as $document) {
    $dt = $document["date"]->sec;
    $date = date('Y-m-d H:i:s',$dt);
    echo $document["author"] . " said on " . $date . ":<br><p>" .
      $document["comment"] . "</p>";
  }
}

?>
