<?php
include_once('controller/deleteController.php');
include_once('controller/selectController.php');
include_once('controller/updateController.php');
include_once('model/insertModel.php');
include_once('model/updateModel.php');
include_once('model/deleteModel.php');
include_once('model/selectModel.php');
function addPost($content, $type, $userId)
{
    // PHOTO
    $imagePost = $_FILES['photo']['name'];
    if ($imagePost) {
        $type = "image";
        $contents = countPublications();
        $content = $contents[0];
    // ON SEPARE LE NOM DE L'IMAGE DE SON EXTENSION
        list($name, $ext) = explode(".", $imagePost);    
   // ON RAJOUTE UN . DEVANT L'EXTENSION 
        $ext = "." . $ext; 
    // ON MET LA PHOTO DANS UN DOSSIER IMG/POSTS
        $path = "./img/posts/" . $content . $ext;
        move_uploaded_file($_FILES['photo']['tmp_name'], $path);
        $content = $content . $ext;
    }
    post($content, $type, $userId);
    header('Location:index.php?action=home');
}
function addComment($content, $userId, $postId)
{
    comment($content, $userId, $postId);
    header('Location:index.php?action=home');
}
// CHECK LES INFOS D'INSCRIPTION
function checkAddUser($firstName, $lastName, $email, $phone, $password, $confirmPassword, $status, $job, $company, $town){

    $errors = array();

	// ON VERIFIE QUE LES DONNEES NE SOIT PAS VIDE
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword) || empty($status) || empty($job) || empty($company) || empty($town)) {
        $errors['empty'] = "Vérifier que les champs sont bien remplis.";
        include_once('view/signUpView.php');
    }

	// ON SECURISE LES DONNEES 
    $firstName = htmlspecialchars($firstName);
    $lastName = htmlspecialchars($lastName);
    $email = htmlspecialchars($email);
    $phone = htmlspecialchars($phone);
    $password = htmlspecialchars($password);
    $confirmPassword = htmlspecialchars($confirmPassword);
    $status = htmlspecialchars($status);
    $job = htmlspecialchars($job);
    $company = htmlspecialchars($company);
    $town = htmlspecialchars($town);

	// ON CHECK SI LE MOT DE PASSE ET LA CONFIRMATION DU MOT DE PASSE SONT DIFFERENTE
    if ($password != $confirmPassword) {
        $errors['wrongPassWord'] = "Le mot de passe saisi est incorrect.";
        header('Location:index.php?action=signUp');
    }
	// ON CHECK SI LES DONNEÉS SONT BONNES
    if (!empty($password && $password == $confirmPassword)) {	
	// OPTIONS APPORTES AU HASH	
        $options = ['cost' => 12];
	// ON HASH LE MOT DE PASSE 
        $hashpassword = password_hash($password, PASSWORD_BCRYPT, $options);

	
	// PHOTO
        $profilePhoto = $_FILES['photo']['name'];

        if ($profilePhoto) {
	// ON SEPARE LE NOM DE L'IMAGE DE SON EXTENSION
            list($name, $ext) = explode(".", $profilePhoto);    
   	// ON RAJOUTE UN . DEVANT L'EXTENSION 
            $ext = "." . $ext; 
	// ON MET LA PHOTO DANS UN DOSSIER IMG
            $path = "./img/profile/" . $email . $ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], $path);
            $profilePhoto = $email . $ext;
    // SI L'UTILISATEUR N'A PAS CHOISI DE PHOTO DE PROFIL, ON LUI EN ATTRIBUT UNE DEJA EXISTANTE
        } else if($profilePhoto == false){
            $profilePhoto = "NetWork.png";
        }
	// ON ENVOIE LES DONNES DANS LA BDD
        addUser($firstName, $lastName, $email, $phone, $profilePhoto, $hashpassword, $status, $job, $company, $town);
        include_once('view/signInView.php');

    }
}
//FUNCTION AJOUT DE CONTACT
function addToContacts($contactId, $userId)
{
    $add = addContact($contactId, $userId);
    if ($add == true) {
        header('Location:index.php?action=home');
    }
}

    //FUNCTION UNFOLLOW UN CONTACT
function removeContact($contactId, $userId)
{
    $unf = unfollow($contactId, $userId);
    if ($unf) {
        header('Location:index.php?action=home');
    }
}
    //CREER UN GROUPE
function createGroups($groupName, $userId)
{
    // PHOTO
    var_dump($_FILES);
    $groupPhoto = $_FILES['photo']['name'];
    if ($groupPhoto) {
    // ON SEPARE LE NOM DE L'IMAGE DE SON EXTENSION
        list($name, $ext) = explode(".", $groupPhoto);    
   // ON RAJOUTE UN . DEVANT L'EXTENSION 
        $ext = "." . $ext; 
    // ON MET LA PHOTO DANS UN DOSSIER IMG
        $path = "./img/groups/" . $groupName . $ext;
        move_uploaded_file($_FILES['photo']['tmp_name'], $path);
        $groupPhoto = $groupName . $ext;
    // SI L'UTILISATEUR N'A PAS CHOISI DE PHOTO DE PROFIL, ON LUI EN ATTRIBUT UNE DEJA EXISTANTE
    } else if($groupPhoto == false){
        $groupPhoto = "NetWork.png";
    }
    // ON ENVOIE LES DONNES DANS LA BDD
    $create = createGroup($groupName, $userId, $groupPhoto);
		//$addAdmin = contactAddGroup()
    $contacts = getContacts($userId);
    $contacts = $contacts->fetchAll(PDO::FETCH_ASSOC);
    for ($i = 0; $i < count($contacts); $i++) {
        $contactProfile[] = getProfile($contacts[$i]['id']);
    }
    foreach ($contactProfile as $contact) {
        if ($contact['status'] == "employee") {
            $res[] = $contact;
        }
    }
    $status = checkStatus($userId);
    include_once('./view/addContactGroupView.php');
}
        
	//AJOUTER LES CONTACTS DANS UN GROUPE
function addContactsToGroup($contact, $status, $groupId)
{
    $comt = COUNT($contact);
    for ($i = 0; $i < $comt; $i++) {
        contactAddGroup($contact[$i], $status, $groupId);
    }
    sessionGroup($_SESSION['id'], $_SESSION['id']);
}
?>