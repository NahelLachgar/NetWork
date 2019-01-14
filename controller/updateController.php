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
function updateGroup($groupName, $admin, $groupId)
{
    $groupPhoto = $_FILES['photo']['name'];
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
    updateGroups($groupName, $admin, $groupId, $groupPhoto);

    header('Location:index.php?action=groups');
}
    //AFFICHER LA PAGE DE MODIFICATION D'UN EVENEMENT
function updateEventView($ID, $id)
{
    $event = infoEvent($id);
    $status = checkStatus($ID);
    include('view/updateEventView.php');
}

	//MODIFIER UN EVENEMENT
function modifyEvent($id, $title, $eventDate, $place)
{
		//VERIFIER LSI LA VARIABLE place EST VIDE OU NON PUIS MODIFIER L'EVENEMENT
    if (isset($place)) {
			//AVEC place
        updateEvent($id, $title, $eventDate, $place);
    } else {
			//SANS place
        updateEvent($id, $title, $eventDate, "");
    }
    eventView($_SESSION['id'], $id, 'admin');
}
function groupManage($groupId,$id) {
    $idGroup = $groupId;
    $members = selectContactGroup($groupId);
    for($i = 0; $i < count($members); $i++) {
        $memberProfile[] = getProfile($members[$i]['user']);
    }
    foreach( $memberProfile as $member){
        $res[] = $member;
    }
    $status = checkStatus($id);
    $group = getGroup($groupId);
    require_once('./view/manageGroupView.php');
}

?>