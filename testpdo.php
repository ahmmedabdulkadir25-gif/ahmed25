<?php
echo "PHP-versjon: " . PHP_VERSION . "<br>";
echo "PDO: " . (class_exists('PDO') ? 'JA' : 'NEI') . "<br>";
echo "PDO MySQL: " . (extension_loaded('pdo_mysql') ? 'JA' : 'NEI');
?>
