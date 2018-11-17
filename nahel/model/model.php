<?php

function dbConnect()
{
    try {
        $db = new PDO('mysql:host=localhost;dbname=bddEval;charset=utf8', 'root', 'root');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $db;
}

function getPosts($userId)
{
    $contactsId = $db->prepare('SELECT user AS id FROM contacts WHERE contact LIKE :id 
            UNION
            SELECT contact AS id FROM contacts WHERE user LIKE :id');
    $contactsId -> execute(array("id" => $userId));
    $contactsFetch = $contactsId->fetch();   

    $selectPosts = $db->query('SELECT p.*,u.lastname AS lastname,u.name AS name FROM users u 
    JOIN post ON u.id = post.user
    JOIN publications p ON post.publication = p.id
    WHERE post.user = ?');
    $selectPosts->execute(array($contactsFetch['id']));
    return $selectPosts;
}
?>