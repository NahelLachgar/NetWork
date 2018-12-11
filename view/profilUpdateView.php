
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
      <!--  <div class="card gedf-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="ml-2">
                        <div class="h5 m-0"><?= $recup['lastname'] ?> <?= $recup['name'] ?></div>
                        </div>
                    </div> -->

<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-5">
            <form class="form-label-group" action="index.php?action=profilemodif" method="POST">
                <div>
               <p> <img class="rounded-circle" width="100" src="https://picsum.photos/50/50" alt="Photo de profil"></p>        
                </div>
                <div class="form-label-group">
                    <label for="newName">Nom</label>
                    <input type="text"  name="newname" id="newName" value="<?= $recup['lastName'] ?>" required >
                </div>

                <div class="form-label-group">
                    <label for="">Prenom</label>
                    <input type="text"  name="newsurname" value="<?= $recup['name'] ?>" required >
                </div>

                <div class="form-label-group">
                    <label for="">email</label>
                    <input type="mail"  name="newmail" value="<?= $recup['email'] ?>" required >
                </div>

                <div class="form-label-group">
                    <label for="">Mot de passe</label>
                    <input type="password"  name="newPass" required >
                </div>

                 <div class="form-label-group">
                    <label for="">Confirmez le mot de passe</label>
                    <input type="password"  name="confirmNewPass" required >
                </div>

                <div class="form-label-group">
                    <label for="">Telephone</label>
                    <input type="text"  name="newphone" value="<?= $recup['phone'] ?>" required >
                </div>

                 <div class="form-label-group">
                    <label for="">Emploi</label>
                    <input type="text"  name="newjob" value="<?= $recup['job'] ?>" required >
                </div>

                <div class="form-label-group">
                    <label for="">Entreprise</label>
                    <input type="text"  name="newcompany" value="<?= $recup['company'] ?>" required >
                </div>

                <div class="form-label-group">
                    <label for="">Ville</label>
                    <input type="text"  name="newtown" value="<?= $recup['town'] ?>" required >
                </div>

                <input class="btn btn-md btn-primary" type="submit" value="Modifier" >
            </form>
        </div>
    </div>
</div>



    <?php 
    $content = ob_get_clean();
    require('view/template.php');
    ?>