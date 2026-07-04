<?php
$input = trim(stream_get_contents(STDIN));
$mochis = array_slice(array_map("intval", preg_split("/\s+/", $input)), 1);

rsort($mochis);

$count = 0;
$prev = -1;

foreach($mochis as $mochi) {
  if ($mochi !== $prev) {
    $count++;
    $prev = $mochi;
  }
}

echo $count . PHP_EOL;
