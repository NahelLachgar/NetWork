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
            case 'search':
                search($_SESSION['id'],$_POST['research']);
                break;
            case 'addcontacts':
                addToContact($_GET['id'],$_SESSION['id']);
                break;
            case 'removeContacts':
                removeContacts($_GET['id'],$_SESSION['id']);
                break;
            case 'profilepage':
                getProfileSearch($_GET['id']);
                break;
            case 'updateprofile':
                updateToProfile($_SESSION['id']);
                break;
            case 'profilemodif':
                validateProfile($_POST['newname'],$_POST['newsurname'],$_POST['newmail'],$_POST['newpass'],$_POST['newphone'],$_POST['newjob'],$_POST['newcompany'],$_POST['newtown'],$_SESSION['id']);
                break;
            case 'signUp':
                require('./view/signUpView.html');
                break;
            case 'post':
                addPost(htmlspecialchars($_POST['content']),$_POST['type'],$_SESSION['id']);
                break;
        }
    }
else {
    if (!isset($_SESSION['name'])) {
    require('view/signInView.html');
    } else {
        header('Location:index.php?action=home');
    }
}
?>