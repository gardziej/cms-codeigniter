// JavaScript Document
$(document).ready(function(){

	$.datepicker.regional['pl'] = {
		closeText: 'Zamknij',
		prevText: '<Poprzedni',
		nextText: 'Następny>',
		currentText: 'Dziś',
		monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
		monthNamesShort: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
		dayNames: ['Niedziela','Poniedziałek','Wtorek','Środa','Czwartek','Piątek','Sobota'],
		dayNamesShort: ['Nie','Pn','Wt','Śr','Czw','Pt','So'],
		dayNamesMin: ['N','Pn','Wt','Śr','Cz','Pt','So'],
		weekHeader: 'Tydz',
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['pl']);

//////////////

	$('.clock').simpleClock();

	 $('#main-slider .carousel').carousel({
       interval: MAIN_SLIDER_SPEED
     });

///////////////

	if ($('#comments').length > 0)
		{
			var $list = $('#comments_list');
			var $form = $('#comments_form');

			$list.on("click", ".answer", function() {
				$(this).parent().siblings('.tresc').append($form);
				var _id_comment = $(this).parent().parent().data('id_comment');
				$form.find('input[name="parent_id"]').val(_id_comment);
			});

			$form.on("click", ".abort", function() {
				$('#comments_form_box').append($form);
				$form.find('input[name="parent_id"]').val(0);
			});


			$list.addClass('loading');
			$.ajax({
				type: "POST",
				url: PG_BASEURL + 'ajax/commentsForPage',
				context: $list,
				data: {id_page : $list.data('id_page')},
				success: function (_html) {
					$list.removeClass('loading').html(_html);
				}
			});
		}

///////////////


	function fixedMenu()
	{
	    var docViewTop = $(window).scrollTop();

	    var elemTop = $('#top').offset().top;
	    var elemBottom = elemTop + $('#top').height();

	    if (elemBottom <= docViewTop)
		{
			$('#gotop').show();
			$('#topmenu').addClass('fixed-top');
			$('#top').css('padding-top', $('#topmenu').height() + "px");
		}
		else
		{
			$('#gotop').hide();
			$('#topmenu').removeClass('fixed-top');
			$('#top').css('padding-top', 0);
		}

	}

///////////////

     $("#gotop").bind('click', function(event) {
          goto('top');
          return false;
     });

	function goto(divId)
          {
          $('html,body').stop().animate({scrollTop: $("#"+divId).offset().top},'slow');
     	}

///////////////

	$(window).scroll(function () {
		fixedMenu();

		$('.highlighted:inview').addClass('animated pulse');

	});

///////////////

if ($('.alert-danger').length === 0)
	{
		$('.guestbookForm').hide();
		$(".showGuestbookForm").click(function(e){
			$(this).hide();
			$('.guestbookForm').slideDown('slow');
			e.preventDefault();
			return false;
		});
	}
	else
	{
		$(".showGuestbookForm").hide();
	}

///////////////

	$('#closeCookies').click(function(){
		$('#cookies').hide();
		$.ajax({
			url: PG_BASEURL + 'ajax/hideCookiesInfo'
		});
	});

///////////////
    $(".external").click(function(e) {
        e.preventDefault();
        window.open(this.href);
    });


});
