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