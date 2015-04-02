
<?php

function makePoast($document) {
  $author = $document["author"];
  $dt = $document["date"]->sec;
  $date = date('Y-m-d H:i:s',$dt);
  $title = $document["title"];
  $tags = $document["tags"];
  $posttext = $document["posttext"];
  echo "<h3>$title</h3>";
  //Tags
  $tagstr = "<p>Tags: <i>";
  $tagcount = 0;
  foreach ($tags as $tag) {
    $tagcount += 1;
    echo "<form action=\"blog.php\" name=\"tag_$tag\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"tag_search\" value=\"$tag\"></form>";
    $tag = "<a href=\"#\" onclick=\"document.forms['tag_$tag'].submit();\">$tag</a>";
    if ($tagcount>1) {
      $tagstr = $tagstr.", ".$tag;
    } else {
      $tagstr = $tagstr.$tag;
    }
  }
  echo $tagstr."</p></i>";
  echo "<div style=\"background: #d1f7ff;\" class=\"col-lg-12\">";
  echo $posttext."</div>";
  echo "<p class=\"small\">Posted by $author on $date</p>";
}

$db = connect();
$posts = $db->posts;
if (isset($_POST["tag_search"])) {
  $tag = (string)$_POST["tag_search"];
  $cursor = $posts->find(array("tags"=>array('$all'=>array($tag))));
  echo "<p> Viewing posts tagged with: $tag </p>";
} else {
  $cursor = $posts->find(array());
}
$cursor->sort(array("date"=>-1));
echo "<div style=\"background: AliceBlue;\" class=\"col-lg-12\">";
foreach ($cursor as $document) {
  makePoast($document);
}


?>

</div>
