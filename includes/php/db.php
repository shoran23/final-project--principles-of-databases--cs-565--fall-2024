<?php

include_once "includes/php/components.php";
function connectDb(): PDO {
    include_once "config.php";

    $db = new PDO(
        "mysql:host=" . DBHOST . ";dbname=" . DBNAME . "charset=utf8",
        DBUSER,
        DBPASS
    );

    return $db;
}

function search($search) {
    try {
        $db = connectDb();

        // create the query
        // prepare query
        // execute query
        // check the statement results
        // create the table header
        // loop through the body
            // create each row


    } catch (PDOException $e) {
        // display the exception message
        exit;
    }


    print($search);
}