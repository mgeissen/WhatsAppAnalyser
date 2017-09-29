<?php
include_once "Analyser.php";

$file = $_GET["file"];
$rows = file($file);

$parm = $_GET["type"];

$analyser = new Analyser($rows);
$analyser->analyse();
$analyser->createJson($parm);