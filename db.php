<?php
$host = "b-studentsql-1.usn.no";
$dbname = "ahabd6031";
$username = "ahabd6031";
$password = getenv('DB_PASSWORD');

try {
    $mysqli = new mysqli($host, $username, $password, $dbname);
    $mysqli->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Kunne ikke koble til databasen.");
}
?>
