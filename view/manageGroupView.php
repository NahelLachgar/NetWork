<?php 
$title = "Groupe";
ob_start();
?>


<div class="container">
      <div class="py-12 text-center">
        <h2>Modification groupe</h2>
        <p class="lead"></p>
      </div>
        <br>
      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">

        </div>
        <div class="col-md-12 order-md-1">
        
          <form action="index.php?action=updateGroup" method="POST">
            <div class="row justify-content-center">
              <div class="col-md-3 mb-3">
                <label for="lastName">Nom</label>
                <input type="text" class="form-control" id="groupName" placeholder="" name="groupName" value="<?= $group[0]['title'] ?>">
              </div>
              <div class="col-md-3 mb-3">
                <label for="admin">Changer d'admin:</label><br>
                <select id="admin" class="form-control" name="admin">
                    <option value="<?= $_SESSION['id'] ?>" selected>Vous</option>
                    <?php foreach( $res as $member) :?>
                        <option value="<?=$member['id']?>"><?= $member['name']." ".$member['lastName'] ?> </option>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>

            <input type="hidden" name="groupId" value="<?= $group[0]['id'] ?>">

          <div class="row justify-content-center">
              <div class="col-md-3">
                  <button class="btn btn-primary btn-lg btn-block" name="update" type="submit">Modifier</button>
              </div>       
          </form>
    
          <div class="col-md-3">
                <form action="index.php?action=deleteGroup" method="POST">
                    <input type="hidden" name="groupId" value="<?= $group[0]['id'] ?>">
                  <button class="btn btn-danger btn-lg btn-block" name="delete" type="submit">Supprimer ce groupe</button>
                </form>
              </div>
        </div>
              <hr>
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
            </div> 
          </div>
        </div>
      </div>

    </div>




<?php 
    $content = ob_get_clean();
    require('view/template.php');
?>