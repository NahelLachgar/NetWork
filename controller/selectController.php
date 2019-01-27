<?php
require_once('controller/insertController.php');
require_once('controller/deleteController.php');
require_once('controller/updateController.php');
require_once('model/insertModel.php');
require_once('model/updateModel.php');
require_once('model/deleteModel.php');
require_once('model/selectModel.php');
// AFFICHE LA PAGE D'ACCUEIL ET EXÉCUTE LES FONCTIONS
function home($userId,$errorExt) {
	$profile = getProfile($userId);
    $contactsNb = getContactsCount($userId);
    
        $contactsPosts = getContactsPosts($userId);

   
    if ($contactsNb>0) {
    $companiesSuggests = getCompanySuggests($userId);
    $employeesSuggests = getEmployeeSuggests($userId);
    } 
    else {
        $userPosts = getUserPosts($userId);
    }
    $followedCompaniesNb = getFollowedCompaniesCount($userId);
    if($profile['status'] == "employee"){
        require_once('view/homeViewEmployee.php');
    }else{
        require_once('view/homeViewCompany.php');
    }
}

function getProfileSearch($id)
{
    $recup = getProfileUpdate($id);
    require_once('./view/profilePageView.php');
}

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
    require_once('./view/profilUpdateView.php');
}

function showMessages ($userId,$contactId) {
    $profile=getProfile($userId);
   $groups = getGroupsName($userId);
    $userProfile = getProfile($userId);
    $contacts = getContacts($userId);
    $contactsFetch = $contacts->fetchAll(PDO::FETCH_ASSOC);
    if ($contactsFetch) {
    $receiverProfile = getProfile($_GET['contactId']);
    for ($i=0;$i<count($contactsFetch);$i++) {
        $profile = getProfile($contactsFetch[$i]['id']);
        $contactProfile[$i] = $profile;
    }
    $messages = getMessages($userId,$contactId);
    require_once('./view/chatView.php');
    } else {
        $title="messages";
        $content = '<center>Vous n\'avez aucun contact.<br><a href="index.php?action=home">Retour</a></center>';
        require('view/template.php');
    }
}

function showGroupMessages ($userId,$groupId) {
    $profile=getProfile($userId);
	$groups = getGroupsName($userId);
	$userProfile = getProfile($userId);
    $contacts = getContacts($userId);
    $contactsFetch = $contacts->fetchAll(PDO::FETCH_ASSOC);
    if ($contactsFetch) {
    $receiverProfile = getProfile($_GET['contactId']);
	for ($i=0;$i<count($contactsFetch);$i++) {
		$profile = getProfile($contactsFetch[$i]['id']);
		$contactProfile[$i] = $profile;
	}
	$messages = getGroupMessages($userId,$groupId);
	require_once('./view/groupChatView.php');
	} else {
        $title="messages";
        $content = '<center>Vous n\'avez aucun contact.<br><a href="index.php?action=home">Retour</a></center>';
        require('view/template.php');
	}
}

function contactHome($id,$contactId,$token) {
	$profile = getProfile($contactId);
	$contactPosts = getUserPosts($contactId);
	$contactsNb = getContactsCount($contactId);
	$followedCompaniesNb = getFollowedCompaniesCount($contactId);
	$pass = $token;
    $stateSearch = checkActive($contactId);
	require_once('view/profilePageView.php');
}

//BARRE DE RECHERCHE
function search($ids,$data)
{
    $profile=getProfile($ids);
    $contactsNb=getContactsCount($ids);
    if($contactsNb>0) {
        $contactsPosts=getContactsPosts($ids);
        $companiesSuggests=getCompanySuggests($ids);
        $employeesSuggests=getEmployeeSuggests($ids);
    }
    $followedCompaniesNb=getFollowedCompaniesCount($ids);
    $ids = htmlspecialchars($ids);
    $data = htmlspecialchars($data);
    $res = getSearch($ids,$data);
    $contact = getContactToUser($ids);
    if(($res == TRUE) && (empty($contact))){
        require_once('./view/resultSearchView.php');
    } else if( ($res == TRUE) && (!empty($contact)) ){
         require_once('./view/resultDetailSearchView.php');
    } else{
        require_once('./view/resultDetailSearchView.php');
    }
}

// AFFICHER LES ENTREPRISES
function showCompanies($id){
    $profile=getProfile($id);
    $contactsNb=getContactsCount($id);
    if($contactsNb>0) {
        $contactsPosts=getContactsPosts($id);
        $companiesSuggests=getCompanySuggests($id);
        $employeesSuggests=getEmployeeSuggests($id);
    }
    $followedCompaniesNb=getFollowedCompaniesCount($id);
    $contacts = getContacts($id);

    foreach ($contacts as $contact) {
        $res[] = getProfile($contact['id']);
    
    }
    require_once("./view/showCompanies.php");
}

// GROUPE
function sessionGroup($id) {
    $profile=getProfile($id);
    $contactsNb=getContactsCount($id);
    if($contactsNb>0) {
        $contactsPosts=getContactsPosts($id);
        $companiesSuggests=getCompanySuggests($id);
        $employeesSuggests=getEmployeeSuggests($id);
    }
    $followedCompaniesNb=getFollowedCompaniesCount($id);
    $groups = getGroups($id);
    $adminGroup = getAdminGroup($id);
    require_once('./view/homeGroup.php');
}

// AFFICHAGE GROUPE
function groupManage($groupId,$admin,$id) {
    $profile=getProfile($id);
    $adminG = $admin;
    $contactsNb=getContactsCount($id);
    $res = [];

    if($contactsNb>0) {
        $contactsPosts=getContactsPosts($id);
        $companiesSuggests=getCompanySuggests($id);
        $employeesSuggests=getEmployeeSuggests($id);
    }
    
    $followedCompaniesNb=getFollowedCompaniesCount($id);
    $idGroup = $groupId;
    $members = selectContactGroup($groupId);
    
    if (!empty($members)){
        for($i = 0; $i < count($members); $i++) {
            $memberProfile[] = getProfile($members[$i]['user']);
        }
        foreach( $memberProfile as $member){
            $res[] = $member;
        }
    }

    $group = getGroup($groupId);
    
    $contacts = getContacts($id);
    $contact = $contacts->fetchAll();
    $contactProfile = [];

    if (!empty($members)){
        if(count($res) != count($contact)){
            foreach ($res as $member){
                for($i = 0; $i < count($contact); $i++){
                    if($contact[$i]['id'] == $member['id']){
                        unset($contact[$i]); 
                        $contact = array_values($contact);
                    }
                }
            }

            for($i = 0; $i < count($contact); $i++) {
                $contactProfile[] = getProfile($contact[$i]['id']);
            }
        }
    } else {
        for($i = 0; $i < count($contact); $i++) {
            $contactProfile[] = getProfile($contact[$i]['id']);
        }
    }

    require_once('./view/manageGroupView.php');
}

//SELECTIONNE TOUS LES GROUPES DONT L'USER FAIT PARTI
function getGroupsContact($userId){
    $groups = getGroups($userId);
}

//AFFICHE LES MEMBRES D'UN GROUPE
function getMembersToGroups($groupId,$id){
    $idGroup = $groupId;
    $members = selectContactGroup($groupId);
    for($i = 0; $i < count($members); $i++) {
        $memberProfile[] = getProfile($members[$i]['user']);
    }
    foreach( $memberProfile as $member){
        $res[] = $member;
    }
    $group = getGroup($groupId);
    $admin = getProfile($members['0']['admin']);
    require_once('./view/membersGroupView.php');
}

// MONTRER LES CONTACTS
function showContacts($id){
    $profile=getProfile($id);
    $contactsNb=getContactsCount($id);
    if($contactsNb>0) {
        $contactsPosts=getContactsPosts($id);
        $companiesSuggests=getCompanySuggests($id);
        $employeesSuggests=getEmployeeSuggests($id);
    }
    $followedCompaniesNb=getFollowedCompaniesCount($id);
    $contacts = getContacts($id);
    foreach ($contacts as $contact) {
        $res[] = getProfile($contact['id']);
        
    }
    require_once("./view/showContacts.php");
}

// CHECK SI LE COMPTE EXISTE
function checkUserExists($email, $password){

	// LE  SYSTÈME FAIT UNE PAUSE D'UNE SECONDE A CHAQUE TENTATIVE DE CONNEXION POUR EVITER UNE ATTAQUE PAR FORCE BRUTE
	sleep(1);

	// ON SECURISE LES DONNEES 
	$email = htmlspecialchars($email);
	$password = htmlspecialchars($password);
	$errors = array();

	$user = checkUser($email);

	if($user === false){
		$errors['compte'] = "Votre compte n'existe pas !";
		require_once('view/signInView.php');		
	} else {
		if(password_verify($password, $user['password'])){
            $_SESSION['id'] = $user['id'];
            $_SESSION['status'] = $user['status'];
            $_SESSION['state'] = $user['active'];
			header('Location:index.php?action=home');
		} else { 
			$errors['wrongPassWord'] = "Les identifiants saisis sont incorrects.";
			require_once('view/signInView.php');			
		}
	}
}

function showNotifs() {
    $notifs = getNotifs();
    require_once('view/notificationsView.php');
}

//AFFICHER LA PAGE DES EVENEMENTS
function showEvents($id)
{
    $profile = getProfile($id);
    $contactsNb = getContactsCount($id);
    if($contactsNb > 0) {
        $contactsPosts = getContactsPosts($id);
        $companiesSuggests = getCompanySuggests($id);
        $employeesSuggests = getEmployeeSuggests($id);
    }
    $followedCompaniesNb = getFollowedCompaniesCount($id);
    $role = 2;
    $admin = selectAdmin($id);
    $event = selectMember($id);
    include('view/showEvents.php');
}
//AFFICHER LA PAGE PERSONNELLE DE L'EVENEMENT
function eventView($ID, $id, $role)
{
    $profile = getProfile($ID);
    $contactsNb = getContactsCount($ID);
    if($contactsNb > 0) {
        $contactsPosts = getContactsPosts($ID);
        $companiesSuggests = getCompanySuggests($ID);
        $employeesSuggests = getEmployeeSuggests($ID);
    }
    $followedCompaniesNb = getFollowedCompaniesCount($ID);
    $event = infoEvent($id);
    $admin = checkAdmin($id);
    $participate = checkParticipate($id);
    include('view/eventView.php');
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
    include('view/deleteView.php');
}

//AFFICHER LA PAGE CREATION D'UN EVENEMENT
function createEventView($id, $role)
{
    if($role=='admin') {
        include('view/createEventView.php');
    }
    else
    {
        header('location: index.php?action=showEvents');
    }
}

//AFFICHER LA PAGE DE MODIFICATION D'UN EVENEMENT
function updateEventView($ID, $id)
{
    $event = infoEvent($id);
    include('view/updateEventView.php');
}

//AFFICHER LA PAGE D'AJOUT DE PARTICIPATION
function addParticipateView($ID, $id)
{
    $contact = infoContact($ID, $id);
    include('view/addParticipateView.php');
}
?>