<?php
echo "PDO: " . (class_exists('PDO') ? 'JA' : 'NEI');
echo "<br>";
echo "PDO MySQL: " . (extension_loaded('pdo_mysql') ? 'JA' : 'NEI');
?>
