<?php
    //PAGE D'AFFICHAGE DES EVENEMENTS
    $title="Evénements";
    ob_start();
?>
<!-- PROFIL-->
<div class="container-fluid gedf-wrapper">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="h5">
                    <img class="rounded-circle" width="45" src="./img/profile/<?= $profile['photo'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp
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
<?php
    if($state=='activated') {
?>
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
?>
                    </div>
                </div>
            </div>
<?php
    }
    else {
        echo "<br/><center>Votre compte est désactivé. Vous devez le réactiver pour pouvoir accéder à cette fonctionnalité.</center>";
    }
    $content=ob_get_clean();
    require_once('view/template.php');
?>
        </div>
    </div>
</div>