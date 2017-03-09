$(document).ready(function() {
    var open_modal = $('.open_modal');
    var close = $('.modal_close, .modal_close_full_screen');
    open_modal.click( function () {
        var div = $(this).attr('href');
        $(div).css('display','block');
        $(div).css('opacity','1');
        $(".one_post").css('opacity','0.7');
            /*if(div !== "#full_screen"){
                setTimeout(function () {
                    $(div).animate({opacity: 0}, 1300,
                        function () {
                            $(div).css('display','none');
                        });
                }, 2000);
            }*/
    });
    close.click( function () {
        this.parentElement.style.display = 'none';
        });
});