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
    $contactsId = $db->prepare('SELECT user AS id FROM contacts WHERE contact = :id 
            UNION
            SELECT contact AS id FROM contacts WHERE user = :id');
    $contactsId->execute(array(
        "id" => $userId
    ));
    return $contactsId;
}

function getContactPosts($contactId) {
    $db = dbConnect();
    $posts = $db->prepare('SELECT p.*,u.lastName AS lastName,u.name AS name, u.job AS job, u.company AS company, u.id AS contactId FROM users u 
        JOIN post ON u.id = post.user
        JOIN publications p ON post.publication = p.id
        WHERE post.user = ? 
        ORDER BY p.postDate DESC');
    $posts->execute(array($contactId));   
    return $posts;
}

function getMessages($userId) {
    $db = dbConnect();
    $messages = $db->prepare('SELECT * FROM sendPrivate JOIN privateMessages 
    ON 
    WHERE reicever');
}
//RÉCUPÉRATION DES PUBLICATIONS DES CONTACTS ET ENTREPRISES SUIVIES PAR L'UTILISATEUR (FIL D'ACUTALITÉ)
function getContactsPosts($userId)
{
    $db = dbConnect();
    $contacts = getContacts($userId);
    $contactsFetch = $contacts->fetchAll(PDO::FETCH_ASSOC);
    $posts = $db->prepare('SELECT p.*,u.lastName AS lastName,u.name AS name, u.job AS job, u.company AS company, u.id AS contactId FROM users u 
        JOIN post ON u.id = post.user
        JOIN publications p ON post.publication = p.id
        WHERE post.user = ? OR post.user = ?  
        ORDER BY p.postDate DESC');
    for ($i = 0; $i < count($contactsFetch); $i++) {
        $posts->execute(array($contactsFetch[$i]['id'], $userId));
        $postsFetch = $posts->fetchAll(PDO::FETCH_ASSOC);
        $contactsPosts[$i] = $postsFetch;
    }
    if (count($contactsPosts) > 1) {
        for ($i = 1; $i < (count($contactsPosts) - 1); $i++) {
            $contactsPosts[0] = array_merge($contactsPosts[$i], $contactsPosts[0]);
        }
        $contactsPosts = array_merge($contactsPosts[$i], $contactsPosts[0]);
    function deleteDouble($array)
    {
        $i = 0;
        while ($i < count($array) - 1) {
            $j = $i + 1;
            while ($j < count($array)) {
                if (!isset($array[$i])) {
                    $i++;
                }
                if (!isset($array[$j])) {
                    $j++;
                } else if (isset($array[$j])) {
                    if ($array[$i]['id'] == $array[$j]['id']) {
                        unset($array[$j]);
                        $j++;
                    } else if ($array[$i]['id'] != $array[$j]['id']) {
                        $j++;
                    }
                }
            }
            $i++;
        }
        $array = array_values($array);
        return $array;
    }
    $contactsPosts = deleteDouble($contactsPosts);
    function arraySortId($array)
    {
        $i = 0;
            while ($i < count($array)-1) {
                if ($array[$i]['postDate'] <= $array[$i + 1]['postDate']) {
                    $tmp = $array[$i]['postDate'];
                    $array[$i+1]['postDate'] = $array[$i]['postDate'];
                    $array[$i + 1]['postDate'] = $tmp;
                    $i++;
                } 
                    $i++;
            }
            return $array;
    }      
   // echo(count($contactsPosts));
    $contactsPosts = arraySortId($contactsPosts);
}
    return $contactsPosts;
}
//SUGGESTIONS D'EMPLOYÉS POUR L'UTILISATEUR 
function getEmployeeSuggests($userId) {
    $db = dbConnect();
    $contacts = getContacts($userId);
    $contactsFetch = $contacts->fetchAll(PDO::FETCH_ASSOC);
    $employeeSuggests = $db->prepare('SELECT DISTINCT u.* 
    FROM users u JOIN contacts c ON u.id = c.user WHERE c.contact = :id AND c.user NOT LIKE :userId AND u.status LIKE "employee"
    UNION
    SELECT DISTINCT u.* 
    FROM users u JOIN contacts c  ON u.id = c.contact WHERE c.user = :id AND c.contact NOT LIKE :userId AND u.status LIKE "employee"');
        for ($i = 0; $i < count($contactsFetch)-1; $i++) {
               $employeeSuggests->execute(array(
                   "id"=>$contactsFetch[$i]['id'],
                   "userId"=>$userId
                ));
               $employeeSuggestsFetch = $employeeSuggests->fetchAll(PDO::FETCH_ASSOC);
               $employees[$i] = $employeeSuggestsFetch;
        }
        if (count($employees) > 0) {
            for ($i = 0; $i < (count($employees) - 1); $i++) {
                $employees[0] = array_merge($employees[$i], $employees[0]);
    
            }
            $employees = array_merge($employees[$i], $employees[0]);
        } 
    return $employees; 
}
//SUGGESTIONS D'ENTREPRISE POUR L'UTILISATEUR 
function getCompanySuggests($userId) {
    $db = dbConnect();
    $contacts = getContacts($userId);
    $contactsFetch = $contacts->fetchAll(PDO::FETCH_ASSOC);
    $companySuggests = $db->prepare('SELECT DISTINCT u.* 
    FROM users u JOIN contacts c ON u.id = c.user WHERE c.contact = :id AND c.user NOT LIKE :userId AND u.status LIKE "company"
    UNION
    SELECT DISTINCT u.* 
    FROM users u JOIN contacts c  ON u.id = c.contact WHERE c.user = :id AND c.contact NOT LIKE :userId AND u.status LIKE "company"');
        for ($i = 0; $i < count($contactsFetch)-1; $i++) {
               $companySuggests->execute(array(
                   "id"=>$contactsFetch[$i]['id'],
                   "userId"=>$userId
                ));
               $companySuggestsFetch = $companySuggests->fetchAll(PDO::FETCH_ASSOC);
               $companies[$i] = $companySuggestsFetch;
        }
        if (count($companies) > 0) {
            for ($i = 0; $i < (count($companies) - 1); $i++) {
                $companies[0] = array_merge($companies[$i], $companies[0]);
    
            }
            $companies = array_merge($companies[$i], $companies[0]);
        } 
    return $companies; 
}
//NOMBRE DE CONTACTS
function getContactsCount($userId)
{
    $db = dbConnect();
    $contactsCount1 = $db->prepare('SELECT COUNT(*) AS contactsNb FROM contacts 
    JOIN users ON contacts.user = users.id 
    WHERE status LIKE "employee" AND contact=:id');
    $contactsCount1->execute(array("id" => $userId));
    $contactsFetch1 = $contactsCount1->fetch();
    $contactsCount2 = $db->prepare('SELECT COUNT(*) AS contactsNb
    FROM contacts 
    JOIN users ON contacts.contact = users.id WHERE status LIKE "employee" AND user=:id');
    $contactsCount2->execute(array("id" => $userId));
    $contactsFetch2 = $contactsCount2->fetch();
    $contactsCount = $contactsFetch1['contactsNb'] + $contactsFetch2['contactsNb'];
    return $contactsCount;
} 
//NOMBRE D'ENTREPRISES SUIVIES
function getFollowedCompaniesCount($userId)
{
    $db = dbConnect();
    $followedCompaniesCount1 = $db->prepare('SELECT COUNT(*) AS companiesNb FROM contacts 
    JOIN users ON contacts.user = users.id 
    WHERE status LIKE "company" AND contact=:id');
    $followedCompaniesCount1->execute(array("id" => $userId));
    $followedCompaniesFetch1 = $followedCompaniesCount1->fetch();
    $followedCompaniesCount2 = $db->prepare('SELECT COUNT(*) AS companiesNb
    FROM contacts 
    JOIN users ON contacts.contact = users.id WHERE status LIKE "company" AND user=:id');
    $followedCompaniesCount2->execute(array("id" => $userId));
    $followedCompaniesFetch2 = $followedCompaniesCount2->fetch();
    $followedCompaniesCount = $followedCompaniesFetch1['companiesNb'] + $followedCompaniesFetch2['companiesNb'];
    return $followedCompaniesCount;
} 
// PUBLIER DU CONTENU
function post($content, $type, $userId)
{
    $db = dbConnect();
    $insertPub = $db->prepare('INSERT INTO publications (content,postDate,type) VALUES (?,NOW(),?)');
    $insertPub->execute(array($content, $type));
    $insertPost = $db->prepare('INSERT INTO post (publication,user) VALUES (LAST_INSERT_ID(),?) ');
    $insertPost->execute(array($userId));
}
//COMMENTER UNE PUBLICATION
function comment($content, $userId, $postId)
{
    $db = dbConnect();
    $insertCom = $db->prepare('INSERT INTO coms (content,comDate,user) VALUES (:content,NOW(),:user)');
    $insertCom->execute(array(
        "content" => $content,
        "user" => $userId
    ));
    $insertComment = $db->prepare('INSERT INTO comment (com,publication) VALUES (LAST_INSERT_ID(),?)');
    $insertComment->execute(array($postId));
}
// DETECTION SI L'UTILISATEUR EXSITE
function checkUser($email)
{
	// ON SE CONNECTE
    $db = dbConnect();
	// ON SELECT LE MOT DE PASSE CORESPONDANT AU MAIL
    $selectUser = $db->prepare('SELECT * FROM users WHERE email = ?');
    $selectUser->execute(array($email));
    $fetchSelectUser = $selectUser->fetch();
	
	// ON RETURN LE MOT DE PASSE
    return $fetchSelectUser;
}
// AJOUTER L'UTILISATEUR DANS LA BDD
function addUser($lastName, $firstName, $email, $phone, $photo, $password, $status, $job, $company, $town)
{
	// ON SE CONNECTE
    $db = dbConnect();
	// ON INSERT LES DONNES DANS LA BDD
    $insertUser = $db->prepare('INSERT INTO users (name, lastName, email, phone, photo, password, status, job, company, town) VALUES (?,?,?,?,?,?,?,?,?,?)');
    $insertUser->execute(array($firstName, $lastName, $email, $phone, $photo, $password, $status, $job, $company, $town));
}
    // MODIFICATION DES CHAMPS DU PROFIL EXCEPTE LE CHAMP photo
function updateProfiles($lastName, $name, $email, $pass, $phone, $job, $company, $town, $id)
{
    $db = dbConnect();
    $req = $db->prepare('UPDATE users SET users.lastName = ?, users.name = ?, users.email = ?,users.password = ?, users.phone = ?,users.job = ?,users.company = ?,users.town = ?  WHERE users.id = ?');
    $password = password_hash($pass, PASSWORD_BCRYPT);
    $req->execute(array($lastName, $name, $email, $password, $phone, $job, $company, $town, $id));
    return $req;
}
    
    //RECHERCHE D'UN USER OU UNE COMPANY AVEC SON NOM OU SON PRENOM
function getSearch($userId, $name)
{
    $db = dbConnect();
    $res = "%" . $name . "%";
    $req = $db->prepare('SELECT users.id as contactId,users.lastName,users.name,users.email,users.phone,users.job,users.company,users.town,status FROM users WHERE users.id != ? AND (users.lastName LIKE ?  OR users.name LIKE ?) ');
    $req->execute(array($userId, $res, $res));
    $req = $req->fetchAll();
    return $req;
}
    //AJOUT D'UN CONTACT
function addContact($contactId, $idUser)
{
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO contacts(contact,user) VALUES(?,?)');
    $req->execute(array($contactId, $idUser));
    return $req;
}

    //UNFOLLOW UN CONTACT
    function unfollow($contactId, $idUser)
    {
        $db = dbConnect();
        $req = $db->prepare('DELETE FROM contacts WHERE contacts.contact = ? AND contacts.user = ?');
        $req->execute(array($contactId, $idUser));
        return $req;
    }

function getContactToUser($idUser)
{
    $db = dbConnect();
    $req  = $db->prepare('SELECT user AS id FROM contacts WHERE contact LIKE ? 
    UNION
    SELECT contact AS id FROM contacts WHERE user LIKE ?');
    $req->execute(array($idUser,$idUser));
    $post = $req->fetchAll();
    if($post){
    foreach($post as $res){
        $array[] = $res['id'];
    }
    return $array;
    }
}

    //RECUPERATION DES INFOS DU PROFIL
function getProfileUpdate($ids)
{
    $db = dbConnect();
    $req = $db->prepare('SELECT users.lastName,users.name,users.email,users.phone,users.job,users.company,users.town FROM users WHERE users.id = ?');
    $post = $req->execute(array($ids));
    $post = $req->fetch();
    return $post;
}
?>