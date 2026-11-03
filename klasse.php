
<?php
require_once 'db.php';

$melding = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['registrer'])) {
        $kode = $_POST['klassekode'];
        $navn = $_POST['klassenavn'];
        $studium = $_POST['studiumkode'];

        try {
           $stmt = $mysqli->prepare(
                "INSERT INTO klasse
                (klassekode, klassenavn, studiumkode)
                VALUES (?, ?, ?)"
            );

            $stmt->bind_param("sss", $kode, $navn, $studium);
            $stmt->execute();

            $melding = "Klassen ble registrert.";

        } catch (mysqli_sql_exception $e) {
            $melding = "Kunne ikke registrere klassen. Kontroller at klassekoden er unik.";
        }
    }

    if (isset($_POST['slett'])) {
        $kode = $_POST['slett'];

        try {
            $stmt = $mysqli->prepare(
    "DELETE FROM klasse WHERE klassekode = ?"
);
            );

            $stmt->bind_param("s", $kode);
            $stmt->execute();

            $melding = "Klassen ble slettet.";

        } catch (mysqli_sql_exception $e) {
            $melding = "Klassen kunne ikke slettes. Den kan ha studenter tilknyttet seg.";
        }
    }
}

$resultat = $mysqli->query(
    "SELECT * FROM klasse ORDER BY klassekode"
);

$klasser = $resultat->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Administrer klasser</title>
</head>
<body>

<h1>Administrer klasser</h1>

<p><a href="index.php">Til forsiden</a></p>

<p><?= htmlspecialchars($melding) ?></p>

<h2>Registrer ny klasse</h2>

<form method="post">
    <label>Klassekode:</label>
    <input type="text" name="klassekode" maxlength="5" required>

    <br><br>

    <label>Klassenavn:</label>
    <input type="text" name="klassenavn" maxlength="50" required>

    <br><br>

    <label>Studiumkode:</label>
    <input type="text" name="studiumkode" maxlength="50" required>

    <br><br>

    <button type="submit" name="registrer">Registrer klasse</button>
</form>
<h2>Slett klasse</h2>

<form method="post">
    <label>Velg klasse:</label>

    <select name="slett" required>
        <option value="">Velg klasse</option>

        <?php foreach ($klasser as $klasse): ?>
            <option value="<?= htmlspecialchars($klasse['klassekode']) ?>">
                <?= htmlspecialchars($klasse['klassekode']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit"
            onclick="return confirm('Er du sikker?')">
        Slett klasse
    </button>
</form>
<h2>Alle klasser</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Klassekode</th>
        <th>Klassenavn</th>
        <th>Studiumkode</th>
        <th>Handling</th>
    </tr>

    <?php foreach ($klasser as $klasse): ?>
    <tr>
        <td><?= htmlspecialchars($klasse['klassekode']) ?></td>
        <td><?= htmlspecialchars($klasse['klassenavn']) ?></td>
        <td><?= htmlspecialchars($klasse['studiumkode']) ?></td>
        <td>
            <form method="post">
                <button
                    type="submit"
                    name="slett"
                    value="<?= htmlspecialchars($klasse['klassekode']) ?>"
                    onclick="return confirm('Er du sikker på at du vil slette klassen?')"
                >
                    Slett
                </button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
