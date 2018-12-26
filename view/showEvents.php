<?php
    //PAGE D'AFFICHAGE DES EVENEMENTS
    $title="Evénements";
    ob_start();
?>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
        crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

<!-- PROFIL-->
<div class="container-fluid gedf-wrapper">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="h5"><img class="rounded-circle" width="45" src="./img/profile/<?= $profile['photo'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp
                    <?= $profile['name'] . ' ' . $profile['lastName'] ?></div>
                    <div class="h7">
                        <?= $profile['job'] . ' chez ' . $profile['company'] ?>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=companyList">Entreprises</a></div>
                        <div class="h5"><?= $followedCompaniesNb ?></div>
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=contactList">Contacts</a></div>
                        <div class="h5"><?= $contactsNb ?></div>
    
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=updateProfile">Modifier le profil</a></div>
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=deleteView">Supprimer le compte</a></div>
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=disconnect">Déconnexion</a></div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 gedf-main">

            <div class="container">
                <div class="py-2 text-center">
                    <h2>Mes événements</h2>
                    <p class="lead"></p>
                </div>

                <div class="row">
                    <div class="col-md-12 order-md-1">
                        <form enctype="multipart/form-data" action="index.php?action=createEventView" method="POST">
                            <input type="hidden" name="role" value="admin">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Créer un événement">
                                </div>
                            </div>
                        </form>
<?php
    if(isset($_SESSION['erreur']) && $_SESSION['erreur']!=="") {
        echo "<br/><div class='py-2 text-center'>".$_SESSION['erreur']."</div>";
        $_SESSION['erreur']="";
    }
    else {
        echo "<br/><br/>";
    }
    //PRENDRE EN COMPTE LES INVITATIONS
    /*
    echo "<div class="col-md-4 order-md-2 mb-4">
        </div>
        <form enctype="multipart/form-data" action="index.php?action=joinInvitation" method="POST">
            <input type='hidden' name='id' value='".$event[$i][0]."'>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Rejoindre l&apos;événement">
                </div>
            </div>
        </form>
        <div class="col-md-4 order-md-2 mb-4">
        </div>
        <form enctype="multipart/form-data" action="index.php?action=declineInvitation" method="POST">
            <input type='hidden' name='id' value='".$event[$i][0]."'>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Décliner l&apos;événement">
                </div>
            </div>
        </form>";
    */
    if($admin!=false) {
        echo "<div class='py-2 text-center'>
                    <h3>J'organise</h3>
                    <p class='lead'></p>
                </div>";
        //AFFICHER LES EVENEMENTS QUE L'UTILISATEUR ORGANISE
        for($i=0;$i<sizeof($admin);$i++) {
            echo "<center><h4>".$admin[$i][1]."</h4></center>";
            echo "<div class='col-md-4 order-md-2 mb-4'>
                </div>
                <form enctype='multipart/form-data' action='index.php?action=eventView' method='POST'>
                    <input type='hidden' name='id' value='".$admin[$i][0]."'>
                    <input type='hidden' name='role' value='admin'>
                    <div class='row justify-content-center'>
                        <div class='col-md-8'>
                            <input type='submit' class='btn btn-primary btn-lg btn-block' name='submit' value='Afficher la page de l&apos;événement'>
                        </div>
                    </div>
                </form>
                <div class='col-md-4 order-md-2 mb-4'>
                </div>";
        }
        echo "<div class='col-md-4 order-md-2 mb-4'>
                </div>";
    }
    else {
        $role--;
    }
    if($event!=false) {
        echo "<div class='py-2 text-center'>
                    <h3>Je participe</h3>
                    <p class='lead'></p>
                </div>";
        //AFFICHER LES EVENEMENTS OU L'UTILISATEUR PARTICIPE MAIS DONT IL N'EST PAS L'ADMINISTRATEUR
        for($j=0;$j<sizeof($event);$j++) {
            echo "<center><h4>".$event[$j][1]."</h4></center>";
            echo "<div class='col-md-4 order-md-2 mb-4'>
                </div>
                <form enctype='multipart/form-data' action='index.php?action=eventView' method='POST'>
                    <input type='hidden' name='id' value='".$event[$j][0]."'>
                    <input type='hidden' name='role' value='participate'>
                    <div class='row justify-content-center'>
                        <div class='col-md-8'>
                            <input type='submit' class='btn btn-primary btn-lg btn-block' name='submit' value='Afficher la page de l&apos;événement'>
                        </div>
                    </div>
                </form>
                <div class='col-md-4 order-md-2 mb-4'>
                </div>";
        }
    }
    else {
        $role--;
    }
    if($role==0) {
        echo "<br/><center>Vous ne participez à aucun événement.</center>";
    }
    $content=ob_get_clean();
    require('view/template.php');
?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>