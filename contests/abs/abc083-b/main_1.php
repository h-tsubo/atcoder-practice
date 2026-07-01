<?php
$input = trim(stream_get_contents(STDIN));
$nums = array_map("intval", preg_split("/\s+/", $input));

$n = $nums[0];
$a = $nums[1];
$b = $nums[2];

$ansSum = 0;

for ($i = 0; $i <= $n; $i++) {
  $digitSum = 0;
  $num = $i;
  while($num > 0) {
    $digitSum += $num % 10;
    $num = intdiv($num, 10);
    // あるいは
    // $num = floor($num / 10);
  }

  if ($a <= $digitSum && $digitSum <= $b) {
    $ansSum += $i;
  }
}

echo $ansSum . PHP_EOL;
