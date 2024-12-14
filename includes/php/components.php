<?php

function createTableHeader($titles) {
    echo "<thead>\n";
    echo "    <tr>\n";
    foreach($titles as $title) {
        echo "<th>$title</th>\n";
    }
    echo "    </tr>\n";
    echo "</thead>\n";
}

function renderErrorMessage($e): void {
    echo "<p>SQL Error</p>";
    echo '<p id=="error">' . $e->getMessage() . '</p>';
    echo '<p>Click <a href="/">here</a> to go back</p>';
}