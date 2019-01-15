<?php
include_once('controller/insertController.php');
include_once('controller/deleteController.php');
include_once('controller/updateController.php');
include_once('model/insertModel.php');
include_once('model/updateModel.php');
include_once('model/deleteModel.php');
include_once('model/selectModel.php');
// AFFICHE LA PAGE D'ACCUEIL ET EXÉCUTE LES FONCTIONS

function home($userId) {
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
	$status = checkStatus($userId);
	if($profile['status'] == "employee"){
		include_once('view/homeViewEmployee.php');
	}else{
		include_once('view/homeViewCompany.php');
	}
}

function showMessages ($userId,$contactId) {
	$groups = getGroupsName($userId);
	$userProfile = getProfile($userId);
    $contacts = getContacts($userId);
    $contactsFetch = $contacts -> fetch();
    $contactsFetch = $contacts->fetchAll(PDO::FETCH_ASSOC);
    if ($contactsFetch) {
    $receiverProfile = getProfile($_GET['contactId']);
	for ($i=0;$i<count($contactsFetch);$i++) {
		$profile = getProfile($contactsFetch[$i]['id']);
		$contactProfile[$i] = $profile;
	}
	$messages = getMessages($userId,$contactId);
	$status = checkStatus($userId);
	include_once('./view/chatView.php');
	} else {
		echo('Vous n\'avez aucun message.<br><a href="index.php?action=home">Retour</a>');
	}
}
function showGroupMessages ($userId,$groupId) {
	$groups = getGroupsName($userId);
	$userProfile = getProfile($userId);
	$contacts = getContacts($userId);
	$receiverProfile = getProfile($_GET['contactId']);

	$contactsFetch = $contacts->fetchAll(PDO::FETCH_ASSOC);
	for ($i=0;$i<count($contactsFetch);$i++) {
		$profile = getProfile($contactsFetch[$i]['id']);
		$contactProfile[$i] = $profile;
	}
	$groupMessages = getGroupsMessages($groupId);
	$status = checkStatus($userId);
	include_once('./view/groupChatView.php');
}

function contactHome($id,$contactId,$token) {
	$profile = getProfile($contactId);
	$contactPosts = getUserPosts($contactId);
	$contactsNb = getContactsCount($contactId);
	$followedCompaniesNb = getFollowedCompaniesCount($contactId);
	$status = checkStatus($id);
	$pass = $token;
	include_once('view/profilePageView.php');	
}
//BARRE DE RECHERCHE
function search($ids,$data)
{
    $ids = htmlspecialchars($ids);
    $data = htmlspecialchars($data);
    $res = getSearch($ids,$data);
    $contact = getContactToUser($ids);
    $status = checkStatus($ids);
    if(($res == TRUE) && (empty($contact))){
        include_once('./view/resultSearchView.php');
    } else if( ($res == TRUE) && (!empty($contact)) ){
         include_once('./view/resultDetailSearchView.php');
    } else{
        include_once('./view/resultDetailSearchView.php');
    }
}
// AFFICHER LES ENTREPRISES
function showCompanies($id){
    $contacts = getContacts($id);

    foreach ($contacts as $contact) {
        $res[] = getProfile($contact['id']);
    
    }
    $status = checkStatus($id);
    include_once("./view/showCompanies.php");
}

// AFFICHER LES CONTACTS
function contactList($userId)
{
    $list = getContacts($userId);
    $status = checkStatus($userId);
    if($list == TRUE) 
    {
        include_once('./view/contactsListView.php');		
    }
}
// GROUPE
function sessionGroup($id) {
    $status = checkStatus($id);
    $groups = getGroups($id);
    $adminGroup = getAdminGroup($id);
    include_once('./view/homeGroup.php');
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
    $status = checkStatus($id);
    $admin = getProfile($members['0']['admin']);
    include_once('./view/membersGroupView.php');
}

// MONTRER LES CONTACTS
function showContacts($id){
    $contacts = getContacts($id);
    foreach ($contacts as $contact) {
        $res[] = getProfile($contact['id']);
        
    }
    $status = checkStatus($id);
    include_once("./view/showContacts.php");
}
//AFFICHER LA PAGE DES EVENEMENTS
function showEvents($id)
{
    $profile=getProfile($id);
    $contactsNb=getContactsCount($id);
    if($contactsNb>0) {
        $contactsPosts=getContactsPosts($id);
        $companiesSuggests=getCompanySuggests($id);
        $employeesSuggests=getEmployeeSuggests($id);
    }
    $followedCompaniesNb=getFollowedCompaniesCount($id);
    $role=2;
    $admin=selectAdmin($id);
    $event=selectMember($id);
    //$invit=selectInvit($id, 'event');
    $status=checkStatus($id);
    include('view/showEvents.php');
}
//AFFICHER LA PAGE PERSONNELLE DE L'EVENEMENT
function eventView($ID, $id, $role)
{
    $profile=getProfile($ID);
    $contactsNb=getContactsCount($ID);
    if($contactsNb>0) {
        $contactsPosts=getContactsPosts($ID);
        $companiesSuggests=getCompanySuggests($ID);
        $employeesSuggests=getEmployeeSuggests($ID);
    }
    $followedCompaniesNb=getFollowedCompaniesCount($ID);
    $event=infoEvent($id);
    $admin=checkAdmin($id);
    $participate=checkParticipate($id);
    /*
    if($role=='participate') {
        $invit=invitation($ID, $id, 'event');
    }
    */
    $status=checkStatus($ID);
    include('view/eventView.php');
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
		include_once('view/signInView.php');		
	} else {
		if(password_verify($password, $user['password'])){
			$_SESSION['id'] = $user['id'];
			header('Location:index.php?action=home');
		} else { 
			$errors['wrongPassWord'] = "Les identifiants saisis sont incorrects.";
			include_once('view/signInView.php');			
		}
	}
}

//AFFICHER LA PAGE CREATION D'UN EVENEMENT
function createEventView($id, $role)
{
    $status=checkStatus($id);
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
    $status = checkStatus($ID);
    include('view/updateEventView.php');
}

//AFFICHER LA PAGE D'AJOUT DE PARTICIPATION
function addParticipateView($ID, $id)
{
    $contact=infoContact($ID, $id);
    $status=checkStatus($ID);
    include('view/addParticipateView.php');
}
?>