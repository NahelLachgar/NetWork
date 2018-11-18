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
    $db = dbConnect();

    $profile = $db->prepare('SELECT * FROM users WHERE id =?');
    $profile->execute(array($userId));
   // $profileFetch = $profile->fetch();
    return $profile;
}

function getContacts($userId)
{
    $db = dbConnect();

    $contactsId = $db->prepare('SELECT user AS id FROM contacts WHERE contact LIKE :id 
            UNION
            SELECT contact AS id FROM contacts WHERE user LIKE :id');
    $contactsId -> execute(array(
        "id" => $userId
    ));
    $contactsFetch = $contactsId->fetch();
}
function getContactPosts($userId)
{
    $db = dbConnect();

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
    $db = dbConnect();
    $contactsFetch = getContacts($userId);
    $employeeSuggests = $db->prepare('SELECT u.lastName AS lastName, u.name AS name FROM contacts c
        JOIN users u ON u.id = c.user
        WHERE c.contact LIKE :id AND u.status LIKE "employee"
        UNION 
        JOIN users u ON u.id = c.user
        WHERE c.user LIKE :id AND u.status LIKE "employee"');
    $employeeSuggests->execute(array("id"=>$contactsFetch['id']));
    return $employeeSuggests; 
}

function getCompanySuggests($userId) {
    $db = dbConnect();
    $contactsFetch = getContacts($userId);
    $companySuggests = $db->prepare('SELECT u.name AS name FROM contacts c
        JOIN users u ON u.id = c.user
        WHERE c.contact LIKE :id AND u.status LIKE "company"
        UNION 
        JOIN users u ON u.id = c.user
        WHERE c.user LIKE :id AND u.status LIKE "company"');
        $companySuggests->execute(array("id"=>$contactsFetch['id']));
        return  $companySuggests;
}

function getContactsCount($userId) {
    $db = dbConnect();
    $contactsCount = $db->prepare('SELECT COUNT(*) AS nbContacts FROM contacts 
    JOIN users ON contacts.user = users.id 
    WHERE users.status LIKE "employee" AND contact=:id
    UNION 
    SELECT COUNT(*) AS nbContacts 
    FROM contacts 
    JOIN users ON contacts.contact = users.id WHERE users.status LIKE "employee" AND user=:id
');
    $contactsCount->execute(array("id"=>$userId));
    $contactsFetch = $contactsCount->fetch();
    return $contactsFetch;
} 
function getFollowedCompaniesCount($userId) {
    $db = dbConnect();
    $followedCompaniesCount = $db->prepare('SELECT COUNT(*) FROM contacts
     JOIN users ON contacts.user = users.id 
     WHERE users.status LIKE "company" AND user=:id OR contact=:id
    ');
    $followedCompaniesCount->execute(array("id"=>$userId));
    $followedCompaniesFetch = $followedCompaniesCount ->fetch();
    return $followedCompaniesFetch;
} 
?>