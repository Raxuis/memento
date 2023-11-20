<?php try {
    $bdd = new PDO(
        'mysql:host=localhost;dbname=codastudent2023;charset=utf8',
        'root',
        'root'
    );
    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}