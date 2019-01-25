<?php
    //PAGE PERSONNELLE D'UN EVENEMENT
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
                    <img class="rounded-circle" width="45"src="./img/profile/<?= $profile['photo'] ?>" alt="" />&nbsp&nbsp&nbsp
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
                    <h2><?php echo $event[0]; ?></h2>
                    <p class="lead"></p>
                    <strong>Heure de l'événement :</strong> <?php echo $event[1]; ?><br/><br/>
                    <strong>Lieu :</strong> <?php if(empty($event[2])==true){echo "Aucun lieu n&apos;a été choisi.";}else{echo $event[2];} ?>
                </div>
<?php
    if(isset($_SESSION['erreur']) && $_SESSION['erreur']!=="") {
        echo "<center>".$_SESSION['erreur']."</center>";
        $_SESSION['erreur']="";
    }
    else {
        echo "<br/>";
    }
?>
                <div class="py-2 text-center">
                    <h2>Administrateur</h2>
                    <p class="lead"></p>
<?php
    if($role=='admin') {
        //AFFICHER L'ADMINISTRATEUR
        echo "<form action='index.php' method='GET'>
                    <input type='hidden' name='action' value='home'>
                    <button type='submit' class='btn btn-link'>".$admin[1]." ".$admin[2]."</button> 
                </form>
            </div>";
        //MODIFIER L'EVENEMENT
        echo "<div class='row'>
                <div class='col-md-12 order-md-1'>
                    <form enctype='multipart/form-data' action='index.php?action=updateEventView' method='POST'>
                        <input type='hidden' name='id' value='".$id."'>
                        <div class='row justify-content-center'>
                            <div class='col-md-6'>
                                <input type='submit' class='btn btn-primary btn-lg btn-block' name='submit' value='Modifier l&apos;événement'>
                            </div>
                        </div>
                    </form>";
        //SUPPRIMER L'EVENEMENT
        echo "<div class='col-md-4 order-md-2 mb-4'>
            </div>
            <form enctype='multipart/form-data' action='index.php?action=deleteEvent' method='POST'>
                <input type='hidden' name='id' value='".$id."'>
                <div class='row justify-content-center'>
                    <div class='col-md-6'>
                        <input type='submit' class='btn btn-primary btn-lg btn-block' name='submit' value='Supprimer l&apos;événement'>
                    </div>
                </div>
            </form>";
        //AJOUTER DES CONTACTS AUX PARTICIPANTS DE L'EVENEMENT
        echo "<div class='col-md-4 order-md-2 mb-4'>
            </div>
            <form enctype='multipart/form-data' action='index.php?action=addParticipateView' method='POST'>
                <input type='hidden' name='id' value='".$id."'>
                <div class='row justify-content-center'>
                    <div class='col-md-6'>
                        <input type='submit' class='btn btn-primary btn-lg btn-block' name='submit' value='Ajouter des participants'>
                    </div>
                </div>
            </form>";
    }
    else if($role=='participate') {
        //AFFICHER L'ADMINISTRATEUR
        echo "<form action='index.php?action=profilePage' method='POST'>
                    <input type='hidden' name='contactId' value=".$admin[0].">
                    <button type='submit' class='btn btn-link'>".$admin[1]." ".$admin[2]."</button> 
                </form>
            </div>";
        //PRENDRE EN COMPTE LES INVITATIONS
        /*
        if($invit!=false) {
            echo "<div class='row'>
                    <div class='col-md-12 order-md-1'>
                        <form enctype='multipart/form-data' action='index.php?action=joinInvitation' method='POST'>
                            <input type='hidden' name='id' value='".$invit[$i][0]."'>
                            <input type='hidden' name='type' value='event'>
                            <div class='row justify-content-center'>
                                <div class='col-md-6'>
                                    <input type='submit' class='btn btn-primary btn-lg btn-block' name='submit' value='Rejoindre l&apos;événement'>
                                </div>
                            </div>
                        </form>";
            echo "<div class='col-md-4 order-md-2 mb-4'>
                </div>
                <form enctype='multipart/form-data' action='index.php?action=declineInvitation' method='POST'>
                    <input type='hidden' name='id' value='".$invit[$i][0]."'>
                    <input type='hidden' name='type' value='event'>
                    <div class='row justify-content-center'>
                        <div class='col-md-6'>
                            <input type='submit' class='btn btn-primary btn-lg btn-block' name='submit' value='Décliner l&apos;événement'>
                        </div>
                    </div>
                </form>";
        }
        else{*/
        //SUPPRIMER L'UTILISATEUR DANS LA LISTE DES PARTICIPANTS DE L'EVENEMENT
            echo "<div class='row'>
                        <div class='col-md-12 order-md-1'>
                            <form enctype='multipart/form-data' action='index.php?action=quitEvent' method='POST'>
                                <input type='hidden' name='ID' value='".$_SESSION['id']."'>
                                <input type='hidden' name='id' value='".$id."'>
                                <input type='hidden' name='role' value='participate'>
                                <div class='row justify-content-center'>
                                    <div class='col-md-6'>
                                        <input type='submit' class='btn btn-primary btn-lg btn-block' name='submit' value='Quitter l&apos;événement'>
                                    </div>
                                </div>
                            </form>";
        //}
    }
?>
                        <div class="col-md-4 order-md-2 mb-4">
                        </div>
                        <div class="py-2 text-center">
                            <h2>Participants</h2>
                            <p class="lead"></p>
<?php
    if($participate!=false) {
        for($i=0;$i<sizeof($participate);$i++) {
            //AFFICHER LES PARTICIPANTS
            if($participate[$i][0]!==$_SESSION['id']) {
                echo "<form action='index.php?action=profilePage' method='POST'>
                        <input type='hidden' name='contactId' value='".$participate[$i][0]."'>
                        <button type='submit' class='btn btn-link'>".$participate[$i][1]." ".$participate[$i][2]."</button> 
                    </form>";
            }
            else {
                echo "<form action='index.php' method='GET'>
                    <input type='hidden' name='action' value='home'>
                    <button type='submit' class='btn btn-link'>".$participate[$i][1]." ".$participate[$i][2]."</button> 
                </form>";
            }
            if($role=='admin') {
                //SUPPRIMER LE PARTICIPANT
                echo "<form enctype='multipart/form-data' action='index.php?action=quitEvent' method='POST'>
                            <input type='hidden' name='ID' value='".$participate[$i][0]."'>
                            <input type='hidden' name='id' value='".$id."'>
                            <input type='hidden' name='role' value='admin'>
                            <div class='row justify-content-center'>
                                <div class='col-md-6'>
                                    <input type='submit' class='btn btn-primary btn-lg btn-block' name='submit' value='Enlever sa participation'>
                                </div>
                            </div>
                        </form><br/>";
            }
        }
        echo "</div><br/>";
    }
    else {
        echo "Personne ne participe à cet événement.<br/><br/>";
    }
    $content=ob_get_clean();
    require_once('view/template.php');
?>                    
                            <form enctype="multipart/form-data" action="index.php" method="GET">
                                <input type="hidden" name="action" value="showEvents">
                                <div class="row justify-content-center">
                                    <div class="col-md-7">
                                        <input type="submit" class='btn btn-primary btn-lg btn-block' name="submit" value="Retour">
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-4 order-md-2 mb-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>