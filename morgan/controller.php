<?php
require('model/model.php');

// AFFICHE LA PAGE D'ACCUEIL ET EXÉCUTE LES FONCTIONS
function home($userId) {
	$profile = getProfile($userId);
	$contactsPosts = getContactsPosts($userId);
	$companySuggests = getCompanySuggests($userId);
	$employeeSuggests = getEmployeeSuggests($userId);
	$contactsNb = getContactsCount($userId);
	$followedCompaniesNb = getFollowedCompaniesCount($userId);
	require('view/homeView.php');
}

function addPost($content,$type,$userId) {
	post($content,$type,$userId);
	header('Location:index.php?action=home');
}

// CHECK SI LE COMPTE EXISTE
function checkUserExists($email, $password){
	$user= checkUser($email);

	if($user['email'] === false){
		echo "votre compte n'existe pas!";
	} else {
		if(password_verify($password, $user['password'])){
			$_SESSION['id'] = $user['id'];
			header('Location:index.php?action=home');
		} else {
			require('view/signInView.html');
			die ("Les indentifiants saisis sont incorrects");
		}
	}
}

// CHECK LES INFOS D'INSCRIPTION
function checkAddUser($firstName, $lastName,$email, $phone, $photo, $password, $status, $job, $company, $town){

	// ON CHECK SI LES DONNEÉS SONT BONNES
	if(!empty($password)){
	
	// OPTIONS APPORTES AU HASH	
		$options = ['cost' => 12];

	// ON HASH LE MOT DE PASSE 
		$hashpassword = password_hash($password, PASSWORD_BCRYPT, $options);
	}

	// ON ENVOIE LES DONNES DANS LA BDD
    addUser($firstName, $lastName, $email, $phone, $photo, $hashpassword, $status, $job, $company, $town);
    require('view/signInView.html');
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
	function addToContact($idcontact,$sid)
	{
		$add = addContact($idcontact,$sid);
		if($add == TRUE) 
		{
			header('Location:index.php?action=home');	
		}
	}

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

	//
	function validateProfile($lastname,$name,$email,$pass,$phone,$job,$company,$town,$id)
	{
		$lastName = htmlspecialchars($lastname);
		$Name = htmlspecialchars($name);
		$Email = htmlspecialchars($email);
		$Phone = htmlspecialchars($phone);
		$Job = htmlspecialchars($job);
		$Company = htmlspecialchars($company);
		$Town = htmlspecialchars($town);
		$validate = updateProfiles($lastName,$Name,$Email,$pass,$Phone,$Job,$Company,$Town,$id);
		if( $validate == TRUE )
		{
			header('Location:index.php?action=home');
		}
	}