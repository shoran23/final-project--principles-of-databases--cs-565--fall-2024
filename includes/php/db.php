<?php

function prepareDb(): PDO {
    include_once "config.php";

    $db = new PDO(
        "mysql:host=" . DBHOST . ";dbname=" . DBNAME . "charset=utf8",
        DBUSER,
        DBPASS
    );

    return $db;
}