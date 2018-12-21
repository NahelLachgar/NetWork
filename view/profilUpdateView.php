
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
      <div class="py-2 text-center">
        <h2>Modifiez mon profil</h2>
        <p class="lead"></p>
      </div>

      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">

        </div>
        <div class="col-md-12 order-md-1">
          <form enctype="multipart/form-data" action="index.php?action=profilemodif" method="POST">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="row justify-content-center">
                    <div class="col-md-12-center">
                        <button class="btn btn-link" id="photoUpdate">
                            <img class="rounded-circle" width="100" src="./img/profile/<?= $recup['photo'] ?>" alt="Photo de profil">
                        </button>
                    <input style="display:none" type="file" class="form-control-file" name="photo" id="photoUpdateFile"> 
                    </div>
                </div>   
            </div>
        </div>        
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
    jQuery(function($){
        $('#photoUpdateFile').click(function(e){
        });
         
        $('#photoUpdate').click(function(e){
            $('#photoUpdateFile').trigger('click'); // équivalent de  $('#lien1').click();
        });
    });
    </script>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="newName">Prénom</label>
                <input type="text" class="form-control" id="newName" name="newsurname" value="<?= $recup['name'] ?>" required>
                <div class="invalid-feedback">
                  Entrez votre prénom.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Nom</label>
                <input type="text" class="form-control" id="lastName" value="<?= $recup['lastName'] ?>" name="newname" required>
                <div class="invalid-feedback">
                  Entrez votre nom.
                </div>
              </div>
            </div>
        <div class="row">
            <div class="col-md-6 mb-3">
              <label for="email">Adresse e-mail</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">@</span>
                </div>
                <input type="email" class="form-control" id="email" name="newmail" value="<?= $recup['email'] ?>" required>
                <div class="invalid-feedback" style="width: 100%;">
                  Entrez votre adresse e-mail.
                </div>
              </div>
              <span id="aideCourriel"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label for="phone">Numéro de téléphone</label>
              <input type="text" class="form-control" id="phone" name="newphone" value="<?= $recup['phone'] ?>"  required>
              <div class="invalid-feedback">
                Entrez votre numéro de téléphone.
              </div>
              <span id="aidePhone"></span>
            </div>
        </div>
            <hr class="mb-4">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="mdp">Mot de passe</label>
                <input type="password" class="form-control" id="mdp" name="newPass" required>
                <div class="invalid-feedback">
                  Entrez un mot de passe.
                </div>
              </div>
              <div class="col-md-6 mb-3">
               <label for="mdp2">Confirmation du mot de passe</label>
                <input type="password" class="form-control" id="mdp2" name="confirmNewPass" required>
                <div class="invalid-feedback">
                  Rentrez de nouveau le mot de passe.
                </div>
              </div>
            </div>
            <hr class="mb-4">
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="emploi">Emploi</label>
              <input type="text" class="form-control" id="emploi" name="newjob" value="<?= $recup['job'] ?>" required>
              <div class="invalid-feedback">
                Entrez votre profession.
              </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="entreprise">Entreprise</label>
                <input type="text" name="newcompany" value="<?= $recup['company'] ?>" class="form-control" id="company" required>
                <div class="invalid-feedback">
                  Entrez votre nom d'entreprise.
                </div>
              </div>
            <div class="col-md-4 mb-3">
              <label for="ville">Ville</label>
              <input type="text" class="form-control" id="town" name="newtown" value="<?= $recup['town'] ?>" required>
              <div class="invalid-feedback">
                Entrez votre ville.
              </div>
            </div>
        </div>
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-lg btn-block" name="SignIn" type="submit">Modifier</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    </div>

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
    $content = ob_get_clean();
    require('view/template.php');
    ?>