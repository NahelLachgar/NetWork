<?php
	function database()
	{
		$bdd=new PDO('mysql:host=localhost;dbname=NetWork;charset=UTF8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		return $bdd;
	}
?>