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
                var_dump($_SESSION);
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
            case 'updateprofile':
                require('./view/profilUpdateView.php');
                break;
            case 'profilemodif':
                updateToProfile();
                break;
            case 'profilePage':
                getProfileSearch($_POST['id']);
                break;
            case 'signUp':
                require('./view/signUpView.html');
                break;
            case 'post':
                addPost(htmlspecialchars($_POST['content']),$_POST['type'],$_SESSION['id']);
                break;
            case 'contactList':
                showContacts($_SESSION['id']);
                break;
                case 'updateProfile':
                updateToProfile($_SESSION['id']);
                break;
            case 'profileModif':
                validateProfile($_POST['newname'],$_POST['newsurname'],$_POST['newmail'],$_POST['newpass'],$_POST['newphone'],$_POST['newjob'],$_POST['newcompany'],$_POST['newtown'],$_SESSION['id']);
                break;
            case 'signUp':
                require('./view/signUpView.html');
                break;
            case 'post':
                addPost(htmlspecialchars($_POST['content']),$_POST['type'],$_SESSION['id']);
                break;
            default:
                home($_SESSION['id']);
            
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