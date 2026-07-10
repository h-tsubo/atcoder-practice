<?php
$s = trim(stream_get_contents(STDIN));
$s = strrev($s);

$words = ["dream", "dreamer", "erase", "eraser"];
$words = array_map(fn($w) => strrev($w), $words);

while (strlen($s) > 0) {
  $matched = false;

  foreach ($words as $word) {
    if (str_starts_with($s, $word)) {
      $s = substr($s, strlen($word));
      $matched = true;
      break;
    }
  }

  if (! $matched) {
    echo "NO" . PHP_EOL;
    exit;
  }
}

echo "YES" . PHP_EOL;