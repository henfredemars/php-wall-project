<?php

echo "<p>";
$rand_keys = array_rand($lines, rand(3,150));
$vals = array();
foreach ($rand_keys as $key) {
  array_push($vals,$lines[$key]);
}
shuffle($vals);
foreach ($vals as $val) {
  echo $val." ";
}

$limit = rand(0,11);
echo "<br><br>";
for ($count=0;$count<$limit;$count+=1) {
  $start = substr(md5(rand()), 3, 12);
  $dom = rand(0,2);
  if ($dom==0) {
    $app = ".com";
  } else if ($dom==1) {
    $app = ".net";
  } else if ($dom==2) {
    $app = ".edu";
  }
  $end = substr(md5(rand()), 3, 12).$app;
  echo "Contact he at: $start"."@"."$end<br>";
}

?>
