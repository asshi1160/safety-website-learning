<?php
foreach (file('../sqli.php') as $row) {
    $row = htmlspecialchars($row) . "<br>";
    echo str_replace(" ", "&nbsp", $row);
}
