<?php
$dsn = 'mysql:host=localhost;dbname=techno;charset=utf8';
$user = 'root';
$password = '';

try {
    $db = new PDO($dsn, $user, $password, array(PDO::ATTR_PERSISTENT => true));
} catch (PDOException $e) {
    echo 'Connexion impossible à la base de données :' . $e->getMessage();
}
