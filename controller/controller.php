<?php
require('model/model.php');
// AFFICHE LA PAGE D'ACCUEIL ET EXÉCUTE LES FONCTIONS
function home($userId) {
	$profile = getProfile($userId);
	$contactsNb = getContactsCount($userId);
	if ($contactsNb>0) {
	$contactsPosts = getContactsPosts($userId);
	$companiesSuggests = getCompanySuggests($userId);
	$employeesSuggests = getEmployeeSuggests($userId);
	}
	$followedCompaniesNb = getFollowedCompaniesCount($userId);

	if($profile['status'] == "employee"){
		require('view/homeViewEmployee.php');
	}else{
		require('view/homeViewCompany.php');
	}
	// require('view/homeView.php');
}

function showMessages ($userId,$contactId) {
	$userProfile = getProfile($_SESSION['id']);
	$contacts = getContacts($userId);
	$reiceverProfile = getProfile($_POST['contactId']);
	if ($contacts) {
	$contactsFetch = $contacts->fetchAll(PDO::FETCH_ASSOC);
	for ($i=0;$i<count($contactsFetch);$i++) {
		$profile = getProfile($contactsFetch[$i]['id']);
		$contactProfile[$i] = $profile;
	}
	$messages = getMessages($userId,$contactId);
	require('./view/chatView.php');
	} else {
		echo("Vous n'avez aucun message");
	}
}

function addMessage($content,$contactId,$userId) {
	$message = sendMessage($content,$contactId,$userId);
	//if ($message) {
		header('Location:'.$_SERVER['HTTP_REFERER']);
//	}
}
function contactHome($contactId) {
	$profile = getProfile($contactId);
	$contactPosts = getContactPosts($contactId);
	$contactsNb = getContactsCount($contactId);
	$followedCompaniesNb = getFollowedCompaniesCount($contactId);
	require('view/profilepageView.php');	
}
function groups() {
	
}
function addPost($content,$type,$userId) {
	post($content,$type,$userId);
	header('Location:index.php?action=home');
}
function addComment($content,$userId,$postId) {
	comment($content,$userId,$postId);
	header('Location:index.php?action=home');
}
// CHECK SI LE COMPTE EXISTE
function checkUserExists($email, $password){

	// LE  SYSTÈME FAIT UNE PAUSE D'UNE SECONDE A CHAQUE TENTATIVE DE CONNEXION POUR EVITER UNE ATTAQUE PAR FORCE BRUTE
	sleep(1);

	// ON SECURISE LES DONNEES 
	$email = htmlspecialchars($email);
	$password = htmlspecialchars($password);
	$errors = array();

	$user= checkUser($email);

	if($user === false){
		$errors['compte'] = "votre compte n'existe pas !";
		require('view/signInView.php');		
	} else {
		if(password_verify($password, $user['password'])){
			$_SESSION['id'] = $user['id'];
			header('Location:index.php?action=home');
		} else { 
			$errors['wrongPassWord'] = "Les indentifiants saisis sont incorrects.";
			require('view/signInView.php');			
		}
	}
}

// CHECK LES INFOS D'INSCRIPTION
function checkAddUser($firstName, $lastName, $email, $phone, $password, $confirmPassword, $status, $job, $company, $town){

	$errors = array();

	// ON VERIFIE QUE LES DONNEES NE SOIT PAS VIDE
	if(empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword) || empty($status) || empty($job) || empty($company) || empty($town)){
		$errors['empty'] = "Verifier que les champs sont biens remplis";
		require('view/signUpView.php');
	}

	// ON SECURISE LES DONNEES 
	$firstName = htmlspecialchars($firstName);
	$lastName = htmlspecialchars($lastName);
	$email = htmlspecialchars($email);
	$phone = htmlspecialchars($phone);
	$password = htmlspecialchars($password);
	$confirmPassword = htmlspecialchars($confirmPassword);
	$status = htmlspecialchars($status);
	$job = htmlspecialchars($job);
	$company = htmlspecialchars($company);
	$town = htmlspecialchars($town);

	// ON CHECK SI LE MOT DE PASSE ET LA CONFIRMATION DU MOT DE PASSE SONT DIFFERENTE
	if($password != $confirmPassword){
		$errors['wrongPassWord'] = "Le mot de passe saisis est incorrecte";
		header('Location:index.php?action=signUp');
	}
	// ON CHECK SI LES DONNEÉS SONT BONNES
	if(!empty($password && $password == $confirmPassword)){	
	// OPTIONS APPORTES AU HASH	
		$options = ['cost' => 12];
	// ON HASH LE MOT DE PASSE 
		$hashpassword = password_hash($password, PASSWORD_BCRYPT, $options);

	
	// PHOTO
	$profilePhoto = $_FILES['photo']['name'];
	
	if($profilePhoto){
	// ON SEPARE LE NOM DE L'IMAGE DE SON EXTENSION
   	list($name, $ext) = explode(".", $profilePhoto);    
   	// ON RAJOUTE UN . DEVANT L'EXTENSION 
  	$ext=".".$ext; 
	// ON MET LA PHOTO DANS UN DOSSIER IMG
	$path = "./img/profile/".$email.$ext;
	move_uploaded_file($_FILES['photo']['tmp_name'],$path);
	$profilePhoto = $email.$ext; 
	}
	// ON ENVOIE LES DONNES DANS LA BDD
	addUser($firstName, $lastName, $email, $phone, $profilePhoto, $hashpassword, $status, $job, $company, $town); 
	require('view/signInView.php');
	
	}
}
	//FUNCTION RECHERCHE
	function search($ids,$data)
	{
		$ids = htmlspecialchars($ids);
		$data = htmlspecialchars($data);
		$res = getSearch($ids,$data);
		$contact = getContactToUser($ids);
		if(($res == TRUE) && (empty($contact))){
			require('./view/resultSearchView.php');
		} else if( ($res == TRUE) && (!empty($contact)) ){
			 require('./view/resultDetailSearchView.php');
		} else{
			require('./view/resultDetailSearchView.php');
		}
	}

	//FUNCTION AJOUT DE CONTACT
	function addToContacts($contactId,$userId)
	{
		$add = addContact($contactId,$userId);
		if($add == TRUE) 
		{
			header('Location:index.php?action=home');	
		}
	}
	
		//FUNCTION UNFOLLOW UN CONTACT
		function removeContact($contactId,$userId)
		{
			$unf = unfollow($contactId,$userId);
			if($unf == TRUE) 
			{
				header('Location:index.php?action=home');	
			}
		}
	// AFFICHER LES ENTREPRISES
	function showCompanies($id){
		$contacts = getContacts($id);

		foreach ($contacts as $contact) {
			$res[] = getProfile($contact['id']);
		
		}
		require("./view/showCompanies.php");
	}
	
	// AFFICHER LES CONTACTS
	function contactList($userId)
	{
		$list = getContacts($userId);
		if($list == TRUE) 
		{
			require('./view/contactsListView.php');		
		}
	}

	//FUNCTION AFFICHE LES INFOS A MODIFIER
	function updateToProfile($id)
	{
		$recup = getProfileUpdate($id);
		require('./view/profilUpdateView.php');
	}

	function getProfileSearch($id)
	{
		$recup = getProfileUpdate($id);
		require('./view/profilepageView.php');
	}

	// MODIFIER SON PROFIL
	function validateProfile($lastname,$name,$email,$pass,$confirmPass,$phone,$job,$company,$town,$id)
	{
		$lastName = htmlspecialchars($lastname);
		$Name = htmlspecialchars($name);
		$Email = htmlspecialchars($email);
		$Phone = htmlspecialchars($phone);
		$Job = htmlspecialchars($job);
		$Company = htmlspecialchars($company);
		$Town = htmlspecialchars($town);
		if($pass != $confirmPass){
			header('Location:index.php?action=updateProfile');
		}else{
			$validate = updateProfiles($lastName,$Name,$Email,$pass,$Phone,$Job,$Company,$Town,$id);
			if( $validate == TRUE )
			{
			header('Location:index.php?action=home');
			}
		}
		
	}

	// GROUPE
	function sessionGroup(){
		require("./view/homeGroup.php");
	}

	// SE DECONNECTER
	function disconnect() {
		session_destroy();
		header('Location:index.php');
	}

	// MONTRER LES CONTACTS
	function showContacts($id){
		$contacts = getContacts($id);
		foreach ($contacts as $contact) {
			$res[] = getProfile($contact['id']);
			
		}
		require("./view/showContacts.php");
	}

	//AFFICHER LA PAGE DE SUPPRESSION DE COMPTE
	function deleteView($id)
	{
		$profile=getProfile($id);
		$contactsNb=getContactsCount($id);
		if($contactsNb>0) {
			$contactsPosts=getContactsPosts($id);
			$companiesSuggests=getCompanySuggests($id);
			$employeesSuggests=getEmployeeSuggests($id);
		}
		$followedCompaniesNb=getFollowedCompaniesCount($id);
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
		include('view/showEvents.php');
	}

	//AFFICHER LA PAGE CREATION D'UN EVENEMENT
	function createEventView($id)
	{
		$profile=getProfile($id);
		$contactsNb=getContactsCount($id);
		if($contactsNb>0) {
			$contactsPosts=getContactsPosts($id);
			$companiesSuggests=getCompanySuggests($id);
			$employeesSuggests=getEmployeeSuggests($id);
		}
		$followedCompaniesNb=getFollowedCompaniesCount($id);


		include('view/createEventView.php');
	}

	//CREER UN EVENEMENT
	function createEvent($id, $title, $eventDate, $place)
	{
		//VERIFIER LE REMPLISSAGE DE LA SAISIE DE LA VARIABLE PLACE PUIS CREER L'EVENEMENT
		if(isset($place) && empty($place)!=true) {
			//AVEC LE CHAMP 'PLACE' REMPLI
			insertEvent($id, $title, $eventDate, $place);
		}
		else {
			//SANS LE CHAMP 'PLACE' REMPLI
			insertEvent($id, $title, $eventDate, "");
		}
		$_SESSION['erreur']="L'événement '".$title."' a bien été créé.";
		header('location: index.php?action=showEvents');
	}

	//AFFICHER LA PAGE PERSONNELLE DE L'EVENEMENT
	function eventView($ID, $id, $role)
	{
		$profile=getProfile($id);
		$contactsNb=getContactsCount($id);
		if($contactsNb>0) {
			$contactsPosts=getContactsPosts($id);
			$companiesSuggests=getCompanySuggests($id);
			$employeesSuggests=getEmployeeSuggests($id);
		}
		$followedCompaniesNb=getFollowedCompaniesCount($id);
		$event=infoEvent($id);
		$admin=checkAdmin($id);
		$participate=checkParticipate($id);
		include('view/eventView.php');
	}

	//SUPPRIMER LA PARTICIPATION D'UN UTILISATEUR
	function quitEvent($ID, $id, $role)
	{
		//SUPPRIMER LA PARTICIPATION DE L'UTILISATEUR DANS CET EVENEMENT
		deleteParticipate($ID, $id);
		if($_GET['role']=='participate') {
			$_SESSION['erreur']="Vous vous êtes bien retiré de l'événement.";
			header('location: index.php?action=showEvents');
		}
		else if($_GET['role']=='admin') {
			$_SESSION['erreur']="Vous avez bien retiré la participation de cette personne dans cet événement.";
			header('location: index.php?action=eventView&id='.$id.'&role=admin');
		}
	}

	//SUPPRIMER UN EVENEMENT
	function removeEvent($id)
	{
		//SUPPRIMER L'EVENEMENT
		deleteEvent($_GET['id']);
		$_SESSION['erreur']="Vous avez supprimé cet événement avec succès.";
		header('location: index.php?action=showEvents');
	}

	//AFFICHER LA PAGE DE MODIFICATION D'UN EVENEMENT
	function updateEventView($id)
	{
	   $event=infoEvent($id);
	   include('view/updateEventView.php');
	}

	//MODIFIER UN EVENEMENT
	function modifyEvent($id, $title, $eventDate, $place)
	{
		//VERIFIER LSI LA VARIABLE place EST VIDE OU NON PUIS MODIFIER L'EVENEMENT
		if(isset($place)) {
			//AVEC place
			updateEvent($id, $title, $eventDate, $place);
		}
		else {
			//SANS place
			updateEvent($id, $title, $eventDate, "");
		}
		header('location: index.php?action=eventView&id='.$id.'&role=admin');
	}

	//AFFICHER LA PAGE D'AJOUT DE PARTICIPATION
	function addParticipateView($ID, $id)
	{
		$contact=infoContact($ID, $id);
		include('view/addParticipateView.php');
	}

	//AJOUTER DES PARTICIPATIONS A UN EVENEMENT
	function addParticipate($contact, $id)
	{
		//VERIFIER QU'IL Y A AU MOINS UNE CASE COCHEE
		if(isset($contact)) {
			//AJOUTER LES CONTACTS DANS L'EVENEMENT
			foreach($contact as $valeur) {
			   insertParticipate($valeur, $id);
			}
			$_SESSION['erreur']="Vos contacts ont bien été ajouté à votre événement.";
			header('location: index.php?action=eventView&id='.$id.'&role=admin');
		}
		else {
			$_SESSION['erreur']="Vous n'avez sélectionné aucun contact à ajouter aux participants de votre événement.";
			header('location: index.php?action=addParticipateView&id='.$id);
		}
	}

	/*function joinInvitation($id)
	{
		if() {
		}
		else {

		}
	}

	function declineInvitation($id)
	{
		if() {
		}
		else {

		}
	}*/