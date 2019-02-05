<!doctype html>
<html>
  <head>
        <meta charset="utf-8">
        <title><?= $title ?></title>
        <meta charset="utf-8">
    <title><?= $title ?></title>
    <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>   
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
  
  <nav class="navbar navbar-light bg-bleu">
    <div class="home">
        <a id="buttonHome" href="index.php?action=home" class="home"><img width="30px" src="../img/icon/home.svg" alt="Photo de profil"></a>
    </div>

    <div class="nav">
        <a id="buttonGroup" href="index.php?action=groups" class="groups"><img width="30px" src="../img/icon/group.svg" alt="Groupe"></a>
        &nbsp        

<?php
    if($_SESSION['status']=="employee") {
        echo "<a id='buttonEvent' href='index.php?action=showEvents' class='home'><img width=30px src='img/icon/event.svg' alt='Photo de profil'></a>&nbsp";
    }
?>
        <a id="buttonMessages" href="index.php?action=showMessages">            
            <img width="30px" src="../img/icon/message.svg"> 
        </a> 
        &nbsp

        <a style="text-decoration:none" id="buttonNotifications" href="index.php?action=notificationsPage" class="notifications">
        <img width="30px" src="../img/icon/notifications.svg" alt="notifications">
        <span id="nbNotifs" class="badge badge-danger"></span>
        </a>
        &nbsp
           
        <form class="form-inline" action="index.php?action=search" method="POST">
            <div class="input-group">
                <input type="text" placeholder="Rechercher..." name="research" required class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit"  id="button-addon2">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
        </div>
    </nav>



  <?= $content ?>
  <script src="bootstrapNotify/dist/bootstrap-notify.js"></script>
  <script src="js/loadNotif.js"></script>
    </body>
</html>