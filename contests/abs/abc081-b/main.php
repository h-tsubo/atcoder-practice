<?php

$input = trim(stream_get_contents(STDIN));
$numbers = array_map('intval', preg_split('/\s+/', $input));

$numbers = array_slice($numbers, 1);

$count = 0;

while(count(array_filter($numbers, fn($num) => $num % 2 !== 0)) === 0) {
  $numbers = array_map(fn($num) => intdiv($num, 2), $numbers);
  $count++;
}

echo $count . PHP_EOL;