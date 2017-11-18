<?php
require_once "lib/streams.php";
require_once "lib/gettext.php";

$local_lang = $_GET["lang"];
$file_path = "./locale/$local_lang.mo";
$locale_file = new FileReader($file_path);
$local_fetch = new gettext_reader($locale_file);

function __($text){
    $locale_fetch = $GLOBALS["local_fetch"];
    return $locale_fetch->translate($text);
}

include_once "Frontend.php";
(new Frontend())->start();