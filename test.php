<?php

include 'include/hash.php';

echo $a = create_hash("Hello 1");
echo "<br>";
echo strlen($a);
echo "<br>";
echo "<br>";

echo $b = create_hash("Hello 1");
echo "<br>";
echo strlen($b);
echo "<br>";
echo "<br>";

echo validate_password("Hello 1", $a);
echo "<br>";
echo validate_password("Hello 1", $b);
echo "<br>";

echo validate_password("hello 1", $a);
echo "<br>";
