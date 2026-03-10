<?php
$passwords = ["", "root", "root123", "password", "123456"];
foreach ($passwords as $pw) {
    try {
        $pdo = new PDO("mysql:host=localhost", "root", $pw);
        echo "SUCCESS: " . $pw . "\n";
        $pdo->exec("CREATE DATABASE IF NOT EXISTS securegate");
        exit;
    } catch (PDOException $e) {
        // continue
    }
}
echo "FAILED: All common passwords failed.\n";
?>
