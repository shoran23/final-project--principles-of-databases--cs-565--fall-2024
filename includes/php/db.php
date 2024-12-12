<?php

function connectDb(): PDO {
    include_once "config.php";

    $db = new PDO(
        "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8",
        DBUSER,
        DBPASS
    );

    return $db;
}

function search($search) {
    try {
        $db = connectDb();

        echo "<h1>Search</h1>";

        // create the query
        // prepare query
        // execute query
        // check the statement results
        // create the table header
        // loop through the body
            // create each row


    } catch (PDOException $e) {
        // display the exception message
        echo "<p>Error in the Search function</p>";
        echo '<p id=="error">' . $e->getMessage() . '</p>';
        echo '<p>Click <a href="/">here</a> to go back</p>';
        exit;
    }


}