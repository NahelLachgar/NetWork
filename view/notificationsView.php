<?php 
$title = "Contacts";
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
    <br>
    <?php
    if($state=='activated') {
        if (empty($res)) :
            echo " <center><div class='col align-self-end'><div class='card border-danger mb-6' style='max-width: 18rem;'>
            <div class='card-body text-danger'>
              <h5 class='card-title'>Oups!</h5>
              <p class='card-text'>Vous n'avez aucun contact.</p>
            </div>
          </div></div></center>";
            ?>
    <br>
        <?php elseif ($res == true) :
            foreach ($res as $notif) : ?>

            <?php if ($notif['status'] == 'employee') : ?>
            <div class="card gedf-card">
                        <div class="card-body">
                            <h5 class="card-title"><img class="rounded-circle" width="45" src="./img/profile/<?= $notif['icon'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp
                            <?= $noti['content']?>
                            <p class="card-text"><?= $notif['job'] . ' chez ' . $notif['company'] ?></p>       
                        <?php endif;?>
                        </div>
                    </div>
            </div>
        <?php
        endforeach;
        else :
            echo $return;
        endif;
    }
    else {
        echo "<br/><center>Votre compte est désactivé. Vous devez le réactiver pour pouvoir accéder à cette fonctionnalité.</center>";
    }
    $content = ob_get_clean();
    require_once('view/template.php');
    ?>