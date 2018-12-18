<?php
    //PAGE PERSONNELLE D'UN EVENEMENT
    $title="Evénements";
    ob_start();
    //RAJOUTER PROFILS
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
                        <div class="h5"><img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="Photo de profil">&nbsp&nbsp&nbsp
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

    <h1><?php echo $event[0]; ?></h1>
    Heure de l'événement : <?php echo $event[1]; ?><br/><br/>
    Lieu : <?php if(empty($event[2])==true){echo "Aucun lieu n&apos;a été désigné.";}else{echo $event[2];} ?><br/><br/>
<?php
    if(isset($_SESSION['erreur']) && $_SESSION['erreur']!=="")
    {
        echo $_SESSION['erreur']."<br/><br/>";
        $_SESSION['erreur']="";
    }
    if($_GET['role']=='admin')
    {
        //MODIFIER L'EVENEMENT
        echo "<form action='index.php' method='GET'>
            <input type='hidden' name='action' value='updateEventView'>
            <input type='hidden' name='id' value='".$id."'>
            <input type='submit' name='submit' value='Modifier l&apos;événement'>
        </form>";
        //SUPPRIMER L'EVENEMENT
        echo "<form action='index.php' method='GET'>
            <input type='hidden' name='action' value='deleteEvent'>
            <input type='hidden' name='id' value='".$id."'>
            <input type='submit' name='submit' value='Supprimer l&apos;événement'>
        </form>";
        //AJOUTER DES CONTACTS AUX PARTICIPANTS DE L'EVENEMENT
        echo "<form action='index.php' method='GET'>
            <input type='hidden' name='action' value='addParticipateView'>
            <input type='hidden' name='id' value='".$id."'>
            <input type='submit' name='submit' value='Ajouter des participants'>
        </form>";
    }
    else if($_GET['role']=='participate')
    {
        //PRENDRE EN COMPTE LES INVITATIONS
        /*
        echo "<form action='index.php' method='GET'>
                <input type='hidden' name='action' value='join'>
                <input type='hidden' name='id' value='".$event[$i][0]."'>
                <button>Rejoindre un événement</button>
            </form>";
        echo "<form action='index.php' method='GET'>
                <input type='hidden' name='action' value='decline'>
                <input type='hidden' name='id' value='".$event[$i][0]."'>
                <button>Refuser un événement</button>
            </form>";
        */
        //SUPPRIMER L'UTILISATEUR DES PARTICIPANTS DE L'EVENEMENT
        echo "<form action='index.php' method='GET'>
            <input type='hidden' name='action' value='quitEvent'>
            <input type='hidden' name='ID' value='".$_SESSION['id']."'>
            <input type='hidden' name='id' value='".$id."'>
            <input type='hidden' name='role' value='participate'>
            <input type='submit' name='submit' value='Quitter l&apos;événement'>
        </form>";
    }
    //AFFICHER L'ADMINISTRATEUR
//METTRE PROFIL DANS HYPERLIEN
?>
    <br/>
    <h2>Administrateur</h2>
    <a href='index.php?action='><?php echo $admin[0]." ".$admin[1]; ?></a><br/><br/>
<?php
    //AFFICHER LES PARTICIPANTS
?>
    <h2>Participants</h2>
<?php
    if($participate!=false)
    {
        for($i=0;$i<sizeof($participate);$i++)
        {
            //AFFICHER LES PARTICIPANTS
//METTRE PROFIL DANS HYPERLIEN
            echo "<a href='index.php?action='>".$participate[$i][1]." ".$participate[$i][2]."</a><br/>";
            if($_GET['role']=='admin')
            {
                //SUPPRIMER LE PARTICIPANT
                echo "<form action='index.php' method='GET'>
                    <input type='hidden' name='action' value='quitEvent'>
                    <input type='hidden' name='ID' value='".$participate[$i][0]."'>
                    <input type='hidden' name='id' value='".$id."'>
                    <input type='hidden' name='role' value='admin'>
                    <input type='submit' name='submit' value='Enlever sa participation'>
                </form><br/>";
            }
        }
        echo "<br/>";
    }
    else
    {
        echo "Personne ne participe à cet événement.<br/><br/>";
    }
?>
    <form action="index.php" method="GET">
        <input type="hidden" name="action" value="showEvents">
        <input type="submit" name="submit" value="Retour">
    </form>
<?php
    $content=ob_get_clean();
    require('view/template.php');
?>