// JavaScript Document
$(document).ready(function(){


    makeTtipConection();
    hoverFotki();

    function makeTtipConection() {

        var xOffset = 10;
    	var yOffset = 30;

    	$('.ttip').hover(function(e){
    		$(this).data('rels', $(this).attr('rel'));
    		$(this).attr('rel', '');
    		$(this).removeAttr('rel');
    		if ($(this).data('rels') !== '')
    			{
    			$("body").append("<p id='tooltip'>"+ $(this).data('rels') +"</p>");
    			}
    		$("#tooltip")
    			.css("top",(e.pageY - xOffset) + "px")
    			.css("left",(e.pageX + yOffset) + "px")
    			.fadeIn("fast");
        },
    	function(){
    		$(this).attr('rel', $(this).data('rels'));
    		$("#tooltip").remove();
        });

    	$(".ttip").mousemove(function(e){
    		$("#tooltip")
    			.css("top",(e.pageY - xOffset) + "px")
    			.css("left",(e.pageX + yOffset) + "px");
    	});

    }

    function hoverFotki() {

        var xOffset = 10;
    	var yOffset = 30;

    	$(".hov").hover(function(e){
            var alt = $(this).attr('alt');
            if (typeof alt !== 'undefined')
                {
    		        var c = (alt !== "") ? "<br/>" + alt : "";
                }
    		$("body").append("<p id='hov'><img src='"+ this.src +"' alt='Image preview' />"+ c +"</p>");
    		$("#hov")
    			.css("top",(e.pageY - xOffset) + "px")
    			.css("left",(e.pageX + yOffset) + "px")
    			.fadeIn("fast");
        },
    	function(){
    		$("#hov").remove();
        });
    	$(".hov").mousemove(function(e){
    		$("#hov")
    			.css("top",(e.pageY - xOffset) + "px")
    			.css("left",(e.pageX + yOffset) + "px");
    	});
    }

});
