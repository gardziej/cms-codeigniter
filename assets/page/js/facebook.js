// JavaScript Document
$(document).ready(function(){

    setTimeout(function(){$(".myfb-container").show();}, 1000);

    $(".myfb-container").hover(
        function()
            {
                $(".myfb-container").stop().animate({right: "0px"}, 500);
            },
        function()
            {
                $(".myfb-container").stop().animate({right: "-500px"}, 300);
            }
    );

});
