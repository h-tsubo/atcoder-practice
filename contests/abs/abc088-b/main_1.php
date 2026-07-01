<?php
$input = trim(stream_get_contents(STDIN));
$nums = array_map("intval", preg_split("/\s+/", $input));

$cards = array_slice($nums, 1);

$count = 0;
$result = 0;

while (count($cards) > 0) {
  $max = max($cards);
  $index = array_search($max, $cards, true);

  $result = $count % 2 === 0 ? $result + $max : $result - $max;

  array_splice($cards, $max, 1);

  $count++;
}

echo $result . PHP_EOL;
