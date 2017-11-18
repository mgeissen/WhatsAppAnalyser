<?php
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
switch ($lang){
    case "de":
        header("Location: ./web?lang=de");
        break;
    default:
        header("Location: ./web?lang=en");
        break;
}



