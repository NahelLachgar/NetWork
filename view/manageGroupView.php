<?php 
$title = "Groupe";
ob_start();
?>


<div class="container">
      <div class="py-12 text-center">
        <img class="d-block mx-auto mb-4" src="" alt="" width="72" height="72">
        <h2>Modification groupe</h2>
        <p class="lead"></p>
      </div>

      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">

        </div>
        <div class="col-md-12 order-md-1">
        
          <form action="index.php?action=updateGroup" method="POST">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="lastName">Nom</label>
                <input type="text" class="form-control" id="groupName" placeholder="" name="groupeName">
                <div class="invalid-feedback">
                  Entrez votre nom.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="admin">Changer d'admin:</label><br>
                <select id="admin" name="admin">
                    <?php foreach( $res as $member) :?>
                        <option value="<?=$member['id']?>"><?= $member['name']." ".$member['lastName'] ?> </option>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>

          <!--  <hr>
                <div class="row">
                        <?php foreach( $res as $member) :?>
                        <div class="col-md-2 mb-3">
                                <?= $member['name']." ".$member['lastName'] ?> 
                                <form action="index.php?action=removeToGroups" method="POST">
                                    <input type="hidden" name="contactId" value="<?=$member['id']?>">
                                    <input type="hidden" name="groupId" value="<?= $idGroup ?>">
                                    <button type="submit" class="btn btn-link">retirer du groupe</button>
                                </form>
                                </div>
                        <?php endforeach; ?>
                </div> -->
           
          <div class="row justify-content-center">
              <div class="col-md-3">
                  <button class="btn btn-primary btn-lg btn-block" name="SignIn" type="submit">Modifier</button>
              </div>
          </form>
    
          <div class="col-md-3">
                <form action="index.php?action=deleteGroup" method="POST">
                    <input type="hidden" name="groupeId" value="">
                  <button class="btn btn-danger btn-lg btn-block" type="submit">Supprimer</button>
                </form>
              </div>
          </div>
        </div>
      </div>

    </div>




<?php 
    $content = ob_get_clean();
    require('view/template.php');
?>