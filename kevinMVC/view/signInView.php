<!-- <!DOCTYPE html>
<html>
<head>
	<title>Connection</title>
</head>

<body>
	<center>
		<h1>Se connecter</h1>
		<form action="?action=checkUser" method="POST">
			<input type="mail" name="email" placeholder="email" required><br>
			<input type="password" name="password" placeholder="Mot de passe" required><br>
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
    <link rel="icon" href="../../../../favicon.ico">

    <title>Connexion</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.0/examples/sign-in/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
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
      <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Adresse mail" required autofocus>
      <label for="inputPassword" class="sr-only">Mot de passe</label>
      <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Mot de passe" required>
	  <button class="btn btn-lg btn-primary btn-block" name="SignUp" type="submit">Se connecter</button>
	  <a href="index.php?action=signUp">Inscrivez-vous</a>
	</form>
	
  </body>
</html>
