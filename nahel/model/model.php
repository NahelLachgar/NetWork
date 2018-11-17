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
function getProfile($userId)
{
    $profile = $db->prepare('SELECT * FROM users WHERE id =');
    $profile->execute(array($userId));
    return $profile;
}

function getContacts($userId)
{
    $contactsId = $db->prepare('SELECT user AS id FROM contacts WHERE contact LIKE :id 
            UNION
            SELECT contact AS id FROM contacts WHERE user LIKE :id');
    $contactsId > execute(array(
        "id" => $userId
    ));
    $contactsFetch = $contactsId->fetch();
}
function getContactPosts($userId)
{
    $contactsFetch = getContacts($userId);
    $posts = $db->prepare('SELECT p.*,u.lastname AS lastname,u.name AS name FROM users u 
    JOIN post ON u.id = post.user
    JOIN publications p ON post.publication = p.id
    WHERE post.user = ?');
    $posts->execute(array($contactsFetch['id']));
    return $posts;
}

function getEmployeeSuggests($userId)
{
    $contactsFetch = getContacts($userId);
    $employeeSuggests = $db->prepare('SELECT u.lastName AS lastName, u.name AS name FROM contacts c
        JOIN users u ON u.id = c.user
        WHERE c.contact LIKE :id AND u.status LIKE "employee"
        UNION 
        JOIN users u ON u.id = c.user
        WHERE c.user LIKE :id AND u.status LIKE "employee"');

    $employeeSuggests->execute(array("id"=>$contactsFetch['id']));
}

function getCompanySuggests($userId) {
    $contactsFetch = getContacts($userId);
    $companySuggests = $db->prepare('SELECT u.name AS name FROM contacts c
        JOIN users u ON u.id = c.user
        WHERE c.contact LIKE :id AND u.status LIKE "company"
        UNION 
        JOIN users u ON u.id = c.user
        WHERE c.user LIKE :id AND u.status LIKE "company"');

$companySuggests->execute(array("id"=>$contactsFetch['id']));
}

function getContactsCount($userId) {
    $contactCounts = $db->prepare('SELECT COUNT(*) FROM contacts
     JOIN users ON contacts.user = users.id 
     WHERE users.status LIKE employee AND user=:id OR contact=:id
    ');
    $contactCount->execute(array($userId));
    return $contactsCount;
} 
function getFollowedCompaniesCount($userId) {
    $FollowedCompaniesCount = $db->prepare('SELECT COUNT(*) FROM contacts
     JOIN users ON contacts.user = users.id 
     WHERE users.status LIKE company AND user=:id OR contact=:id
    ');
    $FollowedCompaniesCount->execute(array($userId));
    return $FollowedCompaniesCount;
} 
?>