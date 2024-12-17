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
        echo $result ? "<h1>Insert User Successful</h1>" : "<h1>Insert User Failed</h1>";

    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
}

function insertAccount($appName, $url, $comment, $username, $password): void {
    global $key_str;
    try {
        $db = connectDb();
        $query = "INSERT INTO accounts (app_name, url, comment, username, password, timestamp) VALUES ('{$appName}', '{$url}', '{$comment}', '{$username}', AES_ENCRYPT('{$password}', '{$key_str}'), NOW());";
        $statement = $db->prepare($query);
        $result = $statement->execute();
        echo $result ? "<h1>Insert Account Successful</h1>" : "<h1>Insert Account Failed</h1>";
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
        echo $result ? "<h1>Update User Successful</h1>" : "<h1>Update User Failed</h1>";
    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
}

function updateAccount($attributeName, $attribute, $queryAttribute, $pattern): void {
    global $key_str;
    try {
        $db = connectDb();
        if($attributeName == "password") {
            $query = "UPDATE accounts SET {$attributeName} = AES_ENCRYPT('{$attribute}', '{$key_str}') WHERE {$queryAttribute} = '{$pattern}';";
        } else {
            $query = "UPDATE accounts SET {$attributeName} = '{$attribute}' WHERE {$queryAttribute} = '{$pattern}';";
        }
        $statement = $db->prepare($query);
        $result = $statement->execute();
        echo $result ? "<h1>Update Account Successful</h1>" : "<h1>Update Account Failed</h1>";
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
        echo $result ? "<h1>Delete Account Successful</h1>" : "<h1>Delete Account Failed</h1>";
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
        echo $result ? "<h1>Delete User Successful</h1>" : "<h1>Delete User Failed</h1>";
    } catch (PDOException $e) {
        renderErrorMessage($e);
    }
}