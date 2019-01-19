$(document).ready(function(){
	
	function load() {
				setInterval(function(){
				var lastId = $('#messages li:last').attr('id');
				var contactId = $('#contactId').val();
				$.ajax({
					url : "ajax/load.php",
					type : "POST",
					data : "contactId=" + contactId + "&messageId=" + lastId,
					dataType:"html",
					success : function(html){
						$('.messages ul').append(html);
					}
				});
			},100)
	}
			load();

	$('#send').click(function(e){
			var content = $('#content').val();
			var contactId = $('#contactId').val();
			if ($.trim(content) != "") {			
				$.ajax({
				url : "ajax/send.php", // on donne l'URL du fichier de traitement
				type : "POST", // la requête est de type POST
				data : "content=" + content + "&contactId=" + contactId // et on envoie nos données
				});
			}
		$('#content').val("");
		$(".messages").animate({ scrollTop: $(document).height() }, "fast");

	});

	$('#content').keydown(function(e){
		if (e.which == 13) {
			e.preventDefault();
			var content = $('#content').val();
			var contactId = $('#contactId').val();
			if ($.trim(content) != "") {			
				$.ajax({
				url : "ajax/send.php", // on donne l'URL du fichier de traitement
				type : "POST", // la requête est de type POST
				data : "content=" + content + "&contactId=" + contactId // et on envoie nos données
				});
			}
			$('#content').val("");
			$(".messages").animate({ scrollTop: $(document).height() }, "fast");

		}

	});
});