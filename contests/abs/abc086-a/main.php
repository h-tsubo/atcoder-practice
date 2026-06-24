<?php
$input = trim(stream_get_contents(STDIN));
[$a, $b] = array_map('intval', preg_split('/\s+/', $input));

echo (($a * $b) % 2 === 0 ? "Even" : "Odd").PHP_EOL;
