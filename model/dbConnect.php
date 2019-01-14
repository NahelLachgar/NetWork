<?php
function dbConnect()
{
    try {
        $db = new PDO('mysql:host=localhost;dbname=NetWork;charset=utf8', 'root', 'root');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $db;
}
?>