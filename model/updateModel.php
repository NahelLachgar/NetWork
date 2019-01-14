<?php
require_once('model/dbConnect.php');
require_once('model/insertModel.php');
require_once('model/selectModel.php');
require_once('model/deleteModel.php');
// MODIFICATION DES CHAMPS DU PROFIL EXCEPTE LE CHAMP photo
function updateProfiles($lastName, $name, $email, $pass, $photo, $phone, $job, $company, $town, $id)
{
    $db = dbConnect();
    if($photo){
    $req = $db->prepare('UPDATE users SET users.lastName = ?, users.name = ?, users.email = ?,users.password = ?, users.photo = ?,users.phone = ?,users.job = ?,users.company = ?,users.town = ?  WHERE users.id = ?');
    $password = password_hash($pass, PASSWORD_BCRYPT);
    $req->execute(array($lastName, $name, $email, $password, $photo, $phone, $job, $company, $town, $id));
    } else {
    $req = $db->prepare('UPDATE users SET users.lastName = ?, users.name = ?, users.email = ?,users.password = ?,users.phone = ?,users.job = ?,users.company = ?,users.town = ?  WHERE users.id = ?');
    $password = password_hash($pass, PASSWORD_BCRYPT);
    $req->execute(array($lastName, $name, $email, $password, $phone, $job, $company, $town, $id));
    }
    return $req;
}
 // MODIFIER LE GROUPE
 function updateGroups($name,$admin,$groupId,$groupPhoto){
    $db = dbConnect();
    if($groupPhoto){
    $req = $db->prepare("UPDATE groups SET title = ?, admin = ?, photo = ?  WHERE id = ?");
    $req->execute(array($name, $admin, $groupPhoto, $groupId));
    } else {
    $req = $db->prepare("UPDATE groups SET title = ?, admin = ?  WHERE id = ?");
    $req->execute(array($name, $admin, $groupId));
    }
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
?>