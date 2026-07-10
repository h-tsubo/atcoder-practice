<?php
$s = trim(stream_get_contents(STDIN));

$matched = preg_match('/^(dream|dreamer|erase|eraser)+$/', $s);

echo ($matched ? "YES" : "NO") . PHP_EOL;