<?php 

include 'include/hash.php';

$pass = "a nice password!";
echo $pass."<br>";

$hash1 = create_hash($pass);
echo $hash1."<br>";

$hash2 = create_hash($pass);
echo $hash1."<br>";

