<?php
$input = trim(stream_get_contents(STDIN));

$nums = array_map('intval', preg_split('/\s+/', $input));

$a = $nums[0];
$b = $nums[1];
$c = $nums[2];
$x = $nums[3];

$count = 0;

for ($i = 0; $i <= $a; $i++) {
  for ($j = 0; $j <= $b; $j++) {
    for ($k = 0; $k <= $c; $k++) {
      $total = 500 * $i + 100 * $j + 50 * $k;

      if ($total === $x) {
        $count++;
      }
    }
  }
}

echo $count . PHP_EOL;
