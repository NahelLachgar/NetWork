<?php
//PAGE D'EVENEMENTS
?>
    <h1>Mes événements</h1>
    <form action="index.php" method="GET">
        <input type="hidden" name="page" value="create_event">
        <input type="submit" name="submit" value="Créer un événement">
    </form>
<?php
    if(isset($_SESSION['erreur']) && $_SESSION['erreur']!=="") {
        echo "<br/>".$_SESSION['erreur']."<br/>";
        $_SESSION['erreur']="";
    }
    else {
        echo "<br/>";
    }
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
    require('Model/bdd.php');
    $bdd=database();
    require('Model/functions_events.php');
    $role=2;
    $admin=selectAdmin($bdd, $_SESSION['id']);
    if($admin!=false) {
        echo "<h2>J'organise</h2>";
        //afficher les événéments que l'utilisateur organise
        for($i=0;$i<sizeof($admin);$i++) { 
            echo $admin[$i][1];
            echo "<form action='index.php' method='GET'>
                <input type='hidden' name='page' value='show_event'>
                <input type='hidden' name='id' value='".$admin[$i][0]."'>
                <input type='hidden' name='role' value='admin'>
                <input type='submit' name='submit' value='Afficher la page de l&apos;événement'>
            </form>";
        }
    }
    else {
        $role--;
    }
    $event=selectMember($bdd, $_SESSION['id']);
    if($event!=false) {
        echo "<br/><h2>Je participe</h2>";
        //afficher les événéments où l'utilisateur participe mais dont il n'est pas l'administrateur
        for($j=0;$j<sizeof($event);$j++) {
            echo $event[$j][1];
            echo "<form action='index.php' method='GET'>
                <input type='hidden' name='page' value='show_event'>
                <input type='hidden' name='id' value='".$event[$j][0]."'>
                <input type='hidden' name='role' value='participate'>
                <input type='submit' name='submit' value='Afficher la page de l&apos;événement'>
            </form>";
        }
    }
    else {
        $role--;
    }
    if($role==0) {
        echo "Vous ne participez à aucun événement.";
    }
?>