$(window).load(function () {
    $(".trigger_popup_fricc").click(function(){
       $('.hover_bkgr_fricc').show();
    });
    $('.popupCloseButton').click(function(){
        $('.hover_bkgr_fricc').hide();
    });
    $('.creer').click(function(){
        $('.add').hide();
    });
        $('.add').show();
        $('.popupCloseButton').click(function(){
            $('.add').hide();
        });
});