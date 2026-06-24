<?php

$input = trim(stream_get_contents(STDIN));
$chars = str_split($input);

$count = count(array_filter($chars, fn($v) => $v === "1"));

echo($count) . PHP_EOL;

// 以下と同じ
// $result = 0;

// for ($i = 0; $i < count($chars); $i++) {
//   if ($chars[$i] === "1") {
//     $result++;
//   }
// }

// echo($result) . PHP_EOL;

