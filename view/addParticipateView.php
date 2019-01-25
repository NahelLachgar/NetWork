<?php
	//PAGE D'AJOUT DE PARTICIPANTS A UN EVENEMENT
	$title="Modifier un événement";
    ob_start();
?>


<div class="container">
    <div class="py-2 text-center">
        <h2>Ajouter des participants à l'événement</h2>
        <p class="lead"></p>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
        </div>
        <div class="col-md-12 order-md-1">
<?php
            if($contact!=false)
            {
                echo "<form enctype='multipart/form-data' action='index.php?action=addParticipate' method='POST'>
                    <input type='hidden' name='id' value='".$id."'>";
                    for($i=0;$i<sizeof($contact);$i++) {
                        echo "<div class='row justify-content-center'>
                                <div class='col-md-6 mb-3'>";
                        echo "<center><input type='checkbox' name='contact[]' value='".$contact[$i][0]."'> ".$contact[$i][1]." ".$contact[$i][2]."<br/>
                                    </center>
                                </div>
                            </div>";
                    }
                echo "<div class='row justify-content-center'>
                        <div class='col-md-3'>
                            <input type='submit' class='btn btn-primary btn-lg btn-block' name='submit' value='Ajouter'>
                        </div>
                    </div>
                </form>";
                if(isset($_SESSION['erreur']) && $_SESSION['erreur']!=="")
                {
                    echo "<center><br/>".$_SESSION['erreur']."</center>";
                    $_SESSION['erreur']="";
                }
                else
                {
                    echo "<br/><br/>";
                }
            }
            else
            {
                echo "<center>Vous ne possédez aucun contact à inviter à votre événement.</center>";
            }
?>
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

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/popper.min.js"></script>
<script src="https://getbootstrap.com/docs/4.1/dist/js/bootstrap.min.js"></script>
<script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/holder.min.js"></script>
<?php
    $content=ob_get_clean();
    require_once('view/template.php');
?>