<?php
require_once('controller/insertController.php');
require_once('controller/selectController.php');
require_once('controller/deleteController.php');
require_once('model/insertModel.php');
require_once('model/updateModel.php');
require_once('model/deleteModel.php');
require_once('model/selectModel.php');
//FUNCTION AFFICHE LES INFOS A MODIFIER
function updateToProfile($id)
{
    $profile=getProfile($id);
    $contactsNb=getContactsCount($id);
    if($contactsNb>0) {
        $contactsPosts=getContactsPosts($id);
        $companiesSuggests=getCompanySuggests($id);
        $employeesSuggests=getEmployeeSuggests($id);
    }
    $followedCompaniesNb=getFollowedCompaniesCount($id);
    $recup = getProfileUpdate($id);
    $status = checkStatus($id);
    require_once('./view/profilUpdateView.php');
}

function getProfileSearch($id)
{
    $recup = getProfileUpdate($id);
    $status = checkStatus($id);
    require_once('./view/profilePageView.php');
}

	// MODIFIER SON PROFIL
function validateProfile($lastname, $name, $email, $pass, $confirmPass, $phone, $job, $company, $town, $id)
{
    $profilePhoto = $_FILES['photo']['name'];
    $lastName = htmlspecialchars($lastname);
    $Name = htmlspecialchars($name);
    $Email = htmlspecialchars($email);
    $Phone = htmlspecialchars($phone);
    $Job = htmlspecialchars($job);
    $Company = htmlspecialchars($company);
    $Town = htmlspecialchars($town);
    if ($pass != $confirmPass) {
        header('Location:index.php?action=updateProfile');
    } else {
		// PHOTO
        if ($profilePhoto) {
			// ON SEPARE LE NOM DE L'IMAGE DE SON EXTENSION
            list($name, $ext) = explode(".", $profilePhoto);    
			// ON RAJOUTE UN . DEVANT L'EXTENSION 
            $ext = "." . $ext; 
			// ON MET LA PHOTO DANS UN DOSSIER IMG
            $path = "./img/profile/" . $email . $ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], $path);
            $profilePhoto = $email . $ext;
        }
        $validate = updateProfiles($lastName, $Name, $Email, $pass, $profilePhoto, $Phone, $Job, $Company, $Town, $id);
        if ($validate == true) {
            header('Location:index.php?action=home');
        }
    }

}

	
	// MODIFIER UN GROUPE
function updateGroup($groupName,$newAdmin, $lastAdmin, $groupId)
{
    $groupPhoto = $_FILES['photo']['name'];
    $status = "member";
    if ($groupPhoto) {
        // ON SEPARE LE NOM DE L'IMAGE DE SON EXTENSION
        list($name, $ext) = explode(".", $groupPhoto);    
        // ON RAJOUTE UN . DEVANT L'EXTENSION 
        $ext = "." . $ext; 
        // ON MET LA PHOTO DANS UN DOSSIER IMG
        $path = "./img/groups/" . $groupName . $ext;
        move_uploaded_file($_FILES['photo']['tmp_name'], $path);
        $groupPhoto = $groupName . $ext;

    }
    updateGroups($groupName, $newAdmin,$lastAdmin,$status, $groupId, $groupPhoto);

    header('Location:index.php?action=groups');
}

//MODIFIER UN EVENEMENT
function modifyEvent($id, $title, $eventDate, $place)
{
    //VERIFIER SI LA VARIABLE place EST VIDE OU NON PUIS MODIFIER L'EVENEMENT
    if(isset($place)) {
        //AVEC place
        updateEvent($id, $title, $eventDate, $place);
    }
    else {
        //SANS place
        updateEvent($id, $title, $eventDate, "");
    }
    $_SESSION['erreur']="L'événement a bien été modifié.";
    eventView($_SESSION['id'], $id, 'admin');
}

function desactivateAccount($id, $active)
{
    if($active=="activated") {
        //DESACTIVER LE COMPTE
        updateActive($id, "disabled");
        $_SESSION['erreur']="Votre compte a bien été désactivé.";
    }
    else if($active=="disabled") {
        //ACTIVER LE COMPTE
        updateActive($id, "activated");
        $_SESSION['erreur']="Votre compte a bien été activé.";
    }
    header('Location:index.php?action=deleteView');
}
?>