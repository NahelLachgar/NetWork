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
//RÉCUPÉRATION DES INFOS SUR L'UTILISATEUR 
function getProfile($userId)
{
    $db = dbConnect();

    $profile = $db->prepare('SELECT * FROM users WHERE id =?');
    $profile->execute(array($userId));
    $profileFetch = $profile->fetch();
    return $profileFetch;
}

//RÉCUPÉRATION DES CONTACTS DE L'UTILISATEUR
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

//RÉCUPÉRATION DES PUBLICATIONS DES CONTACTS ET ENTREPRISES SUIVIES PAR L'UTILISATEUR (FIL D'ACUTALITÉ)
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

//SUGGESTIONS D'EMPLOYÉS POUR L'UTILISATEUR 
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

//SUGGESTIONS D'ENTREPRISES
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

//NOMBRE DE CONTACTS
function getContactsCount($userId) {
    $db = dbConnect();
    $contactsCount1 = $db->prepare('SELECT COUNT(*) AS contactsNb FROM contacts 
    JOIN users ON contacts.user = users.id 
    WHERE users.status LIKE "employee" AND contact=:id');
    $contactsCount1->execute(array("id"=>$userId));
    $contactsFetch1 = $contactsCount1->fetch();

    $contactsCount2 = $db->prepare('SELECT COUNT(*) AS contactsNb
    FROM contacts 
    JOIN users ON contacts.contact = users.id WHERE users.status LIKE "employee" AND user=:id');
    $contactsCount2->execute(array("id"=>$userId));
    $contactsFetch2 = $contactsCount2->fetch();

    $contactsCount = $contactsFetch1['contactsNb'] + $contactsFetch2['contactsNb'];
    return $contactsCount;
} 

//NOMBRE D'ENTREPRISES SUIVIES
function getFollowedCompaniesCount($userId) {
    $db = dbConnect();
    $followedCompaniesCount1 = $db->prepare('SELECT COUNT(*) AS companiesNb FROM contacts 
    JOIN users ON contacts.user = users.id 
    WHERE users.status LIKE "company" AND contact=:id');
    $followedCompaniesCount1->execute(array("id"=>$userId));
    $followedCompaniesFetch1 = $followedCompaniesCount1->fetch();

    $followedCompaniesCount2 = $db->prepare('SELECT COUNT(*) AS companiesNb
    FROM contacts 
    JOIN users ON contacts.contact = users.id WHERE users.status LIKE "company" AND user=:id');
    $followedCompaniesCount2->execute(array("id"=>$userId));
    $followedCompaniesFetch2 = $followedCompaniesCount2->fetch();

    $followedCompaniesCount = $followedCompaniesFetch1['companiesNb'] + $followedCompaniesFetch2['companiesNb'];
    return $followedCompaniesCount;
} 

//COMMENTER UNE PUBLICATION
function comment($content,$userId,$postId) {
    $db = dbConnect();
    $insertCom = $db->prepare('INSERT INTO coms (content,comDate,user) VALUES (:content,NOW(),:user)');
    $insertCom->execute(array(
        "content"=>$content,
        "user"=>$userId
    ));
}



// DETECTION SI L'UTILISATEUR EXSITE
function checkUser($mail) {

	// ON SE CONNECTE
	$db = dbConnect();

	// ON SELECT LE MOT DE PASSE CORESPONDANT AU MAIL
	$selectUser = $db->prepare('SELECT password FROM users WHERE email = ?');
	$selectUser->execute(array($mail));
	$fetchSelectUser = $selectUser->fetch();
	$UserPassword = $fetchSelectUser['password'];

	// ON RETURN LE MOT DE PASSE
	return $UserPassword;
}

// AJOUTER L'UTILISATEUR DANS LA BDD
function addUser($lastName, $firstName, $email, $phone, $photo, $password, $status, $job, $company, $town) {

	// ON SE CONNECTE
	$db = dbConnect();

	// ON INSERT LES DONNES DANS LA BDD
	$insertUser = $db->prepare('INSERT INTO users (name, lastName, email, phone, photo, password, status, job, company, town) VALUES (?,?,?,?,?,?,?,?,?,?)');
	$insertUser->execute(array( $firstName,$lastName,$email, $phone, $photo, $password, $status, $job, $company, $town));

}


?>