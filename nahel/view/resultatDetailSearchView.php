<?php 
$title = "Recherche";
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
        
<nav class="navbar navbar-light bg-bleu">
        <a href="index.php?action=home" class="home"><img width="45" src="https://image.flaticon.com/icons/svg/263/263115.svg" alt="Photo de profil"></a>
        <form class="form-inline" action="index.php?action=search" method="POST">
            <div class="input-group">
                <input type="text" name="research" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit"  id="button-addon2">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>

    </nav>
    </form>
    <br><br>
        <?php
            foreach ($res as $resultat) : 
                    if(in_array($resultat['idContact'],$contact)):
            ?>
                <div class="card gedf-card">
                        <div class="card-body">
                    
                            <h5 class="card-title"><img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="Photo de profil">&nbsp&nbsp&nbsp<form class="form-inline" action="index.php?action=profilePage" method="POST"><input type="hidden" name="id" value="<?= $resultat['idContact'] ?>"> <input type="submit" class="btn btn-link" value="<?= $resultat['name'] . ' ' . $resultat['lastname'] ?>"> </form></h5>
                            <p class="card-text"><?= $resultat['job'] . ' chez ' . $resultat['company'] ?></p>
                            <a href="index.php?action=removeContacts&id=<?= $resultat['idContact'] ?>" class="card-link"> <img src="./img/icon/unfriend.png"> </a>
                        </div>
                    </div>
                </div>
                </a> <br>
            <?php else: ?>
                 <div class="card gedf-card">
                        <div class="card-body">
        
                            <h5 class="card-title"><img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="Photo de profil">&nbsp&nbsp&nbsp<form action="index.php?action=profilePage" method="POST"><input type="hidden" name="id" value="<?= $resultat['idContact'] ?>"> <input type="submit" class="btn btn-link" value="<?= $resultat['name'] . ' ' . $resultat['lastname'] ?>">  </form></h5>
                            <p class="card-text"><?= $resultat['job'] . ' chez ' . $resultat['company'] ?></p>
                            <a href="index.php?action=addContacts&id=<?= $resultat['idContact'] ?>" class="card-link"> <img src="./img/icon/users.png"> </a>
                
                   <?php endif;?>

                        </div>
                    </div>
            </div>
           
           <?php  
        endforeach;
 
    $content = ob_get_clean();
    require('view/template.php');
    ?>