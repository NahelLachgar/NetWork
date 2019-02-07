$(document).ready(function(){
    $(".deleteCom").click(function(e){
        e.preventDefault();
        comId = $(this).siblings('.comId').val();
      $(this).parents('ul').hide();
     $.ajax({
            url : "index.php?action=deleteCom", // on donne l'URL du fichier de traitement
            type : "POST", // la requête est de type POST
            data : "comId=" + comId // et on envoie nos données
            });
    });

$(".deletePost").click(function(e){
            e.preventDefault();
            postId = $(this).parents('.card').attr('id');
            $(this).parents('.card').hide();
            $.ajax({
                url : "index.php?action=deletePost", // on donne l'URL du fichier de traitement
                type : "POST", // la requête est de type POST
                data : "postId=" + postId // et on envoie nos données
                }); 
});

$(".sendComment").click(function(e){
        e.preventDefault();
        comment = $(this).parents('div').siblings('.comment').val();
        postId = $(this).parents().eq(2).attr('id');
        com = $(this).parents().siblings('.card-footer'); 
        if ($.trim(comment) != "") {			
            $.ajax({
                url : "index.php?action=comment", // on donne l'URL du fichier de traitement
                type : "POST", // la requête est de type POST
                data : "postId=" + postId + "&comment=" + comment, // et on envoie nos données
                dataType : "html",
                success : function(html){
                  com.append(html);  
                 }
                });
                $(this).parents('div').siblings('.comment').val("");
            }
         });

         $(".comment").keydown(function(e){
            if (e.which == 13) {
                comment = $(this).val();
                postId = $(this).parents(".card.gedf-card").attr('id');
                com = $(this).parents().siblings('.card-footer'); 
                if ($.trim(comment) != "") {			
                    $.ajax({
                        url : "index.php?action=comment", // on donne l'URL du fichier de traitement
                        type : "POST", // la requête est de type POST
                        data : "postId=" + postId + "&comment=" + comment, // et on envoie nos données
                        dataType : "html",
                        success : function(html){
                        com.append(html);  
                        }
                        });
                        $(this).val('');
                    }
                }
             });
});