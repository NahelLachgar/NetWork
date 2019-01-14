
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>Inscription</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.1/examples/checkout/form-validation.css" rel="stylesheet">
  </head>

  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="" alt="" width="72" height="72">
        <h2>Inscription</h2>
        <p class="lead"></p>
      </div>
      <?php if(!empty($errors)) : ?>
      <div class="alert alert-danger">
         <?php foreach($errors as $error): ?>
            <p><?= $error ; ?></p>
          <?php endforeach ; ?>
      </div>     
    <?php endif; ?>
      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">

        </div>
        <div class="col-md-12 order-md-1">
        
          <form name="form" enctype="multipart/form-data" action="index.php?action=addUser" method="POST">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">Prenom</label>
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="" include_onced>
                <div class="invalid-feedback">
                  Entrez votre prenom .
                </div>
                <span id="aideName"></span>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Nom</label>
                <input type="text" class="form-control" id="lastName" placeholder="" name="lastName" include_onced>
                <div class="invalid-feedback">
                  Entrez votre nom.
                </div>
                <span id="aideLname"></span>
              </div>
            </div>

            <div class="mb-3">
              <label for="email">Adresse email</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">@</span>
                </div>
                <input type="email" class="form-control" id="email" placeholder="you@example.com" name="email" include_onced>
                <div class="invalid-feedback" style="width: 100%;">
                  Entrez votre adresse mail.
                </div>
              </div>
              <span id="aideCourriel"></span>
            </div>

            <div class="mb-3">
              <label for="phone">Numero de telephone</label>
              <input type="text" class="form-control" id="phone" name="phone" include_onced>
              <div class="invalid-feedback">
                Entrez votre numero de telephone.
              </div>
              <span id="aidePhone"></span>
            </div>

            <div class="mb-3">
                <label for="file">Avatar</label>
                <input type="file" class="form-control-file" name="photo" id="file">
            </div>
            <hr class="mb-4">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="mdp">Mot de passe</label>
                <input type="password" class="form-control" id="mdp" name="password" include_onced>
                <div class="invalid-feedback">
                  Entrez un mot de passe.
                </div>
              </div>
              
              <div class="col-md-6 mb-3">
               <label for="mdp2">Confirmation du mot de passe</label>
                <input type="password" class="form-control" id="mdp2" name="confirmPassword" /*onclick="password()"*/ include_onced>
                <div class="invalid-feedback">
                  Entrez votre mot de passe.
                </div>
              </div>
              <span id="aidePass"></span>
            </div>
            <hr class="mb-4">
            <div class="row">
              <div class="col-md-3 mb-3">
                <label for="Status">Statut</label>
                <select name="status" class="custom-select d-block w-100" id="Status" include_onced>
                  <option value="">Choisissez un statut</option>
                  <option value="1">entreprise</option>
                  <option value="2">employé</option>
                </select>
                <div class="invalid-feedback">
                  Selectionnez votre statut.
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="job">Emploi</label>
              <input type="text" class="form-control" id="job" name="job" include_onced>
              <div class="invalid-feedback">
                Entrez votre profession.
              </div>
              <span id="aideJob"></span>
              </div>
              <div class="col-md-5 mb-3">
                <label for="entreprise">Entreprise</label>
                <input type="text" name="company" class="form-control" id="company" include_onced>
                <div class="invalid-feedback">
                  Entrez votre d'entreprise de travail.
                </div>
                <span id="aideCompany"></span>
              </div>
            </div>
            <div class="mb-3">
              <label for="ville">Ville</label>
              <input type="text" class="form-control" id="town" name="town" include_onced>
              <div class="invalid-feedback">
                Entrez votre ville.
              </div>
              <span id="aideTown"></span>
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" name="SignIn" type="submit">S'inscire</button>
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
  </body>
</html>