<!DOCTYPE html>
<html>
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
        case NOTHING_FOUND:
            echo "Nothing Found";
            break;
        case SEARCH:
            echo "Search";
            break;
        case UPDATE:
            echo "Update";
            break;
        case INSERT:
            echo "Insert";
            break;
        case DELETE:
            echo "Delete";
            break;
    }
}


require_once "includes/html/search-form.html";
require_once "includes/html/update-form.html";
require_once "includes/html/insert-form.html";
require_once "includes/html/delete-form.html";
?>
  </body>
</html>
