<?php
//PAGE DE CREATION D'UN EVENEMENT
?>
    <h1>Création d'un événement</h1>
    <form action="Controller/evenement_calculs.php" method="POST">
        <input type="text" placeholder="Nom" name="title" required><br/>
        <input type="date" placeholder="YYYY-MM-JJ HH:MM:SS" name="eventDate" required><br/>
        <input type="text" placeholder="Lieu de rendez-vous" name="place"><br/><br/>
        <input type="hidden" name="function" value="create">
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
        <input type="hidden" name="page" value="evenement">
        <input type="submit" name="submit" value="Retour">
    </form>