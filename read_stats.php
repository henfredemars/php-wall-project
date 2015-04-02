
<?php

include_once("util.php");

inc_pages_served();

$db = connect();
$stats = $db->stats;
$cursor = $stats->find(array("pages_served"=>array('$exists'=>true)));
$pages_served = $cursor->getNext()["pages_served"];
echo "<p>Pages Served: $pages_served</p>";
$parent = dirname(__FILE__);
exec("$parent/gather_stats.py",$output);
foreach ($output as $line) {
  echo "$line<br>";
}

?>


