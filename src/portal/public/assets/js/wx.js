//微信弹出框
$(document).ready(function(){
    $('.wx p').hide();
    $('.wx').hover(
        function(){
            $(this).children("p").fadeIn();
        },
        function(){
            $(this).children("p").fadeOut();
        }
    )
});