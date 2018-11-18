<?php

function dbConnect() {
    try {
        $db = new PDO('mysql:host=localhost;dbname=network;charset=utf8', 'root', '');
    }
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
    return $db;
}

function checkUser($mail) {

	// ON SE CONNECTE
	$db = dbConnect();

	// ON SELECT LE MOT DE PASSE CORESPONDANT AU MAIL
	$selectUser = $db->prepare('SELECT password FROM users WHERE email = ?');
	$selectUser->execute(array($mail));
	$fetchSelectUser = $selectUser->fetch();
	$UserPassword = $fetchSelectUser['password'];

	// ON RETURN LE MOT DE PASSE
	return $UserPassword;
}

function addUser($lastName, $firstName, $email, $phone, $photo, $password, $status, $job, $company, $town) {

	// ON SE CONNECTE
	$db = dbConnect();

	// ON INSERT LES DONNES DANS LA BDD
	$insertUser = $db->prepare('INSERT INTO users (lastName, name, email, phone, photo, password, status, job, company, town)VALUES (?,?,?,?,?,?,?,?,?,?)');
	$insertUser->execute(array($lastName, $firstName, $email, $phone, $photo, $password, $status, $job, $company, $town));

	echo "vous etes inscrit!";
}


?>