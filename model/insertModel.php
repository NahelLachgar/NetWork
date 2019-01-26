<?php
require_once('model/dbConnect.php');
require_once('model/deleteModel.php');
require_once('model/selectModel.php');
require_once('model/updateModel.php');

function sendMessage($content,$contactId,$userId) {
    $db = dbConnect();
    $sendMessage = $db->prepare('INSERT into privateMessages (content,receiver,sendDate,sender)
                                VALUES (:content,:receiver,NOW(),:sender)');
    $sendMessage->execute(array(
        "content"=>$content,
        "receiver"=>$contactId,
        "sender"=>$userId
    ));
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
    $insert = $db->prepare('INSERT INTO groupAdd(`message`, `addDate`, `user`, `status`, `group`) VALUES (NULL, NOW(),?,NULL,?)');
    $insert->execute(array($adminId,$lastId));
    return $lastId;
}

//AJOUTER DES CONTACTS DANS UN GROUPE
function contactAddGroup($memberId,$status,$groupID) {
    $db = dbConnect();
    $req = $db->prepare("INSERT INTO `groupAdd` (`message`, `addDate`, `user`, `status`, `group`) VALUES (NULL, NOW(), $memberId, $status, $groupID)");
    $req->execute(array($memberId,$status,$groupID));
    $lastId = $db->lastInsertId();
    $content = "vous avez ete ajoute dans le groupe";
    $url = "index.php?action=groups";
    //le champ contact remplace l'id du groupe
    $insertNotif = $db->prepare("INSERT INTO `notifications` (`user`, `contact`, `content`, `url`) VALUES (?, ?, ?, ?)");
    $insertNotif->execute(array($memberId,$groupID,$content,$url));
}

//AJOUT UNE NOTIFICATION 
function addNotif ($user,$content,$url,$icon="") {
    $db = dbConnect();
    $req = $db->prepare ('INSERT INTO notifications (`user`,`contact`,`content`,`url`,`status`,`icon`)
    VALUES (:user,:contact,:content,:url,"unseen",:icon)');
    $req -> execute(array(
        "user"=>$user,
        "contact"=>$_SESSION['id'],
        "content"=>$content,
        "url"=>$url,
        "icon"=>$icon
    ));
}
//AJOUT D'UN CONTACT
function addContact($contactId, $userId)
{
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO contacts (`contact`,`user`,`status`) VALUES(?,?,"waiting")');
    $req->execute(array($contactId, $userId));
    $profile = getProfile($userId);
    $userProfile = getProfile($contactId);
    if ($userProfile['status']== "employee") {

    $content = $profile['name'].' '.$profile['lastName'].' souhaite vous ajouter à ses contacts. Cliquez ici pour répondre.';
    $url = 'index.php?action=notificationsPage';
    $icon = $profile['photo'];

    $notif = addNotif($contactId,$content,$url,$icon);
    }
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
}
?>