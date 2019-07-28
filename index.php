<?php

require_once("config.php");

$root = new Usuario();

$root -> loadbyid(5);

echo $root;
?>