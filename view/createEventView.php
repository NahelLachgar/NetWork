<?php
    //PAGE DE CREATION D'UN EVENEMENT
    $title="Créer un événement";
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

<div class="container">
    <div class="py-2 text-center">
        <h2>Créer un événement</h2>
        <p class="lead"></p>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
        </div>
        <div class="col-md-12 order-md-1">
            <form enctype="multipart/form-data" action="index.php?action=createEvent" method="POST">
                <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                <div class="row justify-content-center">
                    <div class="col-md-6 mb-3">
                        <label for="title">Nom</label>
                        <input type="text" class="form-control" id="title" name="title" require_onced>
                        <div class="invalid-feedback">
                            Nommez votre événement.
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 mb-3">
                        <label for="eventDate">Date</label>
                        <input type="date" class="form-control" id="eventDate" name="eventDate" placeholder="YYYY-MM-JJ HH:MM:SS" require_onced>
                        <div class="invalid-feedback">
                            Fixez une date.
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 mb-3">
                        <label for="place">Lieu de rendez-vous</label>
                        <input type="text" class="form-control" id="place" name="place">
                        <div class="invalid-feedback">
                            Donnez une adresse.
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Créer">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<form enctype="multipart/form-data" action="index.php" method="GET">
    <input type="hidden" name="action" value="showEvents">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Retour">
        </div>
    </div>
</form>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/popper.min.js"></script>
<script src="https://getbootstrap.com/docs/4.1/dist/js/bootstrap.min.js"></script>
<script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/holder.min.js"></script>
<script src="./js/event.js"></script>
<?php
    $content=ob_get_clean();
    require_once('view/template.php');
?>