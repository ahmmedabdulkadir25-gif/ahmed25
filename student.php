

<?php
require_once 'db.php';

$melding = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['slett'])) {
    $brukernavn = $_POST['slett_brukernavn'] ?? '';

try {
    $stmt = $mysqli->prepare(
        "DELETE FROM student WHERE brukernavn = ?"
    );

    $stmt->bind_param("s", $brukernavn);
    $stmt->execute();

    $melding = "Studenten ble slettet.";

} catch (mysqli_sql_exception $e) {
    $melding = "Kunne ikke slette studenten.";
}
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['registrer'])) {

    $brukernavn = trim($_POST['brukernavn'] ?? '');
    $fornavn = trim($_POST['fornavn'] ?? '');
    $etternavn = trim($_POST['etternavn'] ?? '');
    $klassekode = trim($_POST['klassekode'] ?? '');

    if ($brukernavn === '' || $fornavn === '' ||
        $etternavn === '' || $klassekode === '') {
        $melding = 'Alle feltene må fylles ut.';
    } else {
        try {
            $sql = "INSERT INTO student
                    (brukernavn, fornavn, etternavn, klassekode)
                    VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);

$stmt->bind_param(
    "ssss",
    $brukernavn,
    $fornavn,
    $etternavn,
    $klassekode
);

$stmt->execute();

            $melding = 'Studenten ble registrert.';
    
} catch (PDOException $e) {
$melding = "Kunne ikke registrere studenten. Brukernavnet finnes kanskje allerede.";
}

    }
}

$stmt = $pdo->query("SELECT * FROM student ORDER BY brukernavn");
$studenter = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT klassekode FROM klasse ORDER BY klassekode");
$klasser = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Administrer studenter</title>
</head>
<body>

<h1>Administrer studenter</h1>

<p><a href="index.php">Til forsiden</a></p>

<p><?= htmlspecialchars($melding) ?></p> 
<h2>Registrer ny student</h2>
<form method="post">

    <label>Brukernavn:</label>
    <input type="text" name="brukernavn" required>
    <br><br>

    <label>Fornavn:</label>
    <input type="text" name="fornavn" required>
    <br><br>

    <label>Etternavn:</label>
    <input type="text" name="etternavn" required>
    <br><br>

    <label>Klassekode:</label>
  
<select name="klassekode" required>
    <option value="">Velg klasse</option>
    <?php foreach ($klasser as $klasse): ?>
        <option value="<?= htmlspecialchars($klasse['klassekode']) ?>">
            <?= htmlspecialchars($klasse['klassekode']) ?>
        </option>
    <?php endforeach; ?>
</select>

    <br><br>

    <button type="submit" name="registrer">
        Registrer student
    </button>

</form>


<h2>Slett student</h2>

<form method="post">
    <label>Velg student:</label>

    <select name="slett_brukernavn" required>
        <option value="">Velg student</option>

        <?php foreach ($studenter as $student): ?>
            <option value="<?= htmlspecialchars($student['brukernavn']) ?>">
                <?= htmlspecialchars($student['brukernavn']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" name="slett"
        onclick="return confirm('Er du sikker?')">
        Slett student
    </button>
</form>
<h2>Alle studenter</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Brukernavn</th>
        <th>Fornavn</th>
        <th>Etternavn</th>
        <th>Klassekode</th>
        <th>Handling</th>
    </tr>

    <?php foreach ($studenter as $student): ?>
    <tr>
        <td><?= htmlspecialchars($student['brukernavn']) ?></td>
        <td><?= htmlspecialchars($student['fornavn']) ?></td>
        <td><?= htmlspecialchars($student['etternavn']) ?></td>
        <td><?= htmlspecialchars($student['klassekode']) ?></td>
        
<td>
    <form method="post">
        <input type="hidden" name="slett_brukernavn"
               value="<?= htmlspecialchars($student['brukernavn']) ?>">
       <button type="submit" name="slett"
        onclick="return confirm('Er du sikker?')">
    Slett
</button>
    </form>
</td>

    </tr>
    <?php endforeach; ?>

</table>


</body>
</html>
