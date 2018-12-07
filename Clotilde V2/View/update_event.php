<?php
//PAGE DE MODIFICATION D'UN EVENEMENT
    require('Model/bdd.php');
    $bdd=database();
    require('Model/functions_events.php');
    $event=infoEvent($bdd, $_GET['id']);
?>
    <h1>Modification d'un événement</h1>
    <form action="Controller/evenement_calculs.php" method="POST">
        <input type="text" placeholder="Nom" name="title" value='<?php echo $event[0]; ?>' required><br/>
        <input type="date" placeholder="YYYY-MM-JJ HH:MM:SS" name="eventDate" value='<?php echo $event[1]; ?>' required><br/>
        <input type="text" placeholder="Lieu de rendez-vous" name="place" value='<?php echo $event[2]; ?>'><br/><br/>
        <input type="hidden" name="function" value="update">
        <input type='hidden' name='id' value='<?php echo $_GET['id']; ?>'>
        <input type="submit" name="submit" value="Envoyer">
    </form>
<?php
    if(isset($_SESSION['erreur']) && $_SESSION['erreur']!=="") {
        echo "<br/>".$_SESSION['erreur']."<br/><br/>";
        $_SESSION['erreur']="";
    }
    else {
        echo "<br/><br/>";
    }
?>
    <form action="index.php" method="GET">
        <input type="hidden" name="page" value="show_event">
        <input type="hidden" name="id" value='<?php echo $_GET['id'] ?>'>
        <input type="hidden" name="role" value="admin">
        <input type="submit" name="submit" value="Retour">
    </form>