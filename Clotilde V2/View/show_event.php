<?php
//PAGE PERSONNELLE D'UN EVENEMENT
    require('Model/bdd.php');
    $bdd=database();
    require('Model/functions_events.php');
    $event=infoEvent($bdd, $_GET['id']);
?>
    <h1><?php echo $event[0]; ?></h1>
    Heure de l'événement : <button onclick="functionDate()">Afficher</button><br/>
    <p id="date"></p>
    Lieu : <button onclick="functionPlace()">Afficher</button><br/>
    <p id="place"></p>

    <script>
    function functionDate()
    {
        document.getElementById("date").innerHTML="<?php echo $event[1]; ?>";
    }
    function functionPlace()
    {
        document.getElementById("place").innerHTML='<?php if(empty($event[2])==true){echo "Aucun lieu n&apos;a été désigné.";}else{echo $event[2];} ?>';
    }
    </script>

<?php
    if(isset($_SESSION['erreur']) && $_SESSION['erreur']!=="")
    {
        echo "<br/>".$_SESSION['erreur']."<br/><br/>";
        $_SESSION['erreur']="";
    }
    if($_GET['role']=='admin')
    {
        //modifier l'événement
        echo "<form action='index.php' method='GET'>
            <input type='hidden' name='page' value='update_event'>
            <input type='hidden' name='id' value='".$_GET['id']."'>
            <input type='submit' name='submit' value='Modifier l&apos;événement'>
        </form>";
        //supprimer l'événement
        echo "<form action='Controller/evenement_calculs.php' method='POST'>
            <input type='hidden' name='id' value='".$_GET['id']."'>
            <input type='hidden' name='function' value='delete'>
            <input type='submit' name='submit' value='Supprimer l&apos;événement'>
        </form>";
        //ajouter des contacts aux participants de l'événement
        //à remplacer par des demandes à joindre l'événement par la suite
        echo "<form action='index.php' method='GET'>
            <input type='hidden' name='page' value='add_event'>
            <input type='hidden' name='id' value='".$_GET['id']."'>
            <input type='submit' name='submit' value='Ajouter des participants'>
        </form>";
    }
    else if($_GET['role']=='participate')
    {
        //PRENDRE EN COMPTE LES INVITATIONS
        /*
        echo "<form action='Controller/evenement_calculs.php' method='POST'>
                <input type='hidden' name='id' value='".$event[$i][0]."'>
                <input type='hidden' name='function' value='join'>
                <button>Rejoindre un événement</button>
            </form>";
        echo "<form action='Controller/evenement_calculs.php' method='POST'>
                <input type='hidden' name='id' value='".$event[$i][0]."'>
                <input type='hidden' name='function' value='decline'>
                <button>Refuser un événement</button>
            </form>";
        */
        //supprimer l'utilisateur des participants de l'événement
        echo "<form action='Controller/evenement_calculs.php' method='POST'>
            <input type='hidden' name='ID' value='".$_SESSION['id']."'>
            <input type='hidden' name='id' value='".$_GET['id']."'>
            <input type='hidden' name='role' value='participate'>
            <input type='hidden' name='function' value='quit'>
            <input type='submit' name='submit' value='Quitter l&apos;événement'>
        </form>";
    }
    //affichage de l'administrateur
    $admin=checkAdmin($bdd, $_GET['id']);
?>
    <h2>Administrateur</h2>
    <a href='index.php?page='><?php echo $admin[0]." ".$admin[1]; ?></a>
<?php
    //affichage des participants
    $participate=checkParticipate($bdd, $_GET['id']);
?>
    <h2>Participants</h2>
<?php
    if($participate!=false)
    {
        for($i=0;$i<sizeof($participate);$i++)
        {
            //afficher profil du participant
//METTRE PROFIL DANS HYPERLIEN
            echo "<a href='index.php?page='>".$participate[$i][1]." ".$participate[$i][2]."</a><br/>";
            if($_GET['role']=='admin')
            {
                //supprimer le participant
                echo "<form action='Controller/evenement_calculs.php' method='POST'>
                    <input type='hidden' name='ID' value='".$participate[$i][0]."'>
                    <input type='hidden' name='id' value='".$_GET['id']."'>
                    <input type='hidden' name='role' value='admin'>
                    <input type='hidden' name='function' value='quit'><br/>
                    <input type='submit' name='submit' value='Enlever sa participation'>
                </form>";
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
        <input type="hidden" name="page" value="evenement">
        <input type="submit" name="submit" value="Retour">
    </form>