<?php
require('model/model.php');

// AFFICHE LA PAGE D'ACCUEIL ET EXÉCUTE LES FONCTIONS
function home($userId) {
$contactPosts = getContactPosts($userId);
$profile = getProfile($userId);
$companySuggests = getCompanySuggests($userId);
$employeeSuggests = getEmployeeSuggests($userId);
$contactsNb = getContactsCount($userId);
$followedCompaniesNb = getFollowedCompaniesCount($userId);
require('view/homeView.php');
}

// CHECK SI LE COMPTE EXISTE
function checkUserExists($email, $password){
	$userPassword = checkUser($email);

	if($userPassword === false){
		echo "votre compte n'existe pas!";
	} else {
		if(password_verify($password, $userPassword)){
			require('view/homeView.php');
		} else {
			die ("Les indentifiants saisis sont incorrects");
		}
	}
}

// CHECK LES INFOS D'INSCRIPTION
function checkAddUser($firstName, $lastName,$email, $phone, $photo, $password, $status, $job, $company, $town){

	// ON CHECK SI LES DONNES SONT BONNES
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