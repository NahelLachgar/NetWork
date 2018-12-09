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
	require('view/homeView.php');
}

function contactHome($contactId) {
	$profile = getProfile($contactId);
	$contactPosts = getContactPosts($contactId);
	$contactsNb = getContactsCount($contactId);
	$followedCompaniesNb = getFollowedCompaniesCount($contactId);
	require('view/profilepageView.php');	
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

	// ON UTILISE SLEEP POUR EVITER UNE ATTAQUE PAR FORCE BRUTE
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

	// ON VERIFIE QUE LES DONNEES NE SOIT PAS VIDE
	if(empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword) || empty($status) || empty($job) || empty($company) || empty($town)){
		require('view/signUpView.html');
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
			require('./view/resultatSearchView.php');
		} else if( ($res == TRUE) && (!empty($contact)) ){
			 require('./view/resultatDetailSearchView.php');
		} else{
			echo "Aucun resultat";
		}
	}

	//FUNCTION AJOUT DE CONTACT
	function addToContacts($idcontact,$sid)
	{
		$add = addContact($idcontact,$sid);
		if($add == TRUE) 
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
	function contactList($sid)
	{
		$list = getContacts($sid);
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