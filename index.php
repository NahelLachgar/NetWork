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
            case 'profilePage':
                contactHome($_POST['contactId']);
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
                updateToProfile($_SESSION['id']);
                break;
            case 'profilemodif':
               validateProfile($_POST['newname'],$_POST['newsurname'],$_POST['newmail'],$_POST['newPass'],$_POST['confirmNewPass'],$_POST['newphone'],$_POST['newjob'],$_POST['newcompany'],$_POST['newtown'],$_SESSION['id']);
                break;
            case 'signUp':
                require('./view/signUpView.php');
                break;
            case 'post':
                addPost(htmlspecialchars($_POST['content']),htmlspecialchars($_POST['type']),htmlspecialchars($_SESSION['id']));
                break;
            case 'addContact':
                addToContacts(htmlspecialchars($_POST['contactId']),$_SESSION['id']);
                break; 
            case 'removeContact':
                removeContact(htmlspecialchars($_POST['contactId']),$_SESSION['id']);
                break; 
            case 'comment':
                addcomment(htmlspecialchars($_POST['comment']),$_SESSION['id'],$_POST['postId']);
                break; 
            case 'contactContacts':
                showContacts($_POST['contactId']);
                break;
            case 'showMessages':
                if (!isset($_POST['contactId'])) {
                    $contacts = getContacts($_SESSION['id']);
                    $contactsFetch = $contacts->fetchAll(PDO::FETCH_ASSOC);
                    $_POST['contactId'] = $contactsFetch[0]['id']; 
                } 
                    showMessages($_SESSION['id'],$_POST['contactId']);
                break;
            case 'sendMessage':
                addMessage(htmlspecialchars($_POST['content']),htmlspecialchars($_POST['contactId']),$_SESSION['id']);
                break;
            case 'groups':
                echo "groupe";
                break;
            default:
                home($_SESSION['id']);
        }
    } else {
        if (!isset($_SESSION['name'])) {
        require('view/signInView.php');
        } else {
            header('Location:index.php?action=home');
    }
}
?>