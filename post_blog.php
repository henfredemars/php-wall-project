<?php include("header.php") ?>

<script>tinymce.init({selector:'textarea'});</script>

<!-- Page Content -->
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>New Blog Post</h1>

<?php

$db = connect();
$nopermstr = "You do not have permission to access this page.";
if (isset($_SESSION["username"])) {
  $username = $_SESSION["username"];
  $cursor = $db->logins->find(array("username"=>$username,"type"=>"Admin"));
  if ($cursor->count() == 0) {
    die($nopermstr);
  }
} else {
  die($nopermstr);
}
echo "<p>Logged in as <strong>henfredemars</strong>.</p>";

function tagsify($tagsstr) {
  $tags = explode(",",$tagsstr);
  $new_tags = array();
  for ($i = 0;$i<count($tags);$i+=1) {
    $tags[$i] = trim($tags[$i]);
    if (empty($tags[$i])) {
      continue;
    } else {
      array_push($new_tags,$tags[$i]);
    }
  }
  return $new_tags;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $author = $_SESSION["username"];
  if (empty($author)) die("Author cannot be empty.");
  $title = (string)$_POST["title"];
  if (empty($title)) die("Title cannot be empty.");
  $posttext = (string)$_POST["posttext"];
  if (empty($posttext)) die("Post text cannot be empty");
  $tagsstr = (string)$_POST["tagsstr"];
  $tags = tagsify($tagsstr);
  $db->posts->createIndex(array("title"=>1),array("unique"=>true));
  $document = array("author"=>$author,"title"=>$title,"posttext"=>$posttext,"tags"=>$tags,
			"date"=>new MongoDate());
  try {
    $status = $db->posts->insert($document);
  } catch (MongoException $e) {
    die("Unable to meet database insertion requirements.");
  }
  if ($status !== true and !empty($status["err"])) {
    die($status["err"]);
  }
  echo "<p>Your post has been created.</p>";

}

?>
<form role="form" action="post_blog.php" method="POST">
Title: <input type="text" name="title">
Tags: <input type="text" name="tagsstr">
<textarea class="form-control" rows="14" name="posttext"></textarea><br>
<input type="submit" value="Post New Blog Entry" class="btn btn-default">
</form>


                <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
            </div>
        </div>
    </div>
</div>
<!-- /#page-content-wrapper -->

<?php include("close_header.html"); ?>


