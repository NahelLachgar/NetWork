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
                checkAddUser(htmlspecialchars($_POST['firstName']), htmlspecialchars($_POST['lastName']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['phone']), htmlspecialchars($_POST['password']), htmlspecialchars($_POST['confirmPassword']), htmlspecialchars($_POST['status']), htmlspecialchars($_POST['job']), htmlspecialchars($_POST['company']), htmlspecialchars($_POST['town']));
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
            case 'post':
                addPost(htmlspecialchars($_POST['content']),htmlspecialchars($_POST['type']),htmlspecialchars($_SESSION['id']));
                break;
            case 'contactList':
                showContacts(htmlspecialchars($_SESSION['id']));
                break;
            case 'companyList':
                showCompanies(htmlspecialchars($_SESSION['id']));
                break;
            case 'updateProfile':
                updateToProfile(htmlspecialchars($_SESSION['id']));
                break;
            case 'profileModif':
                validateProfile(htmlspecialchars($_POST['newname']),htmlspecialchars($_POST['newsurname']),htmlspecialchars($_POST['newmail']),htmlspecialchars($_POST['newpass']),htmlspecialchars($_POST['newphone']),htmlspecialchars($_POST['newjob']),htmlspecialchars($_POST['newcompay']),htmlspecialchars($_POST['newtown']),htmlspecialchars($_SESSION['id']));
                break;
            case 'signUp':
                require('./view/signUpView.php');
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
        require('view/signInView.php');
        } else {
            header('Location:index.php?action=home');
    }
}
?>