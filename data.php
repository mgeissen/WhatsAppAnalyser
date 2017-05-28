<?php
include_once "Analyser.php";
//$rows = file('chat3.txt');

$parm = $_GET["type"];

$analyser = new Analyser($rows);
$analyser->analyse();
$analyser->createJson($parm);