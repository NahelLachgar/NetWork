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

function sendMessage($content,$contactId,$userId) {
    $db = dbConnect();
    $sendMessage = $db->prepare('INSERT into privateMessages (content,reicever,sendDate,sender)
                                VALUES (:content,:reicever,NOW(),:sender)');
    $sendMessage->execute(array(
        "content"=>$content,
        "reicever"=>$contactId,
        "sender"=>$userId
    ));
}
//RÉCUPÉRATION DES MESSAGES QU'A REÇUS OU ENVOYÉS L'UTILISATEUR
function getMessages($userId,$contactId) {
    $db = dbConnect();
    $messages = $db->prepare('SELECT * FROM privateMessages
    WHERE reicever = :userId AND sender = :contactId OR reicever = :contactId AND sender = :userId
    ORDER BY sendDate ASC');
    $messages->execute(array(
        "userId"=>$userId,
        "contactId"=>$contactId
    ));
    return $messages;
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

    //GESTION DES GROUPES

    //SELECTIONNE LES GROUPES DONT TU FAIS PARTIS
   /* function getGroups() {
        $db = dbConnect();
        $req = $db->prepare('SELECT ')
    }*/

    //CREER UN GROUPE
    function createGroup($nameGroup,$adminId){
        $db = dbConnect();
        $req = $db->prepare('INSERT INTO groups(title,createDate,admin) VALUES (?,NOW(),?)');
        $create = $req->execute(array($nameGroup,$adminId));
        return $create;
    }

    function lastId(){
        $db = dbConnect();
        $req = $db->prepare("SELECT LAST_INSERT_ID() FROM table");
        $post = $req->fetch();
        return $post;   
    }

    function contactAddGroup($memberId,$status) {
        $db = dbConnect();
        $groupId = $db->lastInsertId();
        $req = $db->prepare('INSERT INTO groupAdd(addDate,user,status,group) VALUES (NOW(),?,?,?');
        $create = $req->execute(array($memberId,$status,$groupId));
        
        return $create;
    }

    //SUPPRIMER LES COMMENTAIRES
    function deleteAllComs($ID)
    {
        $bdd=dbConnect();
        //RECHERCHER LES COMMENTAIRES DE L'UTILISATEUR
        $reponse=$bdd->prepare('SELECT com
                                FROM coms, comment
                                WHERE user=:ID AND com=coms.id');
        $reponse->execute(['ID'=>$ID]);
        $e=array();
        $m=0;
        while($donnees=$reponse->fetch())
        {
            $e[$m]=$donnees['com'];
            $m++;
        }
        //SUPPRIMER LES COMMENTAIRES DE L'UTILISATEUR
        for($m=0;$m<sizeof($e);$m++)
        {
            $reponse=$bdd->prepare('DELETE FROM comment
                                    WHERE com=:id');
            $reponse->execute(['id'=>$e[$m]]);
        }
        $reponse=$bdd->prepare('DELETE FROM coms
                                WHERE user=:ID');
        $reponse->execute(['ID'=>$ID]);
    }

    //SUPPRIMER LES PUBLICATIONS
    function deleteAllPubli($ID)
    {
        $bdd=dbConnect();
        //RECHERCHER LES PUBLICATIONS DE L'UTILISATEUR
        $reponse=$bdd->prepare('SELECT publication
                                FROM post, publications
                                WHERE user=:ID AND publication=publications.id');
        $reponse->execute(['ID'=>$ID]);
        $f=array();
        $n=0;
        while($donnees=$reponse->fetch())
        {
            $f[$n]=$donnees['publication'];
            $n++;
        }
        //RECHERCHER LES COMMENTAIRES SUR LES PUBLICATIONS DE L'UTILISATEUR
        $g=array();
        $o=0;
        for($n=0;$n<sizeof($f);$n++)
        { 
            $reponse=$bdd->prepare('SELECT com
                                    FROM coms, comment, post
                                    WHERE post.publication=:id AND comment.publication=post.publication AND com=coms.id');
            $reponse->execute(['id'=>$f[$n]]);
            while($donnees=$reponse->fetch())
            {
                $g[$o]=$donnees['com'];
                $o++;
            }
        }
        //SUPPRIMER LES COMMENTAIRES SUR LES PUBLICATIONS DE L'UTILISATEUR
        for($o=0;$o<sizeof($g);$o++)
        {
            $reponse=$bdd->prepare('DELETE FROM comment
                                    WHERE com=:id');
            $reponse->execute(['id'=>$g[$o]]);
            $reponse=$bdd->prepare('DELETE FROM coms
                                WHERE id=:id');
            $reponse->execute(['id'=>$g[$o]]);
        }
        //SUPPRIMER LES PUBLICATIONS DE L'UTILISATEUR
        $reponse=$bdd->prepare('DELETE FROM post
                                WHERE user=:ID');
        $reponse->execute(['ID'=>$ID]);
        for($n=0;$n<sizeof($f);$n++)
        {
            $reponse=$bdd->prepare('DELETE FROM publications
                                    WHERE id=:id');
            $reponse->execute(['id'=>$f[$n]]);
        }
    }

    //SUPPRIMER LES MESSAGES
    function deleteAllMessages($ID)
    {
        $bdd=dbConnect();
        //RECHERCHER LES MESSAGES DE L'UTILISATEUR
        $reponse=$bdd->prepare('SELECT privateMessage
                                FROM sendPrivate, privateMessages
                                WHERE user=:ID AND privateMessage=privateMessages.id');
        $reponse->execute(['ID'=>$ID]);
        $c=array();
        $k=0;
        while($donnees=$reponse->fetch())
        {
            $c[$k]=$donnees['privateMessage'];
            $k++;
        }
        //RECHERCHER LES MESSAGES RECU PAR L'UTILISATEUR
        $reponse=$bdd->prepare('SELECT privateMessage
                                FROM sendPrivate, privateMessages
                                WHERE receiver=:ID AND privateMessage=privateMessages.id');
        $reponse->execute(['ID'=>$ID]);
        $d=array();
        $l=0;
        while($donnees=$reponse->fetch())
        {
            $d[$l]=$donnees['privateMessage'];
            $l++;
        }
        //SUPPRIMER LES MESSAGES DE L'UTILISATEUR
        $reponse=$bdd->prepare('DELETE FROM sendPrivate
                                WHERE user=:ID');
        $reponse->execute(['ID'=>$ID]);
        for($k=0;$k<sizeof($c);$k++)
        {
            $reponse=$bdd->prepare('DELETE FROM privateMessages
                                    WHERE id=:id');
            $reponse->execute(['id'=>$c[$k]]);
        }
        //SUPPRIMER LES MESSAGES RECU PAR L'UTILISATEUR
        $reponse=$bdd->prepare('DELETE FROM sendPrivate
                                WHERE receiver=:ID');
        $reponse->execute(['ID'=>$ID]);
        for($l=0;$l<sizeof($d);$l++)
        {
            $reponse=$bdd->prepare('DELETE FROM privateMessages
                                    WHERE id=:id');
            $reponse->execute(['id'=>$d[$l]]);
        }
    }

    //SUPPRIMER EVENEMENTS / LES PARTICIPATIONS DANS LES EVENEMENTS
    function deleteAllEvents($ID)
    {
        $bdd=dbConnect();
        //RECHERCHER LES EVENEMENTS OU L'UTILISATEUR EN EST L'ADMINISTRATEUR
        /*$reponse=$bdd->prepare('SELECT events
                                FROM participate, events
                                WHERE admin=:ID AND event=events.id');
        $reponse->execute(['ID'=>$ID]);
        $b=array();
        $j=0;
        while($donnees=$reponse->fetch())
        {
            $b[$j]=$donnees['event'];
            $j++;
        }*/
        //SUPPRIMER LES PARTICIPATIONS DE L'UTILISATEUR
        $reponse=$bdd->prepare('DELETE FROM participate
                                WHERE user=:ID');
        $reponse->execute(['ID'=>$ID]);
        //SUPPRIMER LES EVENEMENTS OU L'UTILISATEUR EN EST L'ADMINISTRATEUR
        /*for($j=0;$j<sizeof($b);$j++)
        { 
            $reponse=$bdd->prepare('DELETE FROM events
                                    WHERE id=:id');
            $reponse->execute(['id'=>$b[$j]]);
        }*/
    }

    //SUPPRIMER LES GROUPES / LES PARTICIPATIONS DANS LES GROUPES
    function deleteAllGroups($ID)
    {
        $bdd=dbConnect();
        //RECHERCHER LES GROUPES OU L'UTILISATEUR EN EST L'ADMINISTRATEUR
        /*$reponse=$bdd->prepare('SELECT group
                                FROM groupAdd, groups
                                WHERE admin=:ID AND group=groups.id');
        $reponse->execute(['ID'=>$ID]);
        $a=array();
        $i=0;
        while($donnees=$reponse->fetch())
        {
            $a[$i]=$donnees['group'];
            $i++;
        }*/
        //SUPPRIMER LES PARTICIPATIONS DE L'UTILISATEUR
        $reponse=$bdd->prepare('DELETE FROM groupAdd
                                WHERE user=:ID');
        $reponse->execute(['ID'=>$ID]);
        //SUPPRIMER LES GROUPES OU L'UTILISATEUR EN EST L'ADMINISTRATEUR
        /*for($i=0;$i<sizeof($a);$i++)
        { 
            $reponse=$bdd->prepare('DELETE FROM groups
                                    WHERE id=:id');
            $reponse->execute(['id'=>$a[$i]]);
        }*/
    }

    //SUPPRIMER LES CONTACTS
    function deleteAllContacts($ID)
    {
        $bdd=dbConnect();
        //SUPPRIMER LES CONTACTS DE L'UTILISATEUR
        $reponse=$bdd->prepare('DELETE FROM contacts
                                WHERE user=:ID OR contact=:ID');
        $reponse->execute(['ID'=>$ID]);
    }

    //SUPPRIMER L'UTILISATEUR
    function deleteUser($ID)
    {
        $bdd=dbConnect();
        //SUPPRIMER LE COMPTE DE L'UTILISATEUR
        $reponse=$bdd->prepare('DELETE FROM users
                                WHERE id=:ID');
        $reponse->execute(['ID'=>$ID]);
    }

    //AFFICHER EVENEMENTS AYANT POUR PARTICIPANT L'UTILISATEUR
    function selectMember($ID)
    {
        $bdd=dbConnect();
        //rechercher les événements propres à l'utilisateur en tant que participant
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

    //CREER UN EVENEMENT
    function insertEvent($ID, $title, $eventDate, $place)
    {
        $bdd=dbConnect();
        //CREER L'EVENEMENT AVEC L'UTILISATEUR EN TANT QU'ADMINISTRATEUR
        $reponse=$bdd->prepare('INSERT INTO `events` (title, eventDate, place, admin)
                                VALUES (:title, :eventDate, :place, :ID)');
        $reponse->execute(['title'=>$title,
                            'eventDate'=>$eventDate,
                            'place'=>$place,
                            'ID'=>$ID]);
        //CHERCHER L'ID DU NOUVEL EVENEMENT CREE
        $reponse=$bdd->prepare('SELECT id
                                FROM events
                                WHERE admin=:ID');
        $reponse->execute(['ID'=>$ID]);
        while($donnees=$reponse->fetch())
        {
            $c=$donnees['id'];
        }
        //AJOUTER L'UTILISATEUR EN TANT QUE PARTICIPANT
        $reponse=$bdd->prepare('INSERT INTO `participate` (user, event)
                                VALUES (:ID, :event)');
        $reponse->execute(['ID'=>$ID,
                        'event'=>$c]);
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

    //QUITTER EVENEMENT
    function deleteParticipate($ID, $id)
    {
        $bdd=dbConnect();
        //SUPPRIMER LA PARTICIPATION DE L'UTILISATEUR DANS CET EVENEMENT
        $reponse=$bdd->prepare('DELETE FROM participate
                                WHERE user=:ID AND event=:id');
        $reponse->execute(['ID'=>$ID,
                            'id'=>$id]);
    }

    //SUPPRIMER EVENEMENT
    function deleteEvent($ID)
    {
        $bdd=dbConnect();
        //SUPPRIMER LA PARTICIPATION DES PARTICIPANTS DE CET EVENEMENT
        $reponse=$bdd->prepare('DELETE FROM participate
                                WHERE event=:ID');
        $reponse->execute(['ID'=>$ID]);
        //SUPPRIMER L'EVENEMENT
        $reponse=$bdd->prepare('DELETE FROM events
                                WHERE id=:ID');
        $reponse->execute(['ID'=>$ID]);
    }

    //MODIFIER EVENEMENT
    function updateEvent($id, $title, $eventDate, $place)
    {
        $bdd=dbConnect();
        //MODIFIER LE TITRE, LA DATE ET L'EMPLACEMENT DE L'EVENEMENT
        $reponse=$bdd->prepare('UPDATE events
                                SET title=:title, eventDate=:eventDate, place=:place
                                WHERE id=:id');
        $reponse->execute(['title'=>$title,
                            'eventDate'=>$eventDate,
                            'place'=>$place,
                            'id'=>$id]);
    }

    //AJOUTER PARTICIPANT
    function insertParticipate($ID, $id)
    {
        $bdd=dbConnect();
        //AJOUTER LA PARTICIPATION DE L'UTILISATEUR DANS CET EVENEMENT
        $reponse=$bdd->prepare('INSERT INTO participate (user, event)
                                VALUES (:user, :event)');
        $reponse->execute(['user'=>$ID,
                            'event'=>$id]);
    }
    /*
    //AFFICHER LES EVENEMENTS AYANT INVITER L'UTILISER A PARTICIPER
    function selectInvit($ID, $type)
    {
        $bdd=dbConnect();
        //RECHERCHER LES INVITATIONS A PARTICIPER A L'EVENEMENT
    }

    //AFFICHER INVITATION SUR L'EVENEMENT
    function invitation($ID, $id, $type)
    {
        $bdd=dbConnect();
        //CHERCHER LES INVITATIONS ENVOYES A L'UTILISATEUR
    }

    //SUPPRIMER INVITATION
    function deleteInvit($ID, $id, $type)
    {
        $bdd=dbConnect();
        //DECLINER LA PARTICIPATION DE L'UTILISATEUR DANS CET EVENEMENT
    }}*/
?>
