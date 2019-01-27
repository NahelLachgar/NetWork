<?php
    //PAGE DE SUPPRESSION DE COMPTE
    $title="Supprimer le compte";
    ob_start();
?>
<!-- PROFIL-->
<div class="container-fluid gedf-wrapper">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
<?php
if($_SESSION['state']=='activated') {
    echo "<div class='h5'>";
}
else if($_SESSION['state']=='disabled') {
    echo "<div class='h5' style='color:#798081;'>";
}
?>
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
if($_SESSION['state']=="activated") {
    echo "<h2>Ou préférez-vous plutôt désactiver votre compte ?</h2>";
}
else if($_SESSION['state']=='disabled') {
    echo "<h2>Ou préférez-vous plutôt activer votre compte ?</h2>";
}
?>
                    <p class="lead"></p>
                </div>
                <div class="row">
                    <div class="col-md-12 order-md-1">
                        <form enctype="multipart/form-data" action="index.php?action=desactivateAccount" method="POST">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
<?php
if($_SESSION['state']=="activated") {
    echo "<input type='submit' class='btn btn-primary btn-lg btn-block' name='submit' value='Désactiver'>";
}
else if($_SESSION['state']=='disabled') {
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