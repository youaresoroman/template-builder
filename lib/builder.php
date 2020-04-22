<?php
if (!@include $_SERVER["DOCUMENT_ROOT"].'/vendor/autoload.php') {
    if (!@include 'C:\Users\Мой\vendor\autoload.php') {
    }
}
require_once "engine.php";
require_once "gzip.php";
use MatthiasMullie\Minify;

function savepage($project_name, $path = '', $filename, $stream = ''): bool
{
    if ($path != '' && !file_exists($_SERVER["DOCUMENT_ROOT"]."$project_name/pages/$path")) {
        mkdir($_SERVER["DOCUMENT_ROOT"]."$project_name/pages/$path");
    }
    if (file_put_contents($_SERVER["DOCUMENT_ROOT"]."/$project_name/pages/$path$filename", $stream)) {
        return true;
    } else {
        return false;
    }  
}

function minify($tempfile) {
    $minifier = new Minify\JS($tempfile);
    return $minifier->gzip();
}

function autobuild($project_name, $page) {

}
?>