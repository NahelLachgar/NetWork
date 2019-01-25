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
}

//AJOUT UNE NOTIFICATION 
function addNotif ($contactId,$content,$url) {
    $db = dbConnect();
    $req = $db->prepare ('INSERT INTO ')
}
//AJOUT D'UN CONTACT
function addContact($contactId, $idUser)
{
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO contacts(contact,user) VALUES(?,?)');
    $req->execute(array($contactId, $idUser));
    return $req;
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