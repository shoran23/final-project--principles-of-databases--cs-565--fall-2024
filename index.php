<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Final Project | CS 565 | Passwords Assignment</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <header>
      <h1>CRUD Operations via a Web Interface</h1>
    </header>
    <form id="clear-results" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    </form>
<?php

require_once "includes/php/config.php";
require_once "includes/php/constants.php";
require_once "includes/php/db.php";

$option = ($_POST["submitted"] ?? null);

if($option != null) {
    switch($option) {
        case SEARCH:
            if($_POST["search"] == "") {
                echo '<div id="error">Search query empty. Please try again.</div>';
            } else {
                search($_POST["search"]);
            }
            break;
        case UPDATE:
            $attributeName = $_POST["current-attribute-name"];
            $attribute = $_POST["new-attribute"];
            $queryAttribute = $_POST["query-attribute"];
            $pattern = $_POST["pattern"];

            if($attribute == "" || $pattern == "") {
                echo '<div id="error">Update query empty. Please try again.</div>';
            } else {
                update($attributeName, $attribute, $queryAttribute, $pattern);
            }
            break;
        case INSERT_USER:
            $firstName = $_POST["first_name"];
            $lastName = $_POST["last_name"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            if($firstName == "" || $lastName == "" || $username == "" || $email == "") {
                echo '<div id="error">User form not fully entered. Please try again.</div>';
            } else {
                insertUser($firstName, $lastName, $username, $email);
            }
            break;
        case INSERT_ACCOUNT:
            echo "Insert Account";
            break;
        case DELETE:
            echo "Delete";
            break;
    }
}


require_once "includes/html/search-form.html";
require_once "includes/html/update-form.html";
require_once "includes/html/insert-user-form.html";
require_once "includes/php/insert-account-form.php";
require_once "includes/html/delete-form.html";
?>
  </body>
</html>
