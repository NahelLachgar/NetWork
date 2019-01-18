function loadNotifications() {
    setInterval(function(){
    $.ajax({
        url : "ajax/notifications.php",
        type : "POST",
        data : "contactId=" + contactId + "&messageId=" + lastId,
        dataType:"html",
        success : function(html){
            $('.messages ul').append(html);
        }
    });
},100)
}
loadNotifications();