<?php
require_once('model/dbConnect.php');
require_once('model/deleteModel.php');
require_once('model/selectModel.php');
require_once('model/updateModel.php');

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

// AJOUTER L'UTILISATEUR DANS LA BDD
function addUser($lastName, $firstName, $email, $phone, $photo, $password, $status, $job, $company, $town)
{
    // ON SE CONNECTE
    $db = dbConnect();
    // ON INSERT LES DONNES DANS LA BDD
    $insertUser = $db->prepare('INSERT INTO users (name, lastName, email, phone, photo, password, status, job, company, town, active) VALUES (?,?,?,?,?,?,?,?,?,?, "activated")');
    $insertUser->execute(array($firstName, $lastName, $email, $phone, $photo, $password, $status, $job, $company, $town));
}

//CREER UN GROUPE
function createGroup($nameGroup,$adminId,$groupPhoto){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO groups(title,createDate,admin,photo) VALUES (?,NOW(),?,?)');
    $req->execute(array($nameGroup,$adminId,$groupPhoto));
    $lastId = $db->lastInsertId();
    $insert = $db->prepare("INSERT INTO groupAdd(`message`, `addDate`, `user`, `status`, `group`) VALUES (NULL, NOW(),?,'member',?)");
    $insert->execute(array($adminId,$lastId));
    return $lastId;
}

//AJOUTER DES CONTACTS DANS UN GROUPE
function contactAddGroup($memberId,$status,$groupID) {
    $db = dbConnect();
    $req = $db->prepare("INSERT INTO `groupAdd` (`message`, `addDate`, `user`, `status`, `group`) VALUES (NULL, NOW(), $memberId, $status, $groupID)");
    $req->execute(array($memberId,$status,$groupID));

    $groupInfo = getGroup($groupID);
    $profile = getProfile($_SESSION['id']);
    $content = $profile['name'].' '.$profile['lastName'].' vous a ajouté au groupe '.$groupInfo['title'].".";
    $url = 'index.php?action=showGroupMessages&groupId='.$groupID;
    $icon = $profile['photo'];
    $type = "groupAdd";

    $notif = addNotif($memberId,$content,$url,$icon,$type);
}

//AJOUT UNE NOTIFICATION
function addNotif ($user,$content,$url=null,$icon="",$type) {
    $db = dbConnect();
    $req = $db->prepare ('INSERT INTO notifications (`user`,`contact`,`content`,`url`,`status`,`icon`,`type`)
    VALUES (:user,:contact,:content,:url,"unseen",:icon,:type)');
    $req -> execute(array(
        "user"=>$user,
        "contact"=>$_SESSION['id'],
        "content"=>$content,
        "url"=>$url,
        "icon"=>$icon,
        "type"=>$type
    ));
}

//AJOUT D'UN CONTACT
function addContact($contactId, $userId)
{
    $db = dbConnect();
    $userProfile = getProfile($contactId);
    $profile = getProfile($_SESSION['id']);
    if ($userProfile['status']== "employee") {
        $status = "waiting";
        $content = $profile['name'].' '.$profile['lastName'].' souhaite vous ajouter à ses contacts.';
        $url = 'index.php?action=notificationsPage';
        $icon = $profile['photo'];
        $type = "contactAdd";
    
        $notif = addNotif($contactId,$content,$url,$icon,$type);
        } else {
            $status = "accepted";
        }
    $req = $db->prepare('INSERT INTO contacts(contact,user,`status`) VALUES(?,?,?)');
    $req->execute(array($contactId, $userId,$status));
    $profile = getProfile($userId);
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

//AJOUTER PARTICIPANT
function insertParticipate($ID, $id)
{
    $bdd=dbConnect();
    //AJOUTER LA PARTICIPATION DE L'UTILISATEUR DANS CET EVENEMENT
    $reponse=$bdd->prepare('INSERT INTO participate (user, event)
                            VALUES (:user, :event)');
    $reponse->execute(['user'=>$ID,
                        'event'=>$id]);
    $profile = getProfile($_SESSION['id']);
    $event = infoEvent($id);
    $content = $profile['name'].' '.$profile['lastName'].' vous a ajouté à l\'évènement '.$event[0].".";
    $url = 'index.php?action=notificationsPage';
    $icon = $profile['photo'];
    $type = "eventAdd";
    $notif = addNotif($ID,$content,$url,$icon,$type);
}
?>