<?php
$input = trim(stream_get_contents(STDIN));
$mochis = array_slice(array_map("intval", preg_split("/\s+/", $input)), 1);

$count = 0;

while (count($mochis) > 0) {
  $maxMochi = max($mochis);
  $mochis = array_filter($mochis, fn($mochi) => $mochi !== $maxMochi);

  $count++;
}

echo $count . PHP_EOL;
