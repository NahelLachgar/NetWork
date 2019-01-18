<?php
session_start();
require_once('controller/updateController.php');
require_once('controller/insertController.php');
require_once('controller/selectController.php');
require_once('controller/deleteController.php');
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
           case 'disconnect':
                disconnect();
                break;
            case 'home':
                home(htmlspecialchars($_SESSION['id']),$error);
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
                contactHome($_SESSION['id'],$_POST['contactId'],$_POST['token']);
                break;
            case 'post':
                $imagePost = $_FILES['photo']['name'];
                if($imagePost){
                    addPost(htmlspecialchars($_POST['content']),htmlspecialchars($_POST['type']),htmlspecialchars($_SESSION['id']));
                } else {
                    if (trim(htmlspecialchars($_POST['content'])) != "") {
                        addPost(htmlspecialchars($_POST['content']),htmlspecialchars($_POST['type']),htmlspecialchars($_SESSION['id']));
                    } else {
                        home(htmlspecialchars($_SESSION['id']));
                    } 
                }
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
            case 'signUpCompany':
                require_once('./view/signUpCompanyView.html');
                break;
            case 'signUpEmployee':
                require_once('./view/signUpEmployeeView.html');
                break;
            case 'addContact':
            if (isset($_POST['contactId'])) {
                addToContacts(htmlspecialchars($_POST['contactId']),$_SESSION['id']);
            } else {
                addToContacts(htmlspecialchars($_GET['contactId']),$_SESSION['id']);
            }
                break; 
            case 'removeContact':
                removeContact(htmlspecialchars($_POST['contactId']),$_SESSION['id']);
                break; 
            case 'comment':
                addcomment(htmlspecialchars($_POST['comment']),$_SESSION['id'],$_POST['postId']);
                break; 
            case 'contactContacts':
                showContacts($_SESSION['id'],$_POST['contactId']);
                break;
            case 'showMessages':
                if (!isset($_GET['contactId'])) {
                    $contacts = getContacts($_SESSION['id']);
                    $contactsFetch = $contacts->fetchAll(PDO::FETCH_ASSOC);
                    if ($contactsFetch) {
                    $_GET['contactId'] = $contactsFetch[0]['id']; 
                    } else {
                        $_GET['contactId'] = 0; 
                    }
                } 
                    showMessages($_SESSION['id'],$_GET['contactId']);
                break;
            case 'sendMessage':
                addMessage(htmlspecialchars($_POST['content']),htmlspecialchars($_POST['contactId']),$_SESSION['id']);
                break;
            case 'send':
                require_once('ajax/send.php');
                break;
            case 'groups':
                sessionGroup($_SESSION['id']);
                break;
            case 'deleteView':
                deleteView($_SESSION['id']);
                break;
            case 'deleteAccount':
                deleteAccount($_SESSION['id']);
                break;
            case 'desactivateAccount':
                desactivateAccount($_SESSION['id'], $_POST['active']);
                break;
            case 'showEvents':
                //PRENDRE EN COMPTE LES INVITATIONS
                showEvents($_SESSION['id']);
                break;
            case 'createEventView':
                createEventView($_SESSION['id'], $_POST['role']);
                break;
            case 'createEvent':
                createEvent($_SESSION['id'], $_POST['title'], $_POST['eventDate'], $_POST['place']);
                break;
            case 'eventView':
                //PRENDRE EN COMPTE LES INVITATIONS
                eventView($_SESSION['id'], $_POST['id'], $_POST['role']);
                break;
            case 'quitEvent':
                quitEvent($_POST['ID'], $_POST['id'], $_POST['role']);
                break;
            case 'deleteEvent':
                removeEvent($_POST['id']);
                break;
            case 'updateEventView':
                updateEventView($_SESSION['id'], $_POST['id']);
                break;
            case 'updateEvent':
                modifyEvent($_POST['id'], $_POST['title'], $_POST['eventDate'], $_POST['place']);
                break;
            case 'addParticipateView':
                addParticipateView($_SESSION['id'], $_POST['id']);
                break;
            case 'addParticipate':
                //VERIFIER QU'IL Y A AU MOINS UNE CASE COCHEE
                if(isset($_POST['contact'])) {
                    addParticipate($_SESSION['id'], $_POST['contact'], $_POST['id']);
                }
                else {
                    addParticipate($_SESSION['id'], "", $_POST['id']);
                }
                break;
            /*
            case 'joinInvitation':
            //A FAIRE
                join($_SESSION['id'], $_GET['id'], $_GET['type']);
                break;
            case 'declineInvitation':
            //A FAIRE
                decline($_SESSION['id'], $_GET['id'], $_GET['type']);
                break;
            */
            case 'createGroup':
                createGroups(htmlspecialchars($_POST['nameG']),$_SESSION['id']);
                break;
            case 'addContactsToGroups':
                addContactsToGroup($_POST['addContacts'],$_POST['statut'],$_POST['groupId']);
                break;
            case 'addToGroup':
                addToGroup($_POST['addContact'],$_POST['statut'],$_POST['groupId'],$_SESSION['id']);
                break;
            case 'getGroupId':
                getMembersToGroups($_POST['groupId'],$_SESSION['id']);
                break;
            case 'groupsManage':
                groupManage($_POST['groupId'],$_SESSION['id']);
                break;
            case 'updateGroup':
                updateGroup(htmlspecialchars($_POST['groupName']),$_POST['admin'],$_POST['groupId']);
                break;
            case 'deleteGroup':
                deleteGroup($_POST['groupId']);
                break;
            case 'removeToGroups':
                adminRemoveToGroup($_POST['contactId'],$_POST['groupId'],$_SESSION['id']);
                break;
            case 'leaveTheGroups':
                RemoveToGroup($_POST['contactId'],$_POST['groupId'],$_SESSION['id']);
                break;
            case 'showGroupMessages':
                getGroupMessages($_SESSION['id'],$_GET['groupId']);
                break;
            default:
            $error = "";
                home($_SESSION['id'],$error);
        }
    } else {
        if (!isset($_SESSION['name'])) {
        require_once('view/signInView.php');
        } else {
            header('Location:index.php?action=home');
    }
}
?>