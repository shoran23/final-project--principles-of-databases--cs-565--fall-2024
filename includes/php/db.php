<?php
include_once "components.php";

$key_str = base64_encode("my secret key");

function connectDb(): PDO
{
    include_once "config.php";
    return new PDO(
        "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8",
        DBUSER,
        DBPASS
    );
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
    global $key_str;
    echo $key_str;
    try {
        $db = connectDb();
        $query = "INSERT INTO accounts (app_name, url, comment, username, password, timestamp) VALUES ('{$appName}', '{$url}', '{$comment}', '{$username}', AES_ENCRYPT('{$password}', '{$key_str}'), NOW());";
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
    global $key_str;
    try {
        $db = connectDb();
        $statement = $db->prepare(
            "SELECT " .
                "app_name AS 'App Name', " .
                "url AS 'URL', " .
                "comment AS 'Comment', " .
                "username AS 'Username', " .
                "CAST(AES_DECRYPT(password, '{$key_str}') AS CHAR) AS 'Plain Text Password', " .
                "timestamp AS 'Timestamp'" .
            "FROM accounts WHERE " .
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
    global $key_str;
    try {
        $db = connectDb();
        $statement = $db->prepare(
            "SELECT " .
                "first_name AS 'First Name', " .
                "last_name AS 'Last Name', " .
                "accounts.username AS 'Username', " .
                "email AS 'Email', " .
                "app_name AS 'App Name', " .
                "url AS 'URL', " .
                "comment AS 'Comment', " .
                "CAST(AES_DECRYPT(password, '{$key_str}') AS CHAR) AS 'Plain Text Password' " .

            "FROM users NATURAL JOIN accounts WHERE " .
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
    // todo if the password is being updated be sure the encrypt it
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

function getUsername($db, $attributeName, $pattern): string {
    try {
        $query = "SELECT username FROM users WHERE {$attributeName} = '{$pattern}';";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result[0]["username"];
    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
    return "";
}

function deleteUser($attributeName, $pattern): void {
    // todo when deleting a user first check if any accounts are tied to the user
    // todo if any of the accounts are tied to the user then set their usernames to null
    try {
        $db = connectDb();
        $username = getUsername($db, $attributeName, $pattern);
        if(strlen($username) > 0) {
            // todo proceed to wipe the accounts with the username
            $statement = $db->prepare("UPDATE accounts SET username = NULL WHERE username = '{$username}';");
            $statement->execute();
        }
        $query = "DELETE FROM users WHERE {$attributeName} = '{$pattern}';";
        $statement = $db->prepare($query);
        $result = $statement->execute();
        echo $result ? "<p>success</p>" : "<p>error</p>";
    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
}