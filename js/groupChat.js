$(document).ready(function(){
	
	function load() {
				setInterval(function(){
				var lastId = $('#messages li:last').attr('id');
				var groupId = $('#groupId').val();
				$.ajax({
					url : "ajax/load.php",
					type : "POST",
					data : "groupId=" + groupId + "&messageId=" + lastId,
					dataType:"html",
					success : function(html){
						$('.messages ul').append(html);
					}
				});
			},100)
	}
			load();

	$('#send').click(function(e){
			var message = $('#message').val();
			var groupId = $('#groupId').val();
			if ($.trim(message) != "") {			
				$.ajax({
				url : "ajax/send.php", // on donne l'URL du fichier de traitement
				type : "POST", // la requête est de type POST
				data : "message=" + message + "&groupId=" + groupId // et on envoie nos données
				});
			}
		$('#message').val("");
		$(".messages").animate({ scrollTop: $(document).height() }, "fast");

	});

	$('#message').keydown(function(e){
		if (e.which == 13) {
			e.preventDefault();
			var message = $('#message').val();
			var groupId = $('#groupId').val();
			if ($.trim(message) != "") {			
				$.ajax({
				url : "ajax/send.php", // on donne l'URL du fichier de traitement
				type : "POST", // la requête est de type POST
				data : "message=" + message + "&groupId=" + groupId // et on envoie nos données
				});
			}
			$('#message').val("");
			$(".messages").animate({ scrollTop: $(document).height() }, "fast");

		}
	});
});