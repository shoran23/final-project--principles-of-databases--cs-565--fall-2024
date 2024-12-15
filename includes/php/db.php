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

function searchUsers($search): void {
    try {
        $db = connectDb();
        $statement = $db->prepare("SELECT * FROM users WHERE " .
            "first_name LIKE '%{$search}%' OR " .
            "last_name LIKE '%{$search}%' OR " .
            "username LIKE '%{$search}%' OR " .
            "email LIKE '%{$search}%'"
        );
        $statement->execute();
        $cols = $statement->fetchAll();
        if (empty($cols)) {
            echo "<h1>No Results</h1>";
        } else {
            renderTable($cols);
        }
    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
}

function searchAccounts($search): void {
    try {
        $db = connectDb();
        $statement = $db->prepare("SELECT * FROM accounts WHERE " .
            "app_name LIKE '%{$search}%' OR " .
            "url LIKE '%{$search}%' OR " .
            "comment LIKE '%{$search}%' OR " .
            "username LIKE '%{$search}%';"
        );
        $statement->execute();
        $cols = $statement->fetchAll();
        if (empty($cols)) {
            echo "<h1>No Results</h1>";
        } else {
            renderTable($cols);
        }
    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
}

function searchBoth($search): void {
    try {
        $db = connectDb();
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
            echo "<h1>No Results</h1>";
        }
    } catch (PDOException $e) {
        renderErrorMessage($e);
        exit;
    }
}

function updateUser($attributeName, $attribute, $queryAttribute, $pattern): void {
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

function updateAccount($attributeName, $attribute, $queryAttribute, $pattern): void {
    try {
        $db = connectDb();
        $query = "UPDATE accounts SET {$attributeName} = '{$attribute}' WHERE {$queryAttribute} = '{$pattern}';";
        $statement = $db->prepare($query);
        $result = $statement->execute();
        echo $result ? "<p>success</p>" : "<p>error</p>";
    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
}

function deleteAccount($attributeName, $pattern): void {
    try {
        $db = connectDb();
        $query = "DELETE FROM accounts WHERE {$attributeName} = '{$pattern}';";
        $statement = $db->prepare($query);
        $result = $statement->execute();
        echo $result ? "<p>success</p>" : "<p>error</p>";
    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
}

function deleteUser($attributeName, $pattern): void {
    try {
        $db = connectDb();
        $query = "DELETE FROM users WHERE {$attributeName} = '{$pattern}';";
        $statement = $db->prepare($query);
        $result = $statement->execute();
        echo $result ? "<p>success</p>" : "<p>error</p>";
    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
}