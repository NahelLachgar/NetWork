<?php
    session_start();
    if(isset($_GET['page'])) {
        include('View/top.php');
        switch($_GET['page']):
            case 'logout';
                include('Controller/logout.php');
                break;
            case 'delete'
                include('View/delete.php');
                break;
            case 'evenement'
                include('View/evenement.php');
                break;
            case 'create_event'
                include('View/create_event.php');
                break;
            case 'show_event';
                if(isset($_GET['id']) && empty($_GET['id'])!=true && isset($_GET['role']) && empty($_GET['role'])!=true) {
                    include('View/show_event.php');
                }
                else {
                    include('View/top.php');
                    include('View/home.php');
                    include('View/bottom.php');
                }
                break;
            case 'update_event';
                if(isset($_GET['id']) && empty($_GET['id'])!=true) {
                    include('View/update_event.php');
                }
                else {
                    include('View/top.php');
                    include('View/home.php');
                    include('View/bottom.php');
                }
                break;
            case 'add_event';
                if(isset($_GET['id']) && empty($_GET['id'])!=true) {
                    include('View/add_event.php');
                }
                else {
                    include('View/top.php');
                    include('View/home.php');
                    include('View/bottom.php');
                }
                break;
            default:
                //include('error/404/404.php');
            ///////////////////////////////////////
            endswitch;
            include('View/bottom.php');
    }
    else {
        include('View/top.php');
        include('View/home.php');
        include('View/bottom.php');
    }
?>