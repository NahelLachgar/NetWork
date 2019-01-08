<?php 
$title = "Messages";
ob_start();
?>
<script>


function filter() {

// ON DÉCLARE LES VARIABLES
  var input, filter, ul, li, a, i, txtValue;
  input = document.getElementById('contactSearch');
  filter = input.value.toUpperCase();
  ul = document.getElementById("contactList");
  li = ul.getElementsByTagName('li');

// ON PARCOURE LE TABLEAU EN MASQUANT CEUX QUI NE CORRESPONDENT PAS À LA RECHERCHE
  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByTagName("p")[0];
    txtValue = a.textContent || a.innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
    } else {
      li[i].style.display = "none";
    }
  }
}
</script>
<div id="frame">
	<div id="sidepanel">
		<div id="profile">
			<div class="wrap">
			
				<img id="profile-img" src="./img/profile/<?= $userProfile['photo'] ?>" class="online rounded-circle" width="45" alt="" />
				<p><?= $userProfile['name'] . ' ' . $userProfile['lastName'] ?></p>
			</div>
		</div>
		<div id="search">
			<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
			<input id="contactSearch" onkeyup="filter()" type="text" placeholder="Recherchez un contact..." />
		</div>
		<div id="contacts">
			<ul id="contactList">
			<?php for ($i = 0; $i < count($contactProfile); $i++) : ?>
			<a class="contactLink" style="text-decoration:none;color:white" href='index.php?action=showMessages&contactId=<?=$contactProfile[$i]['id']?>'>

				<li class="contact">
					<div class="wrap">
						<span class="contact-status online"></span>
						<img class="rounded-circle" width="45"src="./img/profile/<?= $contactProfile[$i]['photo'] ?>" alt="" />
						<div class="meta">
						<p class="name"><?= $contactProfile[$i]['name'] . ' ' . $contactProfile[$i]['lastName'] ?></p>
						</div>
					</div>
				</li>
			</a>		
		<?php endfor;	
				 for ($i = 0; $i < count($groups); $i++) : ?>
			<a class="contactLink" style="text-decoration:none;color:white" href='index.php?action=showMessages&contactId=<?=$contactProfile[$i]['id']?>'>

				<li class="contact">
					<div class="wrap">
						<span class="contact-status online"></span>
						<img class="rounded-circle" width="45"src="./img/profile/<?= $userProfile['photo'] ?>" alt="" />
						<div class="meta">
						<p class="name"><?= $groups[$i]['title']?></p>
						</div>
					</div>
				</li>
			</a>		
				<?php endfor ?>	
			</ul>
		</div>
		
	</div>
	<div class="content">
		<div class="contact-profile">
		<img class="rounded-circle" width="45"src="./img/profile/<?= $receiverProfile['photo'] ?>" alt="" />
			<p><?= $receiverProfile['name'] . ' ' . $receiverProfile['lastName'] ?></p>
        </div>
        
		<div class="messages">
			<ul id="messages">
			 <?php 
			while ($messagesFetch = $messages->fetch()) :
				if ($messagesFetch['sender'] == $_SESSION['id']) {
				$class = "sent";
			} else {
				$class = "replies";
			}
			?>
				<li id="<?= $messagesFetch['id'] ?>" class=<?= $class ?>>
				<?php if($messagesFetch['sender']==$_SESSION['id']):?>
					<img src="./img/profile/<?=$userProfile['photo']?>" alt="">
				<?php else:?>
				<img src="./img/profile/<?=$receiverProfile['photo']?>" alt="">
				<?php endif?>
					<p><?= $messagesFetch['content'] ?></p>
				</li>
                    <?php endwhile ?>
			</ul>
		</div>
		<div class="message-input">
			<div class="wrap">
			<form>
				<input type="text" name="content" id="content" placeholder="Écrivez votre message" />
				<input type="hidden" name="contactId" id="contactId" value=<?= $_GET['contactId'] ?>>
				<i class="fa fa-paperclip attachment" aria-hidden="true"></i> 
				<button type="button" id="send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</form>
			</div>
		</div>    
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
	
	function load() {
				setInterval(function(){
				var lastId = $('#messages li:last').attr('id');
				var contactId = $('#contactId').val();
				$.ajax({
					url : "view/load.php",
					type : "POST",
					data : "contactId=" + contactId + "&messageId=" + lastId,
					dataType:"html",
					success : function(html){
						$('.messages ul').append(html);
					}
				});
			},1000)
	}
			load();

	$('#send').click(function(e){
			var content = $('#content').val();
			var contactId = $('#contactId').val();
			if ($.trim(content) != "") {			
				$.ajax({
				url : "view/send.php", // on donne l'URL du fichier de traitement
				type : "POST", // la requête est de type POST
				data : "content=" + content + "&contactId=" + contactId // et on envoie nos données
				});
			}
		$('#content').val("");
	});

	$('#content').keydown(function(e){
		if (e.which == 13) {
			e.preventDefault();
			var content = $('#content').val();
			var contactId = $('#contactId').val();
			if ($.trim(content) != "") {			
				$.ajax({
				url : "view/send.php", // on donne l'URL du fichier de traitement
				type : "POST", // la requête est de type POST
				data : "content=" + content + "&contactId=" + contactId // et on envoie nos données
				});
			}
			$('#content').val("");
		}

	});
	








});
</script>
 <?php 
$content = ob_get_clean();
require('./view/template.php');
?>
