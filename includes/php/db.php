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

    //echo $password . "\n";

    try {
        $db = connectDb();

        $key = getKey($db);
        $initVector = getInitVector($db);

        $query = "INSERT INTO accounts (app_name, url, password, comment, username, timestamp) VALUES(:appName, :url, AES_ENCRYPT(:password, :keyStr, :initVector), :comment, :username, NOW());";
        $statement = $db->prepare($query);
        $statement->bindValue('appName', $appName, PDO::PARAM_STR);
        $statement->bindValue('url', $url, PDO::PARAM_STR);
        $statement->bindValue('password', $password, PDO::PARAM_STR);
        $statement->bindValue('comment', $comment, PDO::PARAM_STR);
        $statement->bindValue('username', $username, PDO::PARAM_STR);
        $statement->bindValue("keyStr", $key, PDO::PARAM_STR);
        $statement->bindValue("initVector", $initVector, PDO::PARAM_STR);
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
        foreach ($cols as $col) {
            echo $col["first_name"];
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

function update($attributeName, $attribute, $queryAttribute, $pattern): void {
    try {
        $db = connectDb();
        //$statement = $db->prepare("");
    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
}