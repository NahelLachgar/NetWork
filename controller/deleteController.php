<?php
require_once('controller/insertController.php');
require_once('controller/selectController.php');
require_once('controller/updateController.php');
require_once('model/insertModel.php');
require_once('model/updateModel.php');
require_once('model/deleteModel.php');
require_once('model/selectModel.php');

//FUNCTION UNFOLLOW UN CONTACT
function removeContact($contactId, $userId)
{
    $unf = unfollow($contactId, $userId);
    if ($unf) {
        header('Location:index.php?action=home');
    }
}

function deleteNotification($notifId) {
    deleteNotif($notifId);
    header('Location:index.php?action=notificationsPage');
}

function refuseContact($contactId) {
    refuseContactAdd($contactId);
    header('Location:index.php?action=notificationsPage');

}
// SUPPRIMER UN GROUPE
function deleteGroup($groupId)
{
    deletegroupAdd($groupId);
    deleteGroups($groupId);
    header('Location:index.php?action=groups');
}

// SUPPRIMER UN MEMBRE DU GROUPE COTE ADMIN 
function adminRemoveToGroup($contactId, $groupId, $admin, $id)
{
    $remove = removeFromGroup($contactId, $groupId);
    $status = checkStatus($id);
    groupManage($groupId,$admin,$id);
}

// QUITTER LE GROUPE
function RemoveToGroup($contactId, $groupId, $id)
{
    $remove = removeFromGroup($contactId, $groupId);
    $status = checkStatus($id);
    sessionGroup($id);
}

	// SE DECONNECTER
function disconnect()
{
    session_destroy();
    header('Location:index.php');
}

//SUPPRIMER LE COMPTE
function deleteAccount($id)
{
    //SUPPRIMER LES COMMENTAIRES
    deleteAllComs($id);
    //SUPPRIMER LES PUBLICATIONS
    deleteAllPubli($id);
    //SUPPRIMER LES MESSAGES
    deleteAllMessages($id);
    //SUPPRIMER LES EVENEMENTS / LES PARTICIPATIONS DANS LES EVENEMENTS
    deleteAllEvents($id);
    //SUPPRIMER LES GROUPES / LES PARTICIPATIONS DANS LES GROUPES
    deleteAllGroups($id);
    //SUPPRIMER LES CONTACTS
    deleteAllContacts($id);
    //SUPPRIMER L'UTILISATEUR
    deleteUser($id);
    header('location: index.php');
}

//SUPPRIMER LA PARTICIPATION D'UN UTILISATEUR
function quitEvent($ID, $id, $role)
{
    //SUPPRIMER LA PARTICIPATION DE L'UTILISATEUR DANS CET EVENEMENT
    deleteParticipate($ID, $id);
    if ($role == 'participate') {
        $_SESSION['erreur'] = "Vous vous êtes bien retiré de l'événement.";
        header('location: index.php?action=showEvents');
    } else if ($role == 'admin') {
        $_SESSION['erreur'] = "Vous avez bien retiré la participation de cette personne de cet événement.";
        eventView($ID, $id, 'admin');
    }
}

//SUPPRIMER UN EVENEMENT
function removeEvent($id)
{
    //SUPPRIMER L'EVENEMENT
    deleteEvent($id);
    $_SESSION['erreur'] = "Vous avez supprimé cet événement avec succès.";
    header('location: index.php?action=showEvents');
}
?>