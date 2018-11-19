<?php
require('./model/model.php');

//////////
// VIEW //
//////////

// INSCRIPTION
function showInscription(){
	require('./view/signIn.html');
}

// CONNECTION
function showConnection(){
	require('./view/connexion.html');
}

//////////////
// CONTROLS //
//////////////

// CHECK SI LE COMPTE EXISTE
function checkUserExists($email, $password){
	$userPassword = checkUser($email);

	if($userPassword === false){
		echo "votre compte n'existe pas!";
	} else {
		if(password_verify($password, $userPassword)){
			echo "le mot de passe est bon!";
		} else {
			echo "le compte existe mais mauvais mot de passe!";
		}
	}
}

// CHECK LES INFOS D'INSCRIPTION
function checkAddUser($lastName, $firstName, $email, $phone, $photo, $password, $status, $job, $company, $town){

	// ON CHECK SI LES DONNES SONT BONNES
	if(!empty($password)){
	
	// OPTIONS APPORTES AU HASH	
		$options = [
			'cost' => 12,
			'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		];

	// ON HASH LE MOT DE PASSE 
		$hashpassword = password_hash($password, PASSWORD_BCRYPT, $options);
	}

	// ON ENVOIE LES DONNES DANS LA BDD
	addUser($lastName, $firstName, $email, $phone, $photo, $hashpassword, $status, $job, $company, $town);
}

?>