<?php
    //PAGE DE SUPPRESSION DE COMPTE
    $title="Supprimer le compte";
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

<!-- PROFIL-->
<div class="container-fluid gedf-wrapper">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="h5">
                    <img class="rounded-circle" width="45"src="./img/profile/<?= $profile['photo'] ?>" alt="" />&nbsp&nbsp&nbsp
                    <?= $profile['name'] . ' ' . $profile['lastName'] ?></div>
                    <div class="h7">
                        <?= $profile['job'] . ' chez ' . $profile['company'] ?>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=companyList">Entreprises</a></div>
                        <div class="h5"><?= $followedCompaniesNb ?></div>
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=contactList">Contacts</a></div>
                        <div class="h5"><?= $contactsNb ?></div>
    
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=updateProfile">Modifier le profil</a></div>
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=deleteView">Supprimer le compte</a></div>
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=disconnect">Déconnexion</a></div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 gedf-main">

            <div class="container">
                <div class="py-2 text-center">
                    <h2>Êtes-vous sûr(e) de vouloir supprimer votre compte ?</h2>
                    <p class="lead"></p>
                </div>

                <div class="row">
                    <div class="col-md-12 order-md-1">
                        <form enctype="multipart/form-data" action="index.php" method="GET">
                            <input type="hidden" name="action" value="deleteAccount">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Supprimer">
                                </div>
                            </div>
                        </form>
                        <div class="col-md-4 order-md-2 mb-4">
                        </div>
                    </div>
                </div>
                <div class="py-2 text-center">
<?php
if($state=="activated") {
    echo "<h2>Ou préférez-vous plutôt désactiver votre compte ?</h2>";
}
else if($state=="disabled")
{
    echo "<h2>Ou préférez-vous plutôt activer votre compte ?</h2>";
}
?>
                    <p class="lead"></p>
                </div>
                <div class="row">
                    <div class="col-md-12 order-md-1">
                        <form enctype="multipart/form-data" action="index.php?action=desactivateAccount" method="POST">
<?php
    echo "<input type='hidden' name='active' value='".$state."'>";
?>
                            <div class="row justify-content-center">
                                <div class="col-md-6">
<?php
if($state=="activated") {
    echo "<input type='submit' class='btn btn-primary btn-lg btn-block' name='submit' value='Désactiver'>";
}
else if($state=="disabled")
{
    echo "<input type='submit' class='btn btn-primary btn-lg btn-block' name='submit' value='Activer'>";
}
?>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-4 order-md-2 mb-4">
                        </div>
<?php
    if(isset($_SESSION['erreur']) && $_SESSION['erreur']!=="") {
        echo "<center>".$_SESSION['erreur']."</center>";
        $_SESSION['erreur']="";
    }
    else {
        echo "<br/>";
    }
?>
                        <div class="col-md-4 order-md-2 mb-4">
                        </div>
                        <form enctype="multipart/form-data" action="index.php" method="GET">
                            <input type="hidden" name="action" value="home">
                            <div class="row justify-content-center">
                                <div class="col-md-7">
                                    <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Retour">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    $content=ob_get_clean();
    require_once('view/template.php');
?>