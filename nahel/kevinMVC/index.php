<?php
session_start();
require('controller/controller.php');
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'connect':
                login($_POST['nom'], $_POST['prenom']);
                break;
            case 'disconnect':
                disconnect();
                break;
            case 'home':
                home($_SESSION['id']);
                break;

            case 'checkUser':
                checkUserExists($_POST['email'], $_POST['password']);
                break;

            case 'addUser':
                checkAddUser($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['phone'], $_POST['photo'], $_POST['password'], $_POST['status'], $_POST['job'], $_POST['company'], $_POST['town']);
                break;

            case 'signUp':
                require('view/signUpView.html');
                break;
        }
    }
    //header('Location:index.php?action=home');
else {
    if (!isset($_SESSION['name'])) {
    require('view/signUpView.html');
    }
}
?>