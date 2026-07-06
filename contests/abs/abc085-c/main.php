<?php
$input = trim(stream_get_contents(STDIN));
[$n, $y] = array_map("intval", preg_split("/\s+/", $input));

$ichiman = 10000;
$gosen = 5000;
$sen = 1000;

for ($i = 0; $i <= $n; $i++) {
  for ($j = 0; $j <= $n - $i; $j++) {
    $k = $n - $i - $j;
    $total = $ichiman * $i + $gosen * $j + $sen * $k;
    if ($total === $y) {
      echo "{$i} {$j} {$k}" . PHP_EOL;
      exit;
    }
  }
}

echo "-1 -1 -1" . PHP_EOL;