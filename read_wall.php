
<script language="javascript">
   function doPostPrev(){
      document.forms["pag_form_prev"].submit();
   }
   function doPostNext(){
      document.forms["pag_form_next"].submit();
   }
</script>
<div style="padding-bottom: 50px;">
<div style="background: AliceBlue;" class="col-lg-12">
<?php
include_once("util.php");

inc_pages_served();

$countstart = 0;
$countstop = 35;

$db = connect()->comments;
$cursor = $db->find()->sort(array("date" => -1));
$numComments = $db->count();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST["countstart"])) {
    $countstart = (int)$_POST["countstart"];
  }
  if (!empty($_POST["countstop"])) {
    $countstop = (int)$_POST["countstop"];
  }
  if ($countstop < $countstart) {
    die("countstart/countstop out of range");
  }
  if ($countstop < 0) $countstop=0;
  if ($countstart < 0) $countstart=0;
}

echo "<form name=\"pag_form_prev\" action=\"index.php\" method=\"POST\">";
echo "<input type=\"hidden\" name=\"countstart\" value=\"".($countstart-35)."\">";
echo "<input type=\"hidden\" name=\"countstop\" value=\"".($countstop-35)."\">";
echo "</form>";
echo "<form name=\"pag_form_next\" action=\"index.php\" method=\"POST\">";
echo "<input type=\"hidden\" name=\"countstart\" value=\"".($countstart+35)."\">";
echo "<input type=\"hidden\" name=\"countstop\" value=\"".($countstop+35)."\">";
echo "</form>";

$pos = 0;
foreach ($cursor as $document) {
    if ($pos < $countstart) {
      continue;
    } else if ($pos >= $countstop) {
      break;
    }
    $dt = $document["date"]->sec;
    $date = date('Y-m-d H:i:s',$dt);
    if ($document["logged_in"]) {
      $author = "<strong>".$document["author"]."</strong>";;
    } else {
      $author = $document["author"];
    }
    echo $author . " said on " . $date . ":<br><p>" .
      $document["comment"] . "</p>";
    $pos += 1;
}

if ($pos==0) {
  echo "<p>Nothing to see here! No comments.</p>";
}

echo "<ul class=\"pager\"><li><a href=\"javascript:doPostPrev()";
echo "\">Previous</a></li><li><a href=\"javascript:doPostNext()";

echo "\">Next</a></li>";

echo "</ul><ul style=\"list-style-type: none;\"><li><label>Comments starting at: $countstart</li></label>";
echo "<li><label>Comments ending at: $countstop</li></label>";
echo "<li><label>Total comments to date: $numComments</li></label>";
?>

</ul>
</div>
</div>
<br><h2>Post New Entry</h2><br>
