<?php
foreach (file('../os_command.php') as $row) {
    $row = htmlspecialchars($row) . "<br>";
    echo str_replace(" ", "&nbsp", $row);
}
