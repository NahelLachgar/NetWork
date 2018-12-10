<?php
//PAGE DE FONCTIONS EVENT SQL
	//AFFICHER EVENEMENTS AYANT POUR PARTICIPANT L'UTILISATEUR
	function selectMember($bdd, $ID)
	{
		//rechercher les événements propres à l'utilisateur en tant que participant
		$reponse=$bdd->prepare('SELECT event, title
								FROM events, participate
								WHERE user=:ID AND event=events.id AND admin!=user');

		$reponse->execute(['ID'=>$ID]);
		$a=false;
		$i=0;
		while($donnees=$reponse->fetch())
		{
			$a[$i][0]=$donnees['event'];
			$a[$i][1]=$donnees['title'];
			$i++;
		}
		return $a;
	}
	//AFFICHER EVENEMENTS AYANT POUR ADMINISTRATEUR L'UTILISATEUR
	function selectAdmin($bdd, $ID)
	{
		//rechercher les événements administrateurs
		$reponse=$bdd->prepare('SELECT id, title
								FROM events
								WHERE admin=:ID');
		$reponse->execute(['ID'=>$ID]);
		$b=false;
		$j=0;
		while($donnees=$reponse->fetch())
		{
			$b[$j][0]=$donnees['id'];
			$b[$j][1]=$donnees['title'];
			$j++;
		}
		return $b;
	}
	//AFFICHER INFORMATIONS DE L'EVENEMENT
	function infoEvent($bdd, $id)
	{
		//récupérer les informations de cet événement
		$reponse=$bdd->prepare('SELECT title, eventDate, place
								FROM events
								WHERE id=:id');
		$reponse->execute(['id'=>$id]);
		$a=array();
		while($donnees=$reponse->fetch())
		{
			$a[0]=$donnees['title'];
			$a[1]=$donnees['eventDate'];
			$a[2]=$donnees['place'];
		}
		return $a;
	}
	//AFFICHER LISTE CONTACTS D'UN UTILISATEUR NE PARTICIPANT PAS
	function infoContact($bdd, $id, $ID)
	{
		//récupérer les contacts de l'utilisateur qui ne font pas partis de cet événement
		$reponse=$bdd->prepare('SELECT users.id AS id, lastName, name
								FROM users, contacts
								WHERE contact=:ID AND users.id=user
								AND users.id NOT IN (SELECT user
													FROM participate
													WHERE event=:id)');
		$reponse->execute(['ID'=>$ID,
							'id'=>$id]);
		$a=array();
		$i=0;
		while($donnees=$reponse->fetch())
		{
			$a[$i][0]=$donnees['id'];
			$a[$i][1]=$donnees['lastName'];
			$a[$i][2]=$donnees['name'];
			$i++;
		}
		return $a;
	}
	//CREER EVENEMENT
	function create($bdd, $ID, $title, $eventDate, $place)
	{
		//créer l'évenement avec l'utilisateur en tant qu'administrateur
		$reponse=$bdd->prepare('INSERT INTO `events` (title, eventDate, place, admin)
								VALUES (:title, :eventDate, :place, :ID)');
		$reponse->execute(['title'=>$title,
							'eventDate'=>$eventDate,
							'place'=>$place,
							'ID'=>$ID]);
		//chercher l'id du nouvel évenement créé
		$reponse=$bdd->prepare('SELECT id
								FROM events
								WHERE admin=:ID');
		$reponse->execute(['ID'=>$ID]);
		while($donnees=$reponse->fetch())
		{
			$c=$donnees['id'];
		}
		//ajouter l'utilisateur en tant que participant
		$reponse=$bdd->prepare('INSERT INTO `participate` (user, event)
								VALUES (:ID, :event)');
		$reponse->execute(['ID'=>$ID,
						'event'=>$c]);
	}
	//AFFICHER ADMINISTRATEUR
	function checkAdmin($bdd, $id)
	{
		//chercher l'administrateur de cet événement
		$reponse=$bdd->prepare('SELECT admin
								FROM events
								WHERE id=:id');
		$reponse->execute(['id'=>$id]);
		while($donnees=$reponse->fetch())
		{
			$a=$donnees['admin'];
		}
		//récupérer le nom et prénom de l'administrateur
		$reponse=$bdd->prepare('SELECT lastName, name
								FROM users
								WHERE id=:admin');
		$reponse->execute(['admin'=>$a]);
		while($donnees=$reponse->fetch())
		{
			$b[0]=$donnees['lastName'];
			$b[1]=$donnees['name'];
		}
		return $b;
	}
	//AFFICHER PARTICIPANTS
	function checkParticipate($bdd, $id)
	{
		////récupérer les noms et prénoms des participants de cet événement
		$reponse=$bdd->prepare('SELECT user, lastName, name
								FROM events, participate, users
								WHERE events.id=event AND user=users.id AND user!=admin AND event=:id
								ORDER BY lastName, name');
		$reponse->execute(['id'=>$id]);
		$c=false;
		$i=0;
		while($donnees=$reponse->fetch())
		{
			$c[$i][0]=$donnees['user'];
			$c[$i][1]=$donnees['lastName'];
			$c[$i][2]=$donnees['name'];
			$i++;
		}
		return $c;
	}
	//QUITTER EVENEMENT
	function quit($bdd, $ID, $id)
	{
		//supprimer la participation de l'utilisateur dans cet événement
		$reponse=$bdd->prepare('DELETE FROM participate
								WHERE user=:ID AND event=:id');
		$reponse->execute(['ID'=>$ID,
							'id'=>$id]);
	}
	//SUPPRIMER EVENEMENT
	function delete($bdd, $ID)
	{
		//supprimer la participation des participants de cet événement
		$reponse=$bdd->prepare('DELETE FROM participate
								WHERE event=:ID');
		$reponse->execute(['ID'=>$ID]);
		//supprimer l'événement
		$reponse=$bdd->prepare('DELETE FROM events
								WHERE id=:ID');
		$reponse->execute(['ID'=>$ID]);
	}
	//MODIFIER EVENEMENT
	function update($bdd, $id, $title, $eventDate, $place)
	{
		//modifier le titre, la date et l'emplacement de l'événement
		$reponse=$bdd->prepare('UPDATE events
								SET title=:title, eventDate=:eventDate, place=:place
								WHERE id=:ID');
		$reponse->execute(['title'=>$title,
							'eventDate'=>$eventDate,
							'place'=>$place,
							'ID'=>$id]);
	}
	//AJOUTER PARTICIPANT
	function add($bdd, $user, $event)
	{
		//ajouter la participation de l'utilisateur dans cet événement
		$reponse=$bdd->prepare('INSERT INTO participate (user, event)
								VALUES (:user, :event)');
		$reponse->execute(['user'=>$user,
							'event'=>$event]);
	}
	/*function join($bdd, $ID)
	{
		//ajouter la participation de l'utilisateur dans cet événement
	}
	function decline($bdd, $ID)
	{
		//décliner la participation de l'utilisateur dans cet événement
	}*/
?>