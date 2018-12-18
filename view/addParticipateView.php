<?php
	//PAGE D'AJOUT DE PARTICIPANTS A UN EVENEMENT
	$title="Modifier un événement";
    ob_start();
?>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
        crossorigin="anonymous">
        
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

<div class="container">
    <div class="py-2 text-center">
        <h2>Ajouter des participants à l'événement</h2>
        <p class="lead"></p>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
        </div>
        <div class="col-md-12 order-md-1">
            <form enctype="multipart/form-data" action="index.php?action=addParticipate" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
<?php
                for($i=0;$i<sizeof($contact);$i++) {
                    echo "<div class='row justify-content-center'>
                            <div class='col-md-6 mb-3'>";
                    for($j=0;$j<12;$j++) { 
                        echo "&emsp;";
                    }
                    echo "<input type='checkbox' name='contact[]' value='".$contact[$i][0]."'> ".$contact[$i][1]." ".$contact[$i][2]."<br/>
                            </div>
                        </div>";
                }
?>
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Ajouter">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<form enctype="multipart/form-data" action="index.php?action=eventView" method="POST">
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <input type="hidden" name="role" value="admin">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Retour">
        </div>
    </div>
</form>

	<!--<h1>Ajouter des participants à l'événement</h1>-->
<?php
	/*if($contact!=false)
	{
		echo "<form action='index.php?action=addParticipate' method='POST'>";
			for($i=0;$i<sizeof($contact);$i++)
			{
				echo "<input type='checkbox' name='contact[]' value='".$contact[$i][0]."'>".$contact[$i][1]." ".$contact[$i][2]."<br/>";
			}
			echo "<input type='hidden' name='id' value='".$id."'>
			<br/><input type='submit' class='btn btn-primary' name='submit' value='Envoyer'><br/><br/>
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
    }*/
?>
    <!--<form action="index.php?action=eventView" method="POST">
        <input type="hidden" name="id" value='<?php echo $id; ?>'>
        <input type="hidden" name="role" value="admin">
        <input type="submit" class="btn btn-primary" name="submit" value="Retour">
    </form>-->

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