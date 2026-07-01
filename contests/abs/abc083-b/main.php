<?php
$input = trim(stream_get_contents(STDIN));
$nums = array_map("intval", preg_split("/\s+/", $input));

$n = $nums[0];
$a = $nums[1];
$b = $nums[2];

$ansSum = 0;

for ($i = 0; $i <= $n; $i++) {
  $digitSum = array_sum(array_map('intval', str_split((string) $i)));
  $ansSum = ($a <= $digitSum && $digitSum <= $b) ? $ansSum + $i : $ansSum;
}

echo $ansSum . PHP_EOL;