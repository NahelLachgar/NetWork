<?php
require_once('model/dbConnect.php');
require_once('model/insertModel.php');
require_once('model/deleteModel.php');
require_once('model/updateModel.php');
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
    $contactsId = $db->prepare('SELECT user AS id FROM contacts WHERE `status` LIKE "accepted" AND contact = :id 
            UNION
            SELECT contact AS id FROM contacts WHERE `status` LIKE "accepted" AND user = :id');
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
//RÉCUPÈRE LES PUBLICATION D'UN SEUL UTILISATEUR
function getUserPosts($contactId)
{
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
function getMessages($userId, $contactId)
{
    $db = dbConnect();
    $messages = $db->prepare('SELECT * FROM privateMessages
    WHERE receiver = :userId AND sender = :contactId OR receiver = :contactId AND sender = :userId
    ORDER BY sendDate ASC');
    $messages->execute(array(
        "userId" => $userId,
        "contactId" => $contactId
    ));
    return $messages;
}
function getGroupMessages($groupId)
{
    $db = dbConnect();
    $messages = $db->prepare('SELECT groupAdd.id AS messageId,groupAdd.*,users.* FROM groupAdd JOIN users ON groupAdd.user = users.id
    WHERE groupAdd.`group` = :groupId AND groupAdd.`status`= "message"
    ORDER BY groupAdd.addDate ASC');
    $messages->execute(array(
        "groupId" => $groupId
    ));
    return $messages;
}
//RÉCUPÉRATION DES PUBLICATIONS DES CONTACTS ET ENTREPRISES SUIVIES PAR L'UTILISATEUR (FIL D'ACUTALITÉ)
function getContactsPosts($userId)
{
    $db = dbConnect();
    $contacts = getContacts($userId);
        $contactsFetch = $contacts->fetchAll(PDO::FETCH_ASSOC);
        if (count($contactsFetch) > 1) {
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
                while ($i < count($array) - 1) {
                    if ($array[$i]['postDate'] <= $array[$i + 1]['postDate']) {
                        $tmp = $array[$i]['postDate'];
                        $array[$i + 1]['postDate'] = $array[$i]['postDate'];
                        $array[$i + 1]['postDate'] = $tmp;
                        $i++;
                    }
                    $i++;
                }
                return $array;
            }      
            $contactsPosts = arraySortId($contactsPosts);
        }
    } else if (count($contactsFetch)==1) {
        $posts = $db->prepare('SELECT p.*,u.lastName AS lastName,u.name AS name, u.job AS job, u.company AS company, u.id AS contactId,u.photo AS photo FROM users u 
            JOIN post ON u.id = post.user
            JOIN publications p ON post.publication = p.id
            WHERE post.user = ? OR post.user = ?  
            ORDER BY p.postDate DESC');
        $posts->execute(array($contactsFetch[0]['id'], $userId));
        $contactsPosts = $posts -> fetchAll(PDO::FETCH_ASSOC);
    } else if (count($contactsFetch)==0) {
        $posts = getUserPosts($userId);
        $contactsPosts = $posts -> fetchAll(PDO::FETCH_ASSOC);
    }
    return $contactsPosts;
}
//VÉRIFIE SI LES 2 UTILISATEURS SONT AMIS
function checkContacts($userId,$contactId) {
$db = dbConnect();
$req = ('SELECT * FROM contacts 
    WHERE contact = :userId AND user = contactId
    UNION 
    SELECT * FROM contacts 
    WHERE contact = :contactId AND user = userId');
$req -> execute(array(
    "userId"=>$userId,
    "contactId"=>$contactId
));
$check = $req->fetch();
return $check;
}
//SUGGESTIONS D'EMPLOYÉS POUR L'UTILISATEUR 
function getEmployeeSuggests($userId)
{
    $db = dbConnect();
    $contacts = getContacts($userId);
        $employeeSuggests = $db->prepare('SELECT DISTINCT u.* 
    FROM users u JOIN contacts c ON u.id = c.user WHERE c.contact = :id AND c.user NOT LIKE :userId AND u.status LIKE "employee"
    UNION
    SELECT DISTINCT u.* 
    FROM users u JOIN contacts c  ON u.id = c.contact WHERE c.user = :id AND c.contact NOT LIKE :userId AND u.status LIKE "employee"');
    $employees = [];
    while ($contactsFetch = $contacts -> fetch()) {
            $employeeSuggests->execute(array(
                "id" => $contactsFetch['id'],
                "userId" => $userId
            ));
            $employeeSuggestsFetch = $employeeSuggests->fetchAll(PDO::FETCH_ASSOC);
            $employees += $employeeSuggestsFetch;
        }
        if (isset($employees)) {
            
            return $employees;
        }
    
}
//SUGGESTIONS D'ENTREPRISE POUR L'UTILISATEUR 
function getCompanySuggests($userId)
{
    $db = dbConnect();
    $contacts = getContacts($userId);
        $companySuggests = $db->prepare('SELECT DISTINCT u.* 
    FROM users u JOIN contacts c ON u.id = c.user WHERE c.contact = :id AND c.user NOT LIKE :userId AND u.status LIKE "company"
    UNION
    SELECT DISTINCT u.* 
    FROM users u JOIN contacts c  ON u.id = c.contact WHERE c.user = :id AND c.contact NOT LIKE :userId AND u.status LIKE "company"');
    $companies = [];
    while ($contactsFetch = $contacts -> fetch()) {
            $companySuggests->execute(array(
                "id" => $contactsFetch['id'],
                "userId" => $userId
            ));
            $companySuggestsFetch = $companySuggests->fetchAll(PDO::FETCH_ASSOC);
            $companies += $companySuggestsFetch;
        }
        if (isset($companies)) {   
            return $companies;
        }
}
//NOMBRE DE CONTACTS
function getContactsCount($userId)
{
    $db = dbConnect();
    $contactsCount1 = $db->prepare('SELECT COUNT(*) AS contactsNb FROM contacts 
    JOIN users ON contacts.user = users.id 
    WHERE users.status LIKE "employee" AND contacts.contact=:id AND contacts.status="accepted"');
    $contactsCount1->execute(array("id" => $userId));
    $contactsFetch1 = $contactsCount1->fetch();
    $contactsCount2 = $db->prepare('SELECT COUNT(*) AS contactsNb
    FROM contacts 
    JOIN users ON contacts.contact = users.id WHERE users.status LIKE "employee" AND user=:id AND contacts.status="accepted"');
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
    WHERE users.status LIKE "company" AND contacts.contact=:id');
    $followedCompaniesCount1->execute(array("id" => $userId));
    $followedCompaniesFetch1 = $followedCompaniesCount1->fetch();
    $followedCompaniesCount2 = $db->prepare('SELECT COUNT(*) AS companiesNb
    FROM contacts 
    JOIN users ON contacts.contact = users.id WHERE users.status LIKE "company" AND user=:id');
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
function getContactToUser($userId)
{
    $db = dbConnect();
    $req = $db->prepare('SELECT user AS id FROM contacts WHERE contact LIKE ? 
    UNION
    SELECT contact AS id FROM contacts WHERE user LIKE ?');
    $req->execute(array($userId, $userId));
    $post = $req->fetchAll();
    if ($post) {
        foreach ($post as $res) {
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
    //RECUPERE LES INFOS D'UN GROUPE
function getGroup($groupId)
{
    $db = dbConnect();
    $req = $db->prepare("SELECT g.*,gA.* FROM groups g JOIN groupAdd gA 
    ON g.id = gA.group WHERE g.id LIKE ?");
    $req->execute(array($groupId));
    $req = $req->fetch();
    return $req;
}
//SELECTIONNE LES GROUPES DONT L'UTILISATEUR FAIT PARTIE
function getGroups($id)
{
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT groupAdd.group,groups.* FROM groupAdd INNER JOIN groups ON groupAdd.group=groups.id WHERE groups.admin !=? AND groupAdd.user = ?  AND groupAdd.status = 'member';");
    $req->execute(array($id,$id));
    $req = $req->fetchAll(PDO::FETCH_ASSOC);
    return $req;
}
function getNotifs() {
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT users.id AS contactId,notifications.* FROM users JOIN notifications
    ON users.id = notifications.contact 
     WHERE user = ? AND `type` NOT LIKE 'message' AND `type` NOT LIKE 'groupMessage' ");
    $req->execute(array($_SESSION['id']));
    $req = $req->fetchAll(PDO::FETCH_ASSOC);
    return $req; 
}
function getGroupsName($contactId)
{
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT groups.* FROM groupAdd INNER JOIN groups ON groupAdd.group = groups.id WHERE groups.admin=? OR groupAdd.user = ? AND groupAdd.status LIKE 'member' ");
    $req->execute(array($_SESSION['id'], $contactId));
    $req = $req->fetchAll(PDO::FETCH_ASSOC);
    return $req;
}
function getAdminGroup($contactId)
{
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT groups.* FROM groupAdd INNER JOIN groups ON groupAdd.group = groups.id WHERE groups.admin = ?");
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
function selectContactGroup($groupId)
{
    $db = dbConnect();
    $req = $db->prepare(" SELECT * FROM `groupAdd` INNER JOIN groups ON groupAdd.group = groups.id WHERE groupAdd.group = ? AND groupAdd.status = 'member' ");
    $req->execute(array($groupId));
    $req = $req->fetchAll();
    return $req;
}
function checkStatus($ID)
{
    $bdd = dbConnect();
    //RECHERCHER LE STATUS DE L'UTILISATEUR
    $reponse = $bdd->prepare('SELECT status
                            FROM users
                            WHERE id=:ID');
    $reponse->execute(['ID' => $ID]);
    $a = false;
    while ($data = $reponse->fetch()) {
        $a = $data['status'];
    }
    return $a;
}
//AFFICHER EVENEMENTS AYANT POUR PARTICIPANT L'UTILISATEUR
function selectMember($ID)
{
    $bdd = dbConnect();
    //RECHERCHER LES EVENEMENTS PROPRES A L'UTILISATEUR EN TANT QUE PARTICIPANT
    $reponse = $bdd->prepare('SELECT event, title
                            FROM events, participate
                            WHERE user=:ID AND event=events.id AND admin!=user');
    $reponse->execute(['ID' => $ID]);
    $a = false;
    $i = 0;
    while ($data = $reponse->fetch()) {
        $a[$i][0] = $data['event'];
        $a[$i][1] = $data['title'];
        $i++;
    }
    return $a;
}
//AFFICHER LES EVENEMENTS AYANT POUR ADMINISTRATEUR L'UTILISATEUR
function selectAdmin($ID)
{
    $bdd = dbConnect();
    //RECHERCHER LES EVENEMENTS OU L'UTILISATEUR EN EST L'ADMINISTRATEUR
    $reponse = $bdd->prepare('SELECT id, title
                            FROM events
                            WHERE admin=:ID');
    $reponse->execute(['ID' => $ID]);
    $b = false;
    $j = 0;
    while ($data = $reponse->fetch()) {
        $b[$j][0] = $data['id'];
        $b[$j][1] = $data['title'];
        $j++;
    }
    return $b;
}
//AFFICHER LES INFORMATIONS DE L'EVENEMENT
function infoEvent($id)
{
    $bdd = dbConnect();
    //RECUPERER LES INFORMATIONS DE CET EVENEMENT
    $reponse = $bdd->prepare('SELECT title, eventDate, place
                            FROM events
                            WHERE id=:id');
    $reponse->execute(['id' => $id]);
    $a = array();
    while ($data = $reponse->fetch()) {
        $a[0] = $data['title'];
        $a[1] = $data['eventDate'];
        $a[2] = $data['place'];
    }
    return $a;
}
//AFFICHER LA LISTE DE CONTACTS D'UN UTILISATEUR NE PARTICIPANT PAS 
function infoContact($ID, $id)
{
    $bdd = dbConnect();
    //RECUPERER LES CONTACTS DE L'UTILISATEUR QUI NE FONT PAS PARTIS DE CET EVENEMENT
    $reponse = $bdd->prepare('SELECT users.id AS id, lastName, name
                            FROM users, contacts
                            WHERE users.status!="company" AND contacts.status="accepted"
                            AND ((contact=:ID AND users.id=user
                                    AND users.id NOT IN (SELECT user
                                                        FROM participate
                                                        WHERE event=:id))
                            OR (contact=users.id AND user=:ID
                                    AND contact NOT IN (SELECT user
                                                        FROM participate
                                                        WHERE event=:id)))
                            ORDER BY lastName, name');
    $reponse->execute(['ID' => $ID,
                        'id' => $id]);
    $a = array();
    $i = 0;
    while ($data = $reponse->fetch()) {
        $a[$i][0] = $data['id'];
        $a[$i][1] = $data['lastName'];
        $a[$i][2] = $data['name'];
        $i++;
    }
    return $a;
}
//AFFICHER ADMINISTRATEUR
function checkAdmin($id)
{
    $bdd = dbConnect();
    //CHERCHER L'ADMINISTRATEUR DE CET EVENEMENT
    $reponse = $bdd->prepare('SELECT admin
                            FROM events
                            WHERE id=:id');
    $reponse->execute(['id' => $id]);
    while ($data = $reponse->fetch()) {
        $a = $data['admin'];
    }
    //RECUPERER LE NOM ET PRENOM DE L'ADMINISTRATEUR
    $reponse = $bdd->prepare('SELECT lastName, name
                            FROM users
                            WHERE id=:admin');
    $reponse->execute(['admin' => $a]);
    while ($data = $reponse->fetch()) {
        $b[0] = $a;
        $b[1] = $data['lastName'];
        $b[2] = $data['name'];
    }
    return $b;
}
//AFFICHER PARTICIPANTS
function checkParticipate($id)
{
    $bdd = dbConnect();
    //RECUPERER LES NOMS ET PRENOMS DES PARTICIPANTS DE CET EVENEMENT
    $reponse = $bdd->prepare('SELECT user, lastName, name
                            FROM events, participate, users
                            WHERE events.id=event AND user=users.id AND user!=admin AND event=:id
                            ORDER BY lastName, name');
    $reponse->execute(['id' => $id]);
    $c = false;
    $i = 0;
    while ($data = $reponse->fetch()) {
        $c[$i][0] = $data['user'];
        $c[$i][1] = $data['lastName'];
        $c[$i][2] = $data['name'];
        $i++;
    }
    return $c;
}
//CHERCHER L'ETAT DU COMPTE DE L'UTILISATEUR
function checkActive($id)
{
    $bdd=dbConnect();
    //MODIFIER LE TITRE, LA DATE ET L'EMPLACEMENT DE L'EVENEMENT
    $reponse=$bdd->prepare('SELECT active
                            FROM users
                            WHERE id=:id');
    $reponse->execute(['id'=>$id]);
    while ($data = $reponse->fetch()) {
        $active=$data['active'];
    }
    if (isset($active)) {
    return $active;
    }
}
//RECUPERE TOUS LES COMMENTAIRES D'UNE PUBLICATION	
function getCommentsToPublications($publicationId){	
    $db = dbConnect();	
    $comments = $db->prepare("SELECT coms.content,coms.comDate,coms.user,publications.id,post.user as contactPost FROM coms JOIN comment ON coms.id = comment.com JOIN publications ON comment.publication=publications.id JOIN post ON publications.id=post.publication JOIN users ON post.user=users.id WHERE publications.id=?"); 	
    $comments->execute(array($publicationId));	
    $comments = $comments->fetchAll();	
    return $comments;	
}
?>