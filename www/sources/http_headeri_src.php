<?php
foreach (file('../http_headeri.php') as $row) {
    $row = htmlspecialchars($row) . "<br>";
    echo str_replace(" ", "&nbsp", $row);
}
