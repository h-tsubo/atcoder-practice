<?php

$input = trim(stream_get_contents(STDIN));
$tokens = preg_split('/\s/', $input);

$a = intval($tokens[0]);
$b = intval($tokens[1]);
$c = intval($tokens[2]);
$s = $tokens[3];

echo($a + $b + $c) . ' ' . $s . PHP_EOL;
