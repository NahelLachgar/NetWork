<?php
//PAGE DE SUPPRESSION DE COMPTE
?>
	<center><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<h1>Êtes-vous sûr(e) de vouloir supprimer votre compte ?</h1>
    <form action="Controller/delete_calculs.php" method="POST">
         <input type="submit" name ="submit" value="Oui">
    </form>
    <form action="index.php" method="GET">
        <input type="hidden" name="page" value="reception">
         <input type="submit" name ="submit" value="Non">
    </form>
<?php
	if(isset($_SESSION['erreur']) && $_SESSION['erreur']!=="") {
        echo $_SESSION['erreur']."<br/><br/>";
        $_SESSION['erreur']="";
    }
?>
    </center>