<?php
include_once "components.php";
function connectDb(): PDO {
    include_once "config.php";

    $db = new PDO(
        "mysql:host=" . DBHOST . ";dbname=" . DBNAME . "charset=utf8",
        DBUSER,
        DBPASS
    );

    return $db;
}

function search($search): void {
    try {
        $db = connectDb();
        echo "<h1>Search</h1>";
        $statement = $db->prepare("SELECT * FROM ");
        // create the query
        // prepare query
        // execute query
        // check the statement results
        // create the table header
        // loop through the body
            // create each row
    } catch (PDOException $e) {
        renderErrorMessage($e);
        exit;
    }
}

function update($attributeName, $attribute, $queryAttribute, $pattern): void {
    try {
        $db = connectDb();
        //$statement = $db->prepare("");
    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
}