<?php
//PAGE DE SUPPRESSION DE COMPTE 2
	if(isset($_POST['id']) && empty($_POST['id'])!==true)
	{
		session_start();
		require('../Model/bdd.php');
		$bdd=database();
		require('../Model/functions_delete.php');
		//A tester
		delete_account($bdd, $_SESSION['id']);
		header('location: ../index.php?page=logout');
	}
?>