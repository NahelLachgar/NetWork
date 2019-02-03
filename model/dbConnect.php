<?php
function dbConnect()
{
    try {
        $db = new PDO('mysql:host=localhost;dbname=u503126698_arar;charset=utf8', 'u503126698_arar', 'motdepasse123');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $db;
}
?>