<?php
include_once('model/dbConnect.php');
include_once('model/insertModel.php');
include_once('model/deleteModel.php');
include_once('model/updateModel.php');
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

// COMPTE LES ID DANS LA TABLE PUBLICATIONS
function countPublications() {
    $db = dbConnect();
    $publications = $db->prepare('SELECT COUNT(*)+1 FROM publications');
    $publications->execute();
    $publication = $publications->fetch();
    return $publication;
}

function getContactPosts($contactId) {
    $db = dbConnect();
    $posts = $db->prepare('SELECT p.*,u.lastName AS lastName,u.name AS name, u.job AS job, u.company AS company, u.id AS contactId,u.photo AS photo FROM users u 
        JOIN post ON u.id = post.user
        JOIN publications p ON post.publication = p.id
        WHERE post.user = ? 
        ORDER BY p.postDate DESC');
    $posts->execute(array($contactId));   
    return $posts;
}
//RÉCUPÉRATION DES MESSAGES QU'A REÇUS OU ENVOYÉS L'UTILISATEUR
function getMessages($userId,$contactId) {
    $db = dbConnect();
    $messages = $db->prepare('SELECT * FROM privateMessages
    WHERE receiver = :userId AND sender = :contactId OR receiver = :contactId AND sender = :userId
    ORDER BY sendDate ASC');
    $messages->execute(array(
        "userId"=>$userId,
        "contactId"=>$contactId
    ));
    return $messages;
}

function getGroupMessages ($groupId) {
    $db = dbConnect();
    $messages = $db->prepare('SELECT * FROM groupAdd
    WHERE  group = :groupId AND status = "message"
    ORDER BY sendDate ASC');
    $messages->execute(array(
        "groupId"=>$groupId
    ));
    return $messages; 
}
//RÉCUPÉRATION DES PUBLICATIONS DES CONTACTS ET ENTREPRISES SUIVIES PAR L'UTILISATEUR (FIL D'ACUTALITÉ)
function getContactsPosts($userId)
{
    $db = dbConnect();
    $contacts = getContacts($userId);
    $contactsFetch = $contacts->fetchAll(PDO::FETCH_ASSOC);
    $posts = $db->prepare('SELECT p.*,u.lastName AS lastName,u.name AS name, u.job AS job, u.company AS company, u.id AS contactId,u.photo AS photo FROM users u 
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
    if ($contactsFetch>1) {
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
        if (isset($employees)) {
        if (count($employees) > 0) {
            for ($i = 0; $i < (count($employees) - 1); $i++) {
                $employees[0] = array_merge($employees[$i], $employees[0]);
    
            }
            $employees = array_merge($employees[$i], $employees[0]);
        } 
    return $employees; 
    }
}
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
        if (isset($companies)) {
        if (count($companies) > 0) {
            for ($i = 0; $i < (count($companies) - 1); $i++) {
                $companies[0] = array_merge($companies[$i], $companies[0]);
    
            }
            $companies = array_merge($companies[$i], $companies[0]);
        } 
    
    return $companies; 
    }
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
 //RECHERCHE D'UN UTILISATEUR OU UNE ENTREPRISE AVEC SON NOM OU SON PRENOM
 function getSearch($userId, $name)
 {
     $db = dbConnect();
     $res = "%" . $name . "%";
     $req = $db->prepare('SELECT users.id as contactId,users.lastName,users.name,users.email,users.phone,users.job,users.company,users.town,status,photo FROM users WHERE users.id != ? AND (users.lastName LIKE ?  OR users.name LIKE ?) ');
     $req->execute(array($userId, $res, $res));
     $req = $req->fetchAll();
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
    $req = $db->prepare('SELECT * FROM users WHERE id = ?');
    $post = $req->execute(array($ids));
    $post = $req->fetch();
    return $post;
}

    //GESTION DES GROUPES

    //RECUPERE LES INFOS D'UN GROUPE
    function getGroup($groupId){
        $db = dbConnect();
        $req = $db->prepare("SELECT * FROM `groups` WHERE id LIKE ?");
        $req->execute(array($groupId));
        $req = $req->fetchAll(PDO::FETCH_ASSOC);
        return $req;
    }
//SELECTIONNE LES GROUPES DONT L'UTILISATEUR FAIT PARTIE
function getGroups($id) {
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT groupadd.group,groups.title FROM groupadd INNER JOIN groups ON groupadd.group=groups.id WHERE groups.admin !=? AND groupadd.user = ?  AND groupadd.status = 'member';");
    $req->execute(array($id,$id));
    $req = $req->fetchAll(PDO::FETCH_ASSOC);
    return $req;
}

function getGroupsName($contactId) {
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT title FROM groupAdd INNER JOIN groups ON groupAdd.group = groups.id WHERE groups.admin=? OR groupAdd.user = ? AND groupAdd.status LIKE 'member' ");
    $req->execute(array($_SESSION['id'],$contactId));
    $req = $req->fetchAll(PDO::FETCH_ASSOC);
    return $req;
}
function getAdminGroup($contactId) {
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT groups.id, groups.title,groups.createDate,groups.admin FROM groupAdd INNER JOIN groups ON groupAdd.group = groups.id WHERE groups.admin = ?");
    $req->execute(array($contactId));
    $req = $req->fetchAll();
    return $req;
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
//AFFICHER LES MEMBRES D"UN GROUPE
function selectContactGroup($groupId){
    $db = dbConnect();
    $req = $db->prepare(" SELECT * FROM `groupAdd` INNER JOIN groups ON groupAdd.group = groups.id WHERE groupAdd.group = ? AND groupAdd.status = 'member' ");
    $req->execute(array($groupId));
    $req = $req->fetchAll();
    return $req;
}
function checkStatus($ID)
{
    $bdd=dbConnect();
    //RECHERCHER LE STATUS DE L'UTILISATEUR
    $reponse=$bdd->prepare('SELECT status
                            FROM users
                            WHERE id=:ID');

    $reponse->execute(['ID'=>$ID]);
    $a=false;
    while($donnees=$reponse->fetch())
    {
        $a=$donnees['status'];
    }
    return $a;
}
//AFFICHER EVENEMENTS AYANT POUR PARTICIPANT L'UTILISATEUR
function selectMember($ID)
{
    $bdd=dbConnect();
    //RECHERCHER LES EVENEMENTS PROPRES A L'UTILISATEUR EN TANT QUE PARTICIPANT
    $reponse=$bdd->prepare('SELECT event, title
                            FROM events, participate
                            WHERE user=:ID AND event=events.id AND admin!=user');

    $reponse->execute(['ID'=>$ID]);
    $a=false;
    $i=0;
    while($donnees=$reponse->fetch())
    {
        $a[$i][0]=$donnees['event'];
        $a[$i][1]=$donnees['title'];
        $i++;
    }
    return $a;
}

//AFFICHER LES EVENEMENTS AYANT POUR ADMINISTRATEUR L'UTILISATEUR
function selectAdmin($ID)
{
    $bdd=dbConnect();
    //RECHERCHER LES EVENEMENTS OU L'UTILISATEUR EN EST L'ADMINISTRATEUR
    $reponse=$bdd->prepare('SELECT id, title
                            FROM events
                            WHERE admin=:ID');
    $reponse->execute(['ID'=>$ID]);
    $b=false;
    $j=0;
    while($donnees=$reponse->fetch())
    {
        $b[$j][0]=$donnees['id'];
        $b[$j][1]=$donnees['title'];
        $j++;
    }
    return $b;
}

//AFFICHER LES INFORMATIONS DE L'EVENEMENT
function infoEvent($id)
{
    $bdd=dbConnect();
    //RECUPERER LES INFORMATIONS DE CET EVENEMENT
    $reponse=$bdd->prepare('SELECT title, eventDate, place
                            FROM events
                            WHERE id=:id');
    $reponse->execute(['id'=>$id]);
    $a=array();
    while($donnees=$reponse->fetch())
    {
        $a[0]=$donnees['title'];
        $a[1]=$donnees['eventDate'];
        $a[2]=$donnees['place'];
    }
    return $a;
}

//AFFICHER LA LISTE DE CONTACTS D'UN UTILISATEUR NE PARTICIPANT PAS 
function infoContact($ID, $id)
{
    $bdd=dbConnect();
    //RECUPERER LES CONTACTS DE L'UTILISATEUR QUI NE FONT PAS PARTIS DE CET EVENEMENT
    $reponse=$bdd->prepare('SELECT users.id AS id, lastName, name
                            FROM users, contacts
                            WHERE status!="company"
                            AND ((contact=:ID AND users.id=user
                                    AND users.id NOT IN (SELECT user
                                                        FROM participate
                                                        WHERE event=:id))
                            OR (contact=users.id AND user=:ID
                                    AND contact NOT IN (SELECT user
                                                        FROM participate
                                                        WHERE event=:id)))
                            ORDER BY lastName, name');
    $reponse->execute(['ID'=>$ID,
                        'id'=>$id]);
    $a=array();
    $i=0;
    while($donnees=$reponse->fetch())
    {
        $a[$i][0]=$donnees['id'];
        $a[$i][1]=$donnees['lastName'];
        $a[$i][2]=$donnees['name'];
        $i++;
    }
    return $a;
}
//AFFICHER ADMINISTRATEUR
function checkAdmin($id)
{
    $bdd=dbConnect();
    //CHERCHER L'ADMINISTRATEUR DE CET EVENEMENT
    $reponse=$bdd->prepare('SELECT admin
                            FROM events
                            WHERE id=:id');
    $reponse->execute(['id'=>$id]);
    while($donnees=$reponse->fetch())
    {
        $a=$donnees['admin'];
    }
    //RECUPERER LE NOM ET PRENOM DE L'ADMINISTRATEUR
    $reponse=$bdd->prepare('SELECT lastName, name
                            FROM users
                            WHERE id=:admin');
    $reponse->execute(['admin'=>$a]);
    while($donnees=$reponse->fetch())
    {
        $b[0]=$a;
        $b[1]=$donnees['lastName'];
        $b[2]=$donnees['name'];
    }
    return $b;
}
//AFFICHER PARTICIPANTS
function checkParticipate($id)
{
    $bdd=dbConnect();
    //RECUPERER LES NOMS ET PRENOMS DES PARTICIPANTS DE CET EVENEMENT
    $reponse=$bdd->prepare('SELECT user, lastName, name
                            FROM events, participate, users
                            WHERE events.id=event AND user=users.id AND user!=admin AND event=:id
                            ORDER BY lastName, name');
    $reponse->execute(['id'=>$id]);
    $c=false;
    $i=0;
    while($donnees=$reponse->fetch())
    {
        $c[$i][0]=$donnees['user'];
        $c[$i][1]=$donnees['lastName'];
        $c[$i][2]=$donnees['name'];
        $i++;
    }
    return $c;
}
?>