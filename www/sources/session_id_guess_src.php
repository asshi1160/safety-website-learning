<?php
foreach (file('../session_id_guess.php') as $row) {
    $row = htmlspecialchars($row) . "<br>";
    echo str_replace(" ", "&nbsp", $row);
}
