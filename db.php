<?php
$host = "b-studentsql-1.usn.no";
$dbname = "ahabd6031";
$username = "ahabd6031";
$password = getenv('DB_PASSWORD');
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {
    die("Kunne ikke koble til databasen.");
}
?>