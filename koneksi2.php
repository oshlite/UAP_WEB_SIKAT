<?php
$host   = 'sql210.infinityfree.com';
$db     = 'if0_39298307_database_sikatbukutamu';
$user   = 'if0_39298307';
$pass   = 'ROOTSIKAT123';
$charset= 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  exit('DB Connection Failed: ' . $e->getMessage());
}
