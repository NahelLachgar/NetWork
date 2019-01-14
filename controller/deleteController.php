<?php
include_once('controller/insertController.php');
include_once('controller/selectController.php');
include_once('controller/updateController.php');
include_once('model/insertModel.php');
include_once('model/updateModel.php');
include_once('model/deleteModel.php');
include_once('model/selectModel.php');

// SUPPRIMER UN GROUPE
function deleteGroup($groupId)
{
    deleteGroupAdd($groupId);
    deleteGroups($groupId);
    header('Location:index.php?action=groups');
}
function adminRemoveToGroup($contactId, $groupId, $id)
{
    $remove = removeFromGroup($contactId, $groupId);
    $status = checkStatus($id);
    groupManage($groupId, $id);
}

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

	

	//AFFICHER LA PAGE DE SUPPRESSION DE COMPTE
function deleteView($id)
{
    $profile = getProfile($id);
    $contactsNb = getContactsCount($id);
    if ($contactsNb > 0) {
        $contactsPosts = getContactsPosts($id);
        $companiesSuggests = getCompanySuggests($id);
        $employeesSuggests = getEmployeeSuggests($id);
    }
    $followedCompaniesNb = getFollowedCompaniesCount($id);
    $status = checkStatus($id);
    include('view/deleteView.php');
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