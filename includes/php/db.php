<?php
include_once "components.php";
function connectDb(): PDO {
    include_once "config.php";
    return new PDO(
        "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8",
        DBUSER,
        DBPASS
    );
}

function insertUser($firstName, $lastName, $username, $email): void {
    echo "Insert Users";
    try {
        $db = connectDb();
        $statement = $db->prepare("INSERT INTO users (first_name, last_name, username, email) VALUES ('$firstName', '$lastName', '$username', '$email');");
        $result = $statement->execute();
        echo $result ? "<p>success</p>" : "<p>error</p>";

    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
}

function insertAccount($appName, $url, $comment, $username, $password): void {
    echo $appName . "\r";
    echo $url . "\r";
    echo $comment . "\r";
    echo $username . "\r";
    echo $password . "\r";
    try {
        $db = connectDb();
        $statement = $db->prepare("INSERT INTO accounts (app_name, url, password, comment, username, timestamp) VALUES ('$appName', '$url', '$password', '$comment', '$username', NOW());)");
        $result = $statement->execute();
        echo $result ? "<p>success</p>" : "<p>error</p>";
    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
}

function getUsernames(): array {
    echo "get user names";
    try {
        $db = connectDb();
        $statement = $db->prepare("SELECT username FROM users;");
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
    return [];
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