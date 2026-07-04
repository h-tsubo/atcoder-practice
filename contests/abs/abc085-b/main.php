<?php
$input = trim(stream_get_contents(STDIN));

$mochis = array_slice(array_map("intval", preg_split("/\s+/", $input)), 1);

$uniqueMochis = array_unique($mochis);

echo count($uniqueMochis) . PHP_EOL;
