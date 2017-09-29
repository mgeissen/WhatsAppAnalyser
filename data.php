<?php
include_once "Analyser.php";

$file = $_GET["file"];
$type = $_GET["type"];

$analyser = new Analyser($file);
$analyser->analyse();
echo $analyser->createJson($type);