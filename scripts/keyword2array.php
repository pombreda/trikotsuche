<?php
$csv = $argv[1];
$keywords = array();
$handle = fopen($csv, "r");
$row = 1;
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
  if (1 == $row++) continue;
  $num = count($data);
  $keyword = $data[0];
  $advertiser_competition = $data[1];
  $search_volume_local = $data[2];
  $search_volume_global = $data[3];
  $search_volume_avg = ($search_volume_local + $search_volume_global) / 2;
  $value = log($search_volume_avg * $advertiser_competition);
  if ((int)$value < 0) {
    $value = 1;
  }
  $keywords[$keyword] = $value;

}
fclose($handle);
arsort($keywords);

print "\$tags = array(\n";
foreach ($keywords as $word => $value) {
  print "  '$word' => $value,\n";
}
print "\n);";