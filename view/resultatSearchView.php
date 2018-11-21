
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
        </form>
    </nav>
    <br><br>
        <?php if($res == true): ?>       
        <?php foreach ($res as $resultat): ?>
            <a href="index.php?action=profilepage&id=<?= $resultat['idContact'] ?>"> <?= $resultat['name'] ?> <?= $resultat['lastname'] ?> <a href=""><img src="./img/icon/users.png"> </a>
            </a> <br>
        <?php endforeach; ?>
        <?php else:?>
            <?= $return ?>
        <?php endif; ?>

            <div class="card gedf-card">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                                card's content.</p>
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
            </div>

    <?php 
    $content = ob_get_clean();
    require('view/template.php');
    ?>