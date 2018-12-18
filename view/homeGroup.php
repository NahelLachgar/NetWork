<?php 
$title = "Groupe";
ob_start();
?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/group.css" />
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <SCRIPT LANGUAGE="JavaScript" SRC="js/group.js"></SCRIPT>       

 
<a class="trigger_popup_fricc"><button class="btn btn-link">Creer un groupe</button></a>

<div class="hover_bkgr_fricc">
    <span class="helper"></span>
    <div>
        <div class="popupCloseButton">X</div>
        <center><form name="form" action="index.php?action=createGroup" method="POST">
            <div class="row">
              <div class="mb-3">
                <label for="name">Nom du groupe</label>
                <input type="text" class="form-control" id="name" name="nameG" placeholder="" required>
                <div class="invalid-feedback">
                  
                </div>
                <span id="aideName"></span>
              </div>
        
            </div>
        </form> <button class="btn btn-primary btn-lg btn-block" name="creer" type="submit">Creer</button></center>
    </div>
 
</div>

<?php 
    $content = ob_get_clean();
    require('view/template.php');
?>