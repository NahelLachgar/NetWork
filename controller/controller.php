<?php
require('model/model.php');

// AFFICHE LA PAGE D'ACCUEIL ET EXÉCUTE LES FONCTIONS
function home($userId) {
	$profile = getProfile($userId);
	$contactPosts = getContactPosts($userId);
	$companySuggests = getCompanySuggests($userId);
	$employeeSuggests = getEmployeeSuggests($userId);
	$contactsNb = getContactsCount($userId);
	$followedCompaniesNb = getFollowedCompaniesCount($userId);
	require('view/homeView.php');
}

// CHECK SI LE COMPTE EXISTE
function checkUserExists($email, $password){
	$user= checkUser($email);

	if($user['email'] === false){
		echo "votre compte n'existe pas!";
	} else {
		if(password_verify($password, $user['password'])){
			$_SESSION['id'] = $user['id'];
			echo $user['id'];
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
	function search($data)
	{
		$res = getSearch($data);
		if($res == TRUE){
			require('./view/resultatSearchView.php');
		} else {
			$return = "Aucun resultat trouve";
			//ON REVERIFIE SI $RES N'EST PAS VIDE DANS LA PAGE CI-DESSOUS 
			require('./view/resultatSearchView.php');
		}
	}