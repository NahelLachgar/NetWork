<?php 
$title = "Contacts";
ob_start();
?>
<br>
    <?php
    if($_SESSION['state']=='activated') {
        if (!$notifs) :
            echo " <center><div class='col align-self-end'><div class='card border-danger mb-6' style='max-width: 18rem;'>
            <div class='card-body text-danger'>
              <h5 class='card-title'>Oups!</h5>
              <p class='card-text'>Vous n'avez aucune notif.</p>
            </div>
          </div></div></center>";
            ?>
    <br>
        <?php elseif ($notifs == true) :
            foreach ($notifs as $notif) : ?>

            <div class="card gedf-card">
                        <div class="card-body">
                            <h5 class="card-title"><img class="rounded-circle" width="45" src="./img/profile/<?= $notif['icon'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp
                            <?= $notif['content']?>
                        </div>
                    </div>
            </div>
        <?php
        endforeach;

        endif;
    }
    else {
        echo "<br/><center>Votre compte est désactivé. Vous devez le réactiver pour pouvoir accéder à cette fonctionnalité.</center>";
    }
    $content = ob_get_clean();
    require_once('view/template.php');
    ?>