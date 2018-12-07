<?php
//PAGE DE FONCTIONS DELETE_ALL SQL
	//SUPPRIMER COMMENTAIRES
	function delete_all_coms($bdd, $ID) {
		//rechercher les commentaires laissés par l'utilisateur
		$reponse=$bdd->prepare('SELECT com
								FROM coms, comment
								WHERE user=:ID AND com=coms.id');
		$reponse->execute(['ID'=>$ID]);
		$e=array();
		$m=0;
		while($donnees=$reponse->fetch()) {
			$e[$m]=$donnees['com'];
			$m++;
		}
		//supprimer les commentaires laissés par l'utilisateur
		for($m=0;$m<sizeof($e);$m++) {
			$reponse=$bdd->prepare('DELETE FROM comment
									WHERE com=:id');
			$reponse->execute(['id'=>$e[$m]]);
		}
		$reponse=$bdd->prepare('DELETE FROM coms
								WHERE user=:ID');
		$reponse->execute(['ID'=>$ID]);
	}
	//SUPPRIMER PUBLICATIONS
	function delete_all_publi($bdd, $ID) {
		//rechercher les publications écrits par l'utilisateur
		$reponse=$bdd->prepare('SELECT publication
								FROM post, publications
								WHERE user=:ID AND publication=publications.id');
		$reponse->execute(['ID'=>$ID]);
		$f=array();
		$n=0;
		while($donnees=$reponse->fetch()) {
			$f[$n]=$donnees['publication'];
			$n++;
		}
		//rechercher les commentaires laissés sur les publications écrits par l'utilisateur
		$g=array();
		$o=0;
		for($n=0;$n<sizeof($f);$n++) { 
			$reponse=$bdd->prepare('SELECT com
									FROM coms, comment, post
									WHERE post.publication=:id AND comment.publication=post.publication AND com=coms.id');
			$reponse->execute(['id'=>$f[$n]]);
			while($donnees=$reponse->fetch()) {
				$g[$o]=$donnees['com'];
				$o++;
			}
		}
		//supprimer les commentaires laissés sur les publications écrits par l'utilisateur
		for($o=0;$o<sizeof($g);$o++) {
			$reponse=$bdd->prepare('DELETE FROM comment
									WHERE com=:id');
			$reponse->execute(['id'=>$g[$o]]);
			$reponse=$bdd->prepare('DELETE FROM coms
								WHERE id=:id');
			$reponse->execute(['id'=>$g[$o]]);
		}
		//supprimer les publications écrits par l'utilisateur
		$reponse=$bdd->prepare('DELETE FROM post
								WHERE user=:ID');
		$reponse->execute(['ID'=>$ID]);
		for($n=0;$n<sizeof($f);$n++) {
			$reponse=$bdd->prepare('DELETE FROM publications
									WHERE id=:id');
			$reponse->execute(['id'=>$f[$n]]);
		}
	}
	//SUPPRIMER MESSAGES
	function delete_all_messages($bdd, $ID) {
		//rechercher les messages que l'utilisateur a envoyé
		$reponse=$bdd->prepare('SELECT privateMessage
								FROM sendPrivate, privateMessages
								WHERE user=:ID AND privateMessage=privateMessages.id');
		$reponse->execute(['ID'=>$ID]);
		$c=array();
		$k=0;
		while($donnees=$reponse->fetch()) {
			$c[$k]=$donnees['privateMessage'];
			$k++;
		}
		//rechercher les messages que l'utilisateur a reçu
		$reponse=$bdd->prepare('SELECT privateMessage
								FROM sendPrivate, privateMessages
								WHERE receiver=:ID AND privateMessage=privateMessages.id');
		$reponse->execute(['ID'=>$ID]);
		$d=array();
		$l=0;
		while($donnees=$reponse->fetch()) {
			$d[$l]=$donnees['privateMessage'];
			$l++;
		}
		//supprimer les messages que l'utilisateur a envoyé
		$reponse=$bdd->prepare('DELETE FROM sendPrivate
								WHERE user=:ID');
		$reponse->execute(['ID'=>$ID]);
		for($k=0;$k<sizeof($c);$k++) {
			$reponse=$bdd->prepare('DELETE FROM privateMessages
									WHERE id=:id');
			$reponse->execute(['id'=>$c[$k]]);
		}
		//supprimer les messages que l'utilisateur a reçu
		$reponse=$bdd->prepare('DELETE FROM sendPrivate
								WHERE receiver=:ID');
		$reponse->execute(['ID'=>$ID]);
		for($l=0;$l<sizeof($d);$l++) {
			$reponse=$bdd->prepare('DELETE FROM privateMessages
									WHERE id=:id');
			$reponse->execute(['id'=>$d[$l]]);
		}
	}
	//SUPPRIMER EVENEMENTS
	function delete_all_events($bdd, $ID) {
		//recherche les événements où l'utilisateur est l'administrateur
		/*$reponse=$bdd->prepare('SELECT events
								FROM participate, events
								WHERE admin=:ID AND event=events.id');
		$reponse->execute(['ID'=>$ID]);
		$b=array();
		$j=0;
		while($donnees=$reponse->fetch()) {
			$b[$j]=$donnees['event'];
			$j++;
		}*/
		//supprime l'utilisateur de la liste des membres d'un événement ou invitation
		$reponse=$bdd->prepare('DELETE FROM participate
								WHERE user=:ID');
		$reponse->execute(['ID'=>$ID]);
		//supprime les événements où il est l'administrateur
		/*for($j=0;$j<sizeof($b);$j++) { 
			$reponse=$bdd->prepare('DELETE FROM events
									WHERE id=:id');
			$reponse->execute(['id'=>$b[$j]]);
		}*/
	}
	//SUPPRIMER GROUPES
	function delete_all_groups($bdd, $ID) {
		//recherche les groupes où l'utilisateur est l'administrateur
		/*$reponse=$bdd->prepare('SELECT group
								FROM groupAdd, groups
								WHERE admin=:ID AND group=groups.id');
		$reponse->execute(['ID'=>$ID]);
		$a=array();
		$i=0;
		while($donnees=$reponse->fetch()) {
			$a[$i]=$donnees['group'];
			$i++;
		}*/
		//supprime l'utilisateur en tant que membre d'un groupe ou invitation
		$reponse=$bdd->prepare('DELETE FROM groupAdd
								WHERE user=:ID');
		$reponse->execute(['ID'=>$ID]);
		//supprime les groupes où il est administrateur
		/*for($i=0;$i<sizeof($a);$i++) { 
			$reponse=$bdd->prepare('DELETE FROM groups
									WHERE id=:id');
			$reponse->execute(['id'=>$a[$i]]);
		}*/
	}
	//SUPPRIMER CONTACTS
	function delete_all_contacts($bdd, $ID) {
		//supprime les contacts de l'utilisateur
		$reponse=$bdd->prepare('DELETE FROM contacts
								WHERE user=:ID OR contact=:ID');
		$reponse->execute(['ID'=>$ID]);
	}
	//SUPPRIMER UTILISATEUR
	function delete_user($bdd, $ID) {
		//supprime l'utilisateur
		$reponse=$bdd->prepare('DELETE FROM users
								WHERE id=:ID');
		$reponse->execute(['ID'=>$ID]);
	}
?>