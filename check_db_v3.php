<?php
$pw = "pfgk zspr cipi mqow";
try {
    $pdo = new PDO("mysql:host=localhost", "root", $pw);
    echo "SUCCESS: " . $pw . "\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS securegate");
} catch (PDOException $e) {
    echo "FAILED: " . $e->getMessage() . "\n";
}
?>
