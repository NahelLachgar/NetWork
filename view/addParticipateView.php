<?php
	//PAGE D'AJOUT DE PARTICIPANTS A UN EVENEMENT
	$title="Modifier un événement";
    ob_start();
?>

	<h1>Ajouter des participants à l'événement</h1>
<?php
	if($contact!=false)
	{
		echo "<form action='index.php' method='GET'>
				<input type='hidden' name='action' value='addParticipate'>";
			for($i=0;$i<sizeof($contact);$i++)
			{
				echo "<input type='checkbox' name='contact[]' value='".$contact[$i][0]."'>".$contact[$i][1]." ".$contact[$i][2]."<br/>";
			}
			echo "<input type='hidden' name='id' value='".$id."'>
			<br/><input type='submit' name='submit' value='Envoyer'><br/>
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
        <input type="hidden" name="action" value="eventView">
        <input type="hidden" name="id" value='<?php echo $id; ?>'>
        <input type="hidden" name="role" value="admin">
        <input type="submit" name="submit" value="Retour">
    </form>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.1/dist/js/bootstrap.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/holder.min.js"></script>
    <script src="./js/inscription.js"></script>
<?php
    $content=ob_get_clean();
    require('view/template.php');
?>