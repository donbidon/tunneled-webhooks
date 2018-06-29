<?php

error_reporting(E_ERROR);

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

echo "<pre>";
if (empty($_GET['_details'])) {
    echo sprintf(
        "SERVER_NAME = \"%s\"\n" .
        "HTTP_X_FORWARDED_PROTO = \"%s\"\n" .
        "HTTP_X_FORWARDED_FOR = \"%s\"",
        $_SERVER['SERVER_NAME'],
        $_SERVER['HTTP_X_FORWARDED_PROTO'],
        $_SERVER['HTTP_X_FORWARDED_FOR']
    );
} else {
    print_r($_SERVER);
}
