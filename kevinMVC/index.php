<?php
session_start();
require('./controller/controller.php');

switch ($_GET['action']) {

    case 'checkUser':
        checkUserExists($_POST['email'],$_POST['password']);
        break;

    case 'addUser':
        checkAddUser($_POST['lastName'],$_POST['firstName'],$_POST['email'],$_POST['phone'],$_POST['photo'],$_POST['password'],$_POST['status'],$_POST['job'],$_POST['company'],$_POST['town']);
        break;

    case 'signIn':
        showInscription();
        break;

    case 'connexion':
        showConnection();
        break;
}

?>