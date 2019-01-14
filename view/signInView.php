<!-- <!DOCTYPE html>
<html>
<head>
	<title>Connection</title>
</head>

<body>
	<center>
		<h1>Se connecter</h1>
		<form action="?action=checkUser" method="POST">
			<input type="mail" name="email" placeholder="email" include_onced><br>
			<input type="password" name="password" placeholder="Mot de passe" include_onced><br>
			<input type="submit" name="SignUp" value="Se connecter"><br>
		</form>
		<a href="index.php?action=signUp">Inscrivez-vous</a>
	</center>
</body>

</html>

-->


<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Connexion</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.0/examples/sign-in/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
  <div class="container">
    <div class="row">
    <form class="form-signin" action="?action=checkUser" method="POST">
      <img class="lg-4" src="./img/logo/logo.png" alt="" width="250" height="250">
      <h1 class="h3 mb-3 font-weight-normal">Connectez-vous !</h1>

      <?php if(!empty($errors)) : ?>
        <div class="alert alert-danger">
           <?php foreach($errors as $error): ?>
              <p><?= $error ; ?></p>
            <?php endforeach ; ?>
        </div>     
      <?php endif; ?>

      <label for="inputEmail" class="sr-only">Adresse mail</label>
      <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Adresse mail" include_onced autofocus>
      <label for="inputPassword" class="sr-only">Mot de passe</label>
      <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Mot de passe" include_onced>
    <button class="btn btn-lg btn-primary btn-block" name="SignUp" type="submit">Se connecter</button>
    Afficher le mot de passe <input type="checkbox" id="showPass"><br>
    <a href="index.php?action=signUpEmployee">Inscrivez-vous en tant que membre</a>
    <a href="index.php?action=signUpCompany">Inscrivez-vous en tant qu'entreprise</a>
  </form>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  </body>
</html>
<script>
var checkbox = $("#showPass");
        var password = $("#inputPassword");
        checkbox.click(function() {
            if(checkbox.prop("checked")) {
                password.prop("type", "text");
            } else {
                password.prop("type", "password");
            }
        });

</script>