<?php

function renderErrorMessage($e): void {
    echo "<p>SQL Error</p>";
    echo '<p id=="error">' . $e->getMessage() . '</p>';
    echo '<p>Click <a href="/">here</a> to go back</p>';
}

function renderTable($cols): void {
    echo "<table>";
    echo "  <thead>";
    echo "      <tr>";

    foreach(array_keys($cols[0]) as $key) {
        if(gettype($key) == "string") {
            echo "<th>" . $key . "</th>";
        }
    }

    echo "      </tr>";
    echo "  </thead>";

    echo "  <tbody>";
    foreach($cols as $col) {
        echo "<tr>";
        $keys = array_keys($col);
        foreach($keys as $key) {
            if(gettype($key) == "string") {
                echo "<td>" . $col[$key] . "</td>";
            }
        }
        echo "</tr>";
    }

    echo "  </tbody>";
    echo "</table>";
}