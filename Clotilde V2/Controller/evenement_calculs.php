<?php
//FONCTONNALITES D'UNE PAGE D'EVENEMENTS
	session_start();
	if(isset($_SESSION['id']) && empty($_SESSION['id'])!=true && isset($_POST['function'])) {
		switch($_POST['function']):
            case 'create';
            	if(isset($_POST['title']) && empty($_POST['title'])!=true && isset($_POST['eventDate']) && empty($_POST['eventDate'])!=true) {
					require('../Model/bdd.php');
					$bdd=database();
					require('../Model/functions_events.php');
					//vérifier le remplissage de la saisie de la variable place puis créer l'événement
					if(isset($_POST['place']) && empty($_POST['place'])!=true) {
						//avec le champ 'place' rempli
						create($bdd, $_SESSION['id'], $_POST['title'], $_POST['eventDate'], $_POST['place']);
					}
					else {
						//sans le champ 'place' rempli
						create($bdd, $_SESSION['id'], $_POST['title'], $_POST['eventDate'], "");
					}
					$_SESSION['erreur']="L'événement '".$_POST['title']."' a bien été créé.";
				}
				else {
					$_SESSION['erreur']="Erreur. Impossible de créer un événement sans les données nécessaires à sa création.";
				}
				header('location: ../index.php?page=evenement');
            	break;
            case 'quit';
            	if(isset($_POST['id']) && empty($_POST['id'])!=true && isset($_POST['ID']) && empty($_POST['ID'])!=true && isset($_POST['role']) && empty($_POST['role'])!=true) {
					require('../Model/bdd.php');
					$bdd=database();
					require('../Model/functions_events.php');
					if($_POST['role']=='participate') {
						//supprimer la participation de l'utilisateur dans cet événement
						quit($bdd, $_POST['ID'], $_POST['id']);
						$_SESSION['erreur']="Vous vous êtes bien retiré de l'événement.";
						header('location: ../index.php?page=evenement');
					}
					else if($_POST['role']=='admin') {
						//supprimer la participation de l'utilisateur dans cet événement
						quit($bdd, $_POST['ID'], $_POST['id']);
						$_SESSION['erreur']="Vous avez bien retiré la participation de cette personne dans cet événement.";
						header('location: ../index.php?page=show_event&id='.$_POST['id'].'&role=admin');
					}
				}
				else {
					$_SESSION['erreur']="Erreur. Impossible d'effectuer cette manoeuvre sans les données nécessaires pour la réaliser.";
					header('location: ../index.php?page=evenement');
				}
            	break;
            case 'delete';
            	if(isset($_POST['id']) && empty($_POST['id'])!=true) {
					require('../Model/bdd.php');
					$bdd=database();
					require('../Model/functions_events.php');
					//supprimer l'événement
					delete($bdd, $_POST['id']);
					$_SESSION['erreur']="Vous avez supprimé cet événement avec succès.";
				}
				else {
					$_SESSION['erreur']="Erreur. Impossible d'effectuer cette manoeuvre sans les données nécessaires pour la réaliser.";
				}
				header('location: ../index.php?page=evenement');
            	break;
            case 'update';
            	if(isset($_POST['id']) && empty($_POST['id'])!=true && isset($_POST['title']) && empty($_POST['title'])!=true && isset($_POST['eventDate']) && empty($_POST['eventDate'])!=true) {
					require('../Model/bdd.php');
					$bdd=database();
					require('../Model/functions_events.php');
					//vérifier remplissage de la saisie de la variable place puis modifier l'événement
					if(isset($_POST['place'])) {
						//avec le champ 'place' rempli
						update($bdd, $_POST['id'], $_POST['title'], $_POST['eventDate'], $_POST['place']);
					}
					else {
						//sans le champ 'place' rempli
						update($bdd, $_POST['id'], $_POST['title'], $_POST['eventDate'], "");
					}
					header('location: ../index.php?page=show_event&id='.$_POST['id'].'&role=admin');
				}
				else {
					$_SESSION['erreur']="Erreur. Impossible d'effectuer cette manoeuvre sans les données nécessaires pour la réaliser.";
					header('location: ../index.php?page=evenement');
				}
            	break;
            case 'add';
            	if(isset($_POST['id']) && empty($_POST['id'])!=true) {
					require('../Model/bdd.php');
					$bdd=database();
					require('../Model/functions_events.php');
					//vérifier qu'il y a bien au moins une case cochée
					if(isset($_POST['contact'])) {
						//ajouter les contacts en tant que participants à l'événement
						foreach($_POST['contact'] as $valeur) {
						   add($bdd, $valeur, $_POST['id']);
						}
						$_SESSION['erreur']="Vos contacts ont bien été ajouté à votre événement.";
						header('location: ../index.php?page=show_event&id='.$_POST['id'].'&role=admin');
					}
					else {
						$_SESSION['erreur']="Vous n'avez sélectionné aucun contact à ajouter aux participants de votre événement.";
						header('location: ../index.php?page=add_event&id='.$_POST['id']);
					}
				}
				else {
					$_SESSION['erreur']="Erreur. Impossible d'effectuer cette manoeuvre sans les données nécessaires pour la réaliser.";
					header('location: ../index.php?page=evenement');
				}
            	break;
            case 'join';
            	/*if(isset($_POST['title']) && empty($_POST['title'])!=true && isset($_POST['eventDate']) && empty($_POST['eventDate'])!=true) {
					require('../Model/bdd.php');
					$bdd=database();
					require('../Model/functions_events.php');
					//vérification du remplissage de la saisie de la variable place puis création de l'événement
					if(isset($_POST['place']) && empty($_POST['place'])!=true) {
						create($bdd, $_SESSION['id'], $_POST['title'], $_POST['eventDate'], $_POST['place']);
					}
					else {
						createNoPlace($bdd, $_SESSION['id'], $_POST['title'], $_POST['eventDate']);
					}
				}
				else {
	
				}*/
            	break;
            case 'decline';
            	/*if(isset($_POST['title']) && empty($_POST['title'])!=true && isset($_POST['eventDate']) && empty($_POST['eventDate'])!=true) {
					require('../Model/bdd.php');
					$bdd=database();
					require('../Model/functions_events.php');
					//vérification du remplissage de la saisie de la variable place puis création de l'événement
					if(isset($_POST['place']) && empty($_POST['place'])!=true) {
						create($bdd, $_SESSION['id'], $_POST['title'], $_POST['eventDate'], $_POST['place']);
					}
					else {
						createNoPlace($bdd, $_SESSION['id'], $_POST['title'], $_POST['eventDate']);
					}
				}
				else {
	
				}*/
            	break;
            default:
                header('location: ../index.php');
        endswitch;
	}
	else {
        header('location: ../index.php');
    }
?>