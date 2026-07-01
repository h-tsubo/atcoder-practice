<?php
$input = trim(stream_get_contents(STDIN));

$nums = array_map("intval", preg_split("/\s+/", $input));

$cards = array_slice($nums, 1);
rsort($cards);

$result = 0;

for ($i = 0; $i < count($cards); $i++) {
  $result = $i % 2 === 0 ? $result + $cards[$i]
    : $result - $cards[$i]; 
}

echo $result . PHP_EOL;
