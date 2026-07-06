<?php
$input = trim(stream_get_contents(STDIN));
[$n, $y] = array_map("intval", preg_split("/\s+/", $input));

$target = $y / 1000 - $n;

for ($i = 0; $i <= $n; $i++) {
  $rest = $target - 9 * $i;

  if ($rest < 0) {
    continue;
  }
  if ($rest % 4 !== 0) {
    continue;
  }

  $j = $rest / 4;
  $k = $n - $i - $j;

  if ($j >=0 && $k >= 0) {
    echo "{$i} {$j} {$k}" . PHP_EOL;
    exit;
  }
}

echo "-1 -1 -1" . PHP_EOL;
