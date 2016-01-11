<?php

include 'include/hash.php';

echo $a = create_hash("Hello 1");
echo "<br>";

echo create_hash("Hello 1");
echo "<br>";

echo validate_password("Hello 1", $a);
echo "<br>";

echo validate_password("hello 1", $a);
echo "<br>";
