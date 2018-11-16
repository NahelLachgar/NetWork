<?php
session_start();
require('controller/controller.php');


switch ($_GET['action']) {
    case 'connect':
        login($_POST['nom'], $_POST['prenom']);
        break;

    case 'disconnect':
        disconnect();
        break;
}
?>