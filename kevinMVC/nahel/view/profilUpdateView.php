
<?php 
$title = "Modifier son profil";
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
    </nav>

     <!--- \\\\\\\Post-->
        <div class="card gedf-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mr-2">
                        <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="Photo de profil">
                    </div>
                    <div class="ml-2">
                        <div class="h5 m-0">Kévin Barao Da Silva</div>
                        </div>
                    </div>                    

            <form class="form-signin" action="index.php?action=profilemodif&id=<?= $_SESSION['id'] ?>" method="POST">
                <div class="form-label-group">
                    <label for="">Nom</label>
                    <input type="text"  name="newname" placeholder="<?= $recup['nom'] ?>" required >
                </div>

                <div class="form-label-group">
                    <label for="">Prenom</label>
                    <input type="text"  name="newsurname" placeholder="<?= $recup['prenom'] ?>" required >
                </div>

                <div class="form-label-group">
                    <label for="">email</label>
                    <input type="mail"  name="newmail" placeholder="<?= $recup['naissance'] ?>" required >
                </div>

                <div class="form-label-group">
                    <label for="">Telephone</label>
                    <input type="text"  name="newphone" placeholder="<?= $recup['prenom'] ?>" required >
                </div>
                
                <div class="form-label-group">
                    <label for="">Role  : </label>
                    <input type="radio"  name="newrole" value="1"required>Chef
                    <input type="radio"  name="newrole" value="2"required>Delegue
                </div>

                <input class="btn btn-lg btn-primary btn-block" type="submit" value="Modifier" >
            </form>

            <div class="col-md-3">
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
        </div>
    </div>
    <?php 
    $content = ob_get_clean();
    require('view/template.php');
    ?>