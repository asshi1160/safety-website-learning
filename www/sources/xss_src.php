<?php
foreach (file('../xss.php') as $row) {
    $row = htmlspecialchars($row) . "<br>";
    echo str_replace(" ", "&nbsp", $row);
}
