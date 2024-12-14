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

function getKey($db) {
    try {
        $statement = $db->prepare("SELECT @key_str AS key_str;");
        $statement->execute();
        $cols = $statement->fetchAll();
        $keys = array_keys($cols[0]);
        foreach ($keys as $key) {
            echo $key;
        }
        //echo $cols[0]['key_str'];
        return $cols[0]['key_str'];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return "";
}

function getInitVector($db) {
    try {
        $statement = $db->prepare("SELECT @init_vector AS init_vector;");
        $statement->execute();
        $cols = $statement->fetchAll();
        //echo count($cols) . "\n";
        return $cols[0]['init_vector'];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return "";
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
    try {
        $db = connectDb();
        $query = "INSERT INTO accounts (app_name, url, comment, username, password, timestamp) VALUES ('{$appName}', '{$url}', '{$comment}', '{$username}', '{$password}', NOW());";
        $statement = $db->prepare($query);
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
    echo "Search";
    try {
        $db = connectDb();
        echo "<h1>Search</h1>";
        $statement = $db->prepare(
            "SELECT * FROM users NATURAL JOIN accounts WHERE " .
            "first_name LIKE '%{$search}%' OR " .
            "last_name LIKE '%{$search}%' OR " .
            "username LIKE '%{$search}%' OR " .
            "email LIKE '%{$search}%' OR " .
            "app_name LIKE '%{$search}%' OR " .
            "url LIKE '%{$search}%';"
         );

        $statement->execute();
        $cols = $statement->fetchAll();
        if(count($cols) > 0) {
            renderTable($cols);
        } else {
            echo "<p>no results</p>";
        }

        // pass the cols to the table component

        // create the table header
        // loop through the body
            // create each row

    } catch (PDOException $e) {
        renderErrorMessage($e);
        exit;
    }
}

function updateUser($attributeName, $attribute, $queryAttribute, $pattern): void {

    echo $attributeName . "\n";
    echo $attribute . "\n";
    echo $queryAttribute . "\n";
    echo $pattern . "\n";

    try {
        $db = connectDb();
        $query = "UPDATE users SET {$attributeName} = '{$attribute}' WHERE {$queryAttribute} = '{$pattern}';";
        $statement = $db->prepare($query);
        $result = $statement->execute();
        echo $result ? "<p>success</p>" : "<p>error</p>";
    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
}