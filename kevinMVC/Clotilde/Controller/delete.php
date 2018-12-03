<?php
//PAGE DE SUPPRESSION DE COMPTE
	echo "<center><br><br><br><br><br><br><br><br><br><br>";
	echo "<h2>Êtes-vous sûr(e) de vouloir supprimer votre compte ?</h2>
	<form action='Controller/delete.php' method='POST'>
		<input type='hidden' name='id' value='".$_SESSION['id']."'>
        <button>Oui</button>
    </form>
    <form action='index.php?page=reception' method='GET'>
        <button>Non</button>
    </form>";
	if(isset($_SESSION['erreur']) && $_SESSION['erreur']!=="")
    {
        echo $_SESSION['erreur']."<br><br>";
        $_SESSION['erreur']="";
    }
    else
    {
        echo "<br><br>";
    }
	echo "</center>";
?>