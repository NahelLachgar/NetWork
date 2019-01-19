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
// MODIFIER LE GROUPE PART1 (CHANGE L'ADMIN DANS LA TABLE GROUPE)
function updateGroups($name,$nAdmin,$lAdmin,$status,$groupId,$groupPhoto){
   $db = dbConnect();
   if($groupPhoto){
       $req = $db->prepare("UPDATE groups SET title = ?, admin = ?, photo = ?  WHERE id = ?");
       $req->execute(array($name, $nAdmin, $groupPhoto, $groupId));
       updateStatutLastAdminGroup($status,$lAdmin,$groupId);
        updateStatutNewAdminGroup($nAdmin,$groupId);
    } else{
        $req = $db->prepare("UPDATE groups SET title = ?, admin = ?  WHERE id = ?");
        $req->execute(array($name, $nAdmin, $groupId));
        updateStatutLastAdminGroup($status,$lAdmin,$groupId);
        updateStatutNewAdminGroup($nAdmin,$groupId);
    }
}

function updateStatutLastAdminGroup($status,$lAdmin,$groupId){
    $db = dbConnect();
    $req = $db->prepare("UPDATE groupadd SET status = ? WHERE groupadd.user = ? AND groupadd.group = ?");
    $req->execute(array($status, $lAdmin, $groupId));
}
function updateStatutNewAdminGroup($nAdmin,$groupId){
    $db = dbConnect();
    $req = $db->prepare("UPDATE groupadd SET status = NULL WHERE groupadd.user = ? AND groupadd.group = ?");
    $req->execute(array($nAdmin, $groupId));
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

//ACTIVER / DESACTIVER LE COMPTE DE L'UTILISATEUR
function updateActive($id, $active)
{
    $bdd=dbConnect();
    //MODIFIER L'ETAT DU COMPTE
    $reponse=$bdd->prepare('UPDATE users
                            SET active=:active
                            WHERE id=:id');
        $reponse->execute(['active'=>$active,
                            'id'=>$id]);
}
?>