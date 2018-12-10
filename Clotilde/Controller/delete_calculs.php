<?php
//PAGE DE SUPPRESSION DE COMPTE 2
	session_start();
	if(isset($_SESSION['id']) && empty($_SESSION['id'])!==true)
	{
		require('../Model/model.php');
		$bdd=dbconnect();
		require('../Model/functions_delete.php');
		//SUPPRIMER COMPTE
		//supprimer commentaires
		delete_all_coms($bdd, $_SESSION['id']);
		//supprimer publications
		delete_all_publi($bdd, $_SESSION['id']);
		//supprimer messages
		delete_all_messages($bdd, $_SESSION['id']);
		//supprimer evenements
		delete_all_events($bdd, $_SESSION['id']);
		//supprimer groupes
		delete_all_groups($bdd, $_SESSION['id']);
		//supprimer contacts
		delete_all_contacts($bdd, $_SESSION['id']);
		//supprimer l'utilisateur
		delete_user($bdd, $_SESSION['id']);
		header('location: ../index.php?page=disconnect');
	}
	else
    {
        header('location: ../index.php');
    }
?>