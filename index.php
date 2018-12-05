<?php
session_start();
require('controller/controller.php');
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
           case 'disconnect':
                disconnect();
                break;
            case 'home':
                home(htmlspecialchars($_SESSION['id']));
                break;
            case 'checkUser':
                checkUserExists(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password']));
                break;
            case 'addUser':
                checkAddUser($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['confirmPassword'], $_POST['status'], $_POST['job'], $_POST['company'], $_POST['town']);
                break;
            case 'search':
                search(htmlspecialchars($_SESSION['id']),htmlspecialchars($_POST['research']));
                break;
            case 'updateprofile':
                require('./view/profilUpdateView.php');
                break;
            case 'profilemodif':
                updateToProfile();
                break;
            case 'profilePage':
                getProfileSearch(htmlspecialchars($_POST['id']));
                break;
            case 'signUp':
                require('./view/signUpView.html');
                break;
            case 'post':
                addPost(htmlspecialchars($_POST['content']),htmlspecialchars($_POST['type']),htmlspecialchars($_SESSION['id']));
                break;
            case 'contactList':
                showContacts(htmlspecialchars($_SESSION['id']));
                break;
                case 'updateProfile':
                updateToProfile(htmlspecialchars($_SESSION['id']));
                break;
            case 'profileModif':
                validateProfile(htmlspecialchars($_POST['newname']),htmlspecialchars($_POST['newsurname']),htmlspecialchars($_POST['newmail']),htmlspecialchars($_POST['newpass']),htmlspecialchars($_POST['newphone']),htmlspecialchars($_POST['newjob']),htmlspecialchars($_POST['newcompay']),htmlspecialchars($_POST['newtown']),htmlspecialchars($_SESSION['id']));
                break;
            case 'signUp':
                require('./view/signUpView.html');
                break;
            case 'post':
                addPost(htmlspecialchars($_POST['content']),htmlspecialchars($_POST['type']),htmlspecialchars($_SESSION['id']));
                break;
            case 'addContact':
                addToContacts(htmlspecialchars($_POST['ID']),$_session['id']);
                break; 
            default:
                home(htmlspecialchars($_SESSION['id']));
            
        }
    } else {
        if (!isset($_SESSION['name'])) {
        require('view/signInView.html');
        } else {
            header('Location:index.php?action=home');
    }
}
?>