<?php
session_start();
$db = dbConnect();
require('controller/controller.php');
if (isset($_SESSION['name'])) {
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
        }
    } else {
        header('Location:index.php?action=home');
    } 
} else {
    //require('view/connectView.php');
    $_SESSION['name'] = "Nahel";
    $_SESSION['lastname'] = "Lachgar";
    $_SESSION['id'] = "1";
}
?>