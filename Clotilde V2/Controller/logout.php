<?php
	//déconnexion
	session_unset();
	session_destroy();
	//retour page accueil
	header('location: index.php');
?>