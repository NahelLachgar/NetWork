<?php
	//PAGE D'AJOUT DE PARTICIPANTS A UN EVENEMENT
	require('Model/bdd.php');
	$bdd=database();
    require('Model/functions_events.php');
    $contact=infoContact($bdd, $_GET['id'], $_SESSION['id']);
?>
	<h1>Ajouter des participants à l'événement</h1>
<?php
	if($contact!=false)
	{
		echo "<form action='Controller/evenement_calculs.php' method='POST'>";
			for($i=0;$i<sizeof($contact);$i++)
			{
				echo "<input type='checkbox' name='contact[]' value='".$contact[$i][0]."'>".$contact[$i][1]." ".$contact[$i][2]."<br/>";
			}
			echo "<input type='hidden' name='id' value='".$_GET['id']."'>
			<input type='hidden' name='function' value='add'>
			<br/><input type='submit' name='submit' value='Envoyer'>
		</form>";
	}
	else
	{
		echo "Vous ne possédez aucun contact à inviter à votre événement.";
	}
	if(isset($_SESSION['erreur']) && $_SESSION['erreur']!=="")
    {
        echo $_SESSION['erreur']."<br/><br/>";
        $_SESSION['erreur']="";
    }
    else
    {
        echo "<br/><br/>";
    }
?>
    <form action="index.php" method="GET">
        <input type="hidden" name="page" value="show_event">
        <input type="hidden" name="id" value='<?php echo $_GET['id'] ?>'>
        <input type="hidden" name="role" value="admin">
        <input type="submit" name="submit" value="Retour">
    </form>