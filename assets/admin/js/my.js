// JavaScript Document
$(document).ready(function(){

	var DELETE_CONFIRM_QUESTION = 'Czy napewno chcesz usunąć?';

///////////////

	$('.subs-select').select2();

	$.datetimepicker.setLocale('pl');

	$("input.datetimepicker").datetimepicker({dayOfWeekStart:1, format:'Y-m-d H:i:s'});

///////////////

	function showHideEventBox()
	{
		if ($('select[name=type]').val() == 4)
			{
				$('.event-box').show();
			}
			else
			{
				$('.event-box').hide();
			}
	}

	if ($('select[name=type]').length > 0)
	{
		showHideEventBox();
		$('select[name=type]').change(function(){
			showHideEventBox();
		});
	}

///////////////

    $(".external").click(function(e) {
        e.preventDefault();
        window.open(this.href);
    });

///////////////

	$('.filtr select').change(function(){
		$('.filtr').submit();
	});

///////////////

	$('.addTrait').click(function(){
		var type = $(this).parent().parent().data('type');
		var output = '';
		switch (type) {
			case 'categories':
				output += '<h1>Stwórz nową kategorię</h1>';
				break;
			case 'tags':
				output += '<h1>Stwórz nowy tag</h1>';
				break;
			case 'ads':
				output += '<h1>Stwórz nowy dział ogłoszeń</h1>';
				break;
			case 'params':
				output += '<h1>Stwórz nowy parametr</h1>';
				break;
		}
		output += '<form id="addNewTrait">';
		output += '<p><label form="newTrait">Nazwa</label> <input type="text" name="newTrait" value=""></p>';
		output += '<p><label form="kolor">Kolor</label> <input name="kolor" value="#535353" type="color"></p>';
		output += '<input type="hidden" name="type" value="'+ type +'">';
		output += '</form>';
		$.prompt(output,{ submit: addNewTrait, buttons: { 'Stwórz': true, 'Anuluj': false } });
	});

	function addNewTrait(v,m,f)
	    {
			if (m && $('#addNewTrait input[name=newTrait]').val() !== '')
			{
				$('div#loading').show();
				$.ajax({
					type: "POST",
					url: PG_BASEURL + 'admin/ajax/addNewTrait',
					data: {
						name: $('#addNewTrait input[name=newTrait]').val(),
						table: $('#addNewTrait input[name=type]').val(),
						kolor: $('#addNewTrait input[name=kolor]').val(),
					},
					success: processAddTraitXml
				});
			}
		}

	function processAddTraitXml(responseXML) {
		$('div#loading').hide();
		var _save = $("save", responseXML).text();
		var _output = JSON.parse($("output", responseXML).text());
		var created = '';
		if (_save === 'OK')
			{
				if (_output.type == 'categories')
					{
                    created += '<label class="btn btn-default">';
                    created += '<input type="checkbox" name="categories[]" value="' + _output.id + '"';
        		    created +=  '> ';
        		    created += _output.nazwa + '</label>';
					}
				else if (_output.type == 'tags')
					{
                    created += '<label class="btn btn-default">';
                    created += '<input type="checkbox" name="tags[]" value="' + _output.id + '"';
        		    created +=  '> ';
        		    created += _output.nazwa + '</label>';
					}
				else if (_output.type == 'ads')
					{
                    created += '<label class="btn btn-default">';
                    created += '<input type="checkbox" name="ads[]" value="' + _output.id + '"';
        		    created +=  '> ';
        		    created += _output.nazwa + '</label>';
					}
				else if (_output.type == 'params')
					{

                    created += '<label class="btn btn-default">';
					created += _output.nazwa + ': ';
                    created += '<input type="text" name="params[' + _output.id + ']" value=""';
        		    created +=  '> ';
        		    created += '</label>';
					}
				$('div#' + _output.type).find('h4').after(created);
			}
		processDefaultXml(responseXML);
	}
///////////////

	var cropDelay = setTimeout(cropPhotos, 1000);
	function cropPhotos()
	{

		$('.photoCrop').find('div.photoBox').each( function( index, el ) {
			var img = $(this).find('img');
			var cord = $(this).find('.cords');
			var options = {
				onChange: function(c) {
					cord.find('.x').val(c.x);
					cord.find('.y').val(c.y);
					cord.find('.x2').val(c.x2);
					cord.find('.y2').val(c.y2);
					cord.find('.w').val(c.w);
					cord.find('.h').val(c.h);
				},
				bgColor:     'black',
				bgOpacity:   0.4,
				setSelect:   [ 0, 0, img.width(), img.height() ]
			};

			var minW = 400;
			var minH = 200;

			if ($(this).hasClass('photoCropOrg'))
				{
					minW = 400;
					minH = 200;
					if (img.height() < minH) minH = img.height();
					if (img.width() < 400) minW = img.width();
					options.minSize = [minW,minH];
				}

			if ($(this).hasClass('photoCropIcon'))
				{
					minW = 400;
					minH = 200;
					if (img.height() < minH) minH = img.height();
					if (img.width() < 400) minW = img.width();
					options.minSize = [minW,minH];
				}
			if ($(this).hasClass('photoCropCrop'))
				{
					options.aspectRatio = 1;
					var des = 400;
					var min = Math.min(img.width(), img.height());
					if (min < des) des = min;
					options.setSelect = [ (img.width() - min)/2, (img.height() - min)/2, min,min  ];
					options.minSize = [des,des];
				}
	    	img.Jcrop(options);

		});
	}

///////////////

	if ($('.showAllTraits').length > 0)
		{

	    $("div.traits").each(function() {
			var notActive = $(this).find('label').not('.active');
			var k = notActive.length;
			if (k > 0)
				{
					var $showAllTraits = $(this).find('.showAllTraits');
					if ($showAllTraits.length > 0)
						{
							$(this).find('.showAllTraits').html('<span>pokaż nieużywane</span>');
							notActive.each(function() {
								$(this).hide();
							});
						}

					$('.showAllTraits span').click (function(){
						$(this).parent().parent().find('label').not('.active').each(function() {
							$(this).show();
						});
						$(this).parent().hide();
					});

				}
	        //
	    });

		}

///////////////

	// if ($('.showAllSubs').length > 0)
	// 	{
	// 		var notActive = $("div.subs").find('label').not('.active');
	// 		var k = notActive.length;
	// 		if (k > 0)
	// 			{
	// 				$("div.subs").find('.showAllSubs').html('<span>pokaż nieużywane</span>');
	// 				notActive.each(function() {
	// 					$(this).hide();
	// 				});
	//
	// 				$('.showAllSubs span').click (function(){
	// 					$(this).parent().parent().find('label').not('.active').each(function() {
	// 						$(this).show();
	// 					});
	// 					$(this).parent().hide();
	// 				});
	//
	// 			}
	// 	}

///////////////

	$('.togglePermsAll').click(function () {
		var _ch = this;
		$('.permsBox').each(function() {
			$(this).find('label').find(':checkbox').prop('checked', _ch.checked);

			$(this).find('.btn-group').find('label').each(function() {
				if(_ch.checked)
					{
						$(this).addClass('active');
					}
					else
					{
						$(this).removeClass('active');
					}
				$(this).find(':checkbox').prop('checked', _ch.checked);
			});

		});
	});

	$('.togglePermsBox').click(function () {
		var _ch = this;
		$(this).parent().parent().find('.btn-group').find('label').each(function() {
			if(_ch.checked)
				{
					$(this).addClass('active');
				}
				else
				{
					$(this).removeClass('active');
				}
			$(this).find(':checkbox').prop('checked', _ch.checked);
		});
	});

///////////////

	$('.bulkAll').click(function () {
		$(':checkbox.bulk').prop('checked', this.checked);
	});

///////////////

	$('select[name=bulkOperation]').change(function () {
		var _name = $(this).val();
		$(this).siblings('select, input').each(function () {
			if ($(this).attr('name') != _name)
				{
					$(this).hide();
				}
				else {
					$(this).show();
				}
		});
	});

///////////////

	if ($('span.passwordStrengthMeter').length > 0)
		{
			$('input.checkStrength').keyup(function(){
				if ($(this).val().length > 4)
					{
						$('.passwordStrengthMeter').html(passwordStrength($(this))).show();
					}
					else
					{
						$('.passwordStrengthMeter').hide();
					}
			});
		}

///////////////

	$( ".sortable" ).sortable({
		placeholder: "ui-state-highlight",
		handle: ".handle",
		opacity: 0.5,
		update: afterSortable
	});

	function afterSortable() {
		$(this).parent().parent().find('.kolej_save').show();
	}

///////////////

	$('.delPage').click(function(e) {
		if (!confirm(DELETE_CONFIRM_QUESTION)) return false;
		e.preventDefault();
		$('div#loading').show();
		var id = $(this).parent().parent().data('id');
		$.ajax({
			type: "POST",
			url: PG_BASEURL + 'admin/ajax/delPage',
			context: $(this),
			data: {id: id},
			success: processDelPageXml
		});
		return false;
	});

	function processDelPageXml(responseXML) {
		var _save = $("save", responseXML).text();
		if (_save === 'OK') $(this).parent().parent().hide();
		processDefaultXml(responseXML);
	}

///////////////

	$('.delBanner').click(function(e) {
		if (!confirm(DELETE_CONFIRM_QUESTION)) return false;
		e.preventDefault();
		$('div#loading').show();
		var id = $(this).parent().parent().data('id');
		$.ajax({
			type: "POST",
			url: PG_BASEURL + 'admin/ajax/delBanner',
			context: $(this),
			data: {id: id},
			success: processDelBannerXml
		});
		return false;
	});

	function processDelBannerXml(responseXML) {
		var _save = $("save", responseXML).text();
		if (_save === 'OK') $(this).parent().parent().hide();
		processDefaultXml(responseXML);
	}

///////////////

	$('.delAddon').click(function(e) {
		if (!confirm(DELETE_CONFIRM_QUESTION)) return false;
		e.preventDefault();
		$('div#loading').show();
		var id = $(this).parent().parent().data('id');
		$.ajax({
			type: "POST",
			url: PG_BASEURL + 'admin/ajax/delAddon',
			context: $(this),
			data: {id: id},
			success: processDelAddonXml
		});
		return false;
	});

	function processDelAddonXml(responseXML) {
		var _save = $("save", responseXML).text();
		if (_save === 'OK') $(this).parent().parent().hide();
		processDefaultXml(responseXML);
	}

///////////////

	$('.delNewsletter').click(function(e) {
		if (!confirm(DELETE_CONFIRM_QUESTION)) return false;
		e.preventDefault();
		$('div#loading').show();
		var id = $(this).parent().parent().data('id');
		$.ajax({
			type: "POST",
			url: PG_BASEURL + 'admin/ajax/delNewsletter',
			context: $(this),
			data: {id: id},
			success: processDelNewsletterXml
		});
		return false;
	});

	function processDelNewsletterXml(responseXML) {
		var _save = $("save", responseXML).text();
		if (_save === 'OK') $(this).parent().parent().hide();
		processDefaultXml(responseXML);
	}

///////////////

	$('.delComment').click(function(e) {
		if (!confirm(DELETE_CONFIRM_QUESTION)) return false;
		e.preventDefault();
		$('div#loading').show();
		var id = $(this).parent().parent().data('id_comment');
		$.ajax({
			type: "POST",
			url: PG_BASEURL + 'admin/ajax/delComment',
			context: $(this),
			data: {id: id},
			success: processDelCommentXml
		});
		return false;
	});

	function processDelCommentXml(responseXML) {
		var _save = $("save", responseXML).text();
		if (_save === 'OK') $(this).parent().parent().hide();
		processDefaultXml(responseXML);
	}

///////////////

	$('.delGuestbook').click(function(e) {
		if (!confirm(DELETE_CONFIRM_QUESTION)) return false;
		e.preventDefault();
		$('div#loading').show();
		var id = $(this).parent().parent().data('id');
		$.ajax({
			type: "POST",
			url: PG_BASEURL + 'admin/ajax/delGuestbook',
			context: $(this),
			data: {id: id},
			success: processDelGuestbookXml
		});
		return false;
	});

	function processDelGuestbookXml(responseXML) {
		var _save = $("save", responseXML).text();
		if (_save === 'OK') $(this).parent().parent().hide();
		processDefaultXml(responseXML);
	}

///////////////

	switchConfirm ();
	function switchConfirm () {
		$('.switchConfirm').unbind('click');
	 	$('.switchConfirm').bind('click', function(e) {
	 		e.preventDefault();
	 		$('div#loading').show();
	 		var id = $(this).parent().parent().data('id');
			var table = $(this).parent().parent().parent().parent().data('table');
	 		$.ajax({
	 			type: "POST",
	 			url: PG_BASEURL + 'admin/ajax/switchConfirm',
	 			context: $(this),
	 			data: {
					id: id,
					table: table
					},
	 			success: processSwitchConfirmXml
	 		});
	 		return false;
	 	});
	}

 	function processSwitchConfirmXml(responseXML) {
		_output = $("output", responseXML).text();
		_save = $("save", responseXML).text();
		if (_save == 'OK')
			{
				$(this).replaceWith(_output);
				switchConfirm();
			}
 		processDefaultXml(responseXML);
 	}

///////////////

	switchCommentStatus ();
	function switchCommentStatus () {
		$('ul .switchStatus').unbind('click');
		$('ul .switchStatus').bind('click', function(e) {
			e.preventDefault();
			$('div#loading').show();
			var id = $(this).parent().parent().data('id_comment');
			var table = 'comments';
			$.ajax({
				type: "POST",
				url: PG_BASEURL + 'admin/ajax/switchStatus',
				context: $(this),
				data: {
					id: id,
					table: table
					},
				success: processSwitchCommentStatusXml
			});
			return false;
		});
	}

	function processSwitchCommentStatusXml(responseXML) {
		_output = $("output", responseXML).text();
		_save = $("save", responseXML).text();
		if (_save == 'OK')
			{
				$(this).replaceWith(_output);
				switchCommentStatus();
			}
 		processDefaultXml(responseXML);
 	}

///////////////

	switchStatus ();
	function switchStatus () {
		$('table .switchStatus').unbind('click');
	 	$('table .switchStatus').bind('click', function(e) {
	 		e.preventDefault();
	 		$('div#loading').show();
	 		var id = $(this).parent().parent().data('id');
			var table = $(this).parent().parent().parent().parent().data('table');
	 		$.ajax({
	 			type: "POST",
	 			url: PG_BASEURL + 'admin/ajax/switchStatus',
	 			context: $(this),
	 			data: {
					id: id,
					table: table
					},
	 			success: processSwitchStatusXml
	 		});
	 		return false;
	 	});
	}

 	function processSwitchStatusXml(responseXML) {
		_output = $("output", responseXML).text();
		_save = $("save", responseXML).text();
		if (_save == 'OK')
			{
				$(this).replaceWith(_output);
				switchStatus();
			}
 		processDefaultXml(responseXML);
 	}

 ///////////////

	$('.delUser').click(function(e) {
		if (!confirm(DELETE_CONFIRM_QUESTION)) return false;
		e.preventDefault();
		$('div#loading').show();
		var id = $(this).parent().parent().data('id');
		$.ajax({
			type: "POST",
			url: PG_BASEURL + 'admin/ajax/delUser',
			context: $(this),
			data: {id: id},
			success: processDelUserXml
		});
		return false;
	});

	function processDelUserXml(responseXML) {
		var _save = $("save", responseXML).text();
		if (_save === 'OK') $(this).parent().parent().hide();
		processDefaultXml(responseXML);
	}

///////////////

	$('.traitName').focus(function()
		{
			$(this).parent().find('.saveTraitName').show();
		});

	$('.saveTraitName').click(function()
		{
			var newName = $(this).parent().find('.traitName').html();
			var id = $(this).parent().parent().parent().parent().data('id');
			var lang = $(this).parent().data('lang');
			var table = $(this).parent().parent().parent().data('table');

			$('div#loading').show();
			$.ajax({
				type: "POST",
				url: PG_BASEURL + 'admin/ajax/setTraitName',
				data: {
					id: id,
					newName: newName,
					lang: lang,
					table: table},
				success:   processDefaultXml
			});
			$(this).hide();
		});

///////////////

	$('.editTraitTekst').click(function()
		{
			var id = $(this).parent().parent().parent().parent().data('id');
			var lang = $(this).parent().data('lang');
			var table = $(this).parent().parent().parent().data('table');

			$('div#loading').show();
			$.ajax({
				type: "POST",
				url: PG_BASEURL + 'admin/ajax/editTraitTekst',
				context: $(this).parent(),
				data: {
					id: id,
					action: 'get',
					lang: lang,
					table: table},
				success:   processTraitEditTekst
			});
		});

	function processTraitEditTekst(response)
	{
		var id = $(this).parent().parent().parent().data('id');
		var lang = $(this).data('lang');

		var _output = '<h1>Edycja tekstu pomocniczego</h1>';
		_output += '<form id="traitEditTekstForm">';
		_output += '<textarea name="saveTraitTekstNew">' + response + '</textarea>';
		_output += '<input type="hidden" name="id" value="' + id + '">';
		_output += '<input type="hidden" name="lang" value="' + lang + '">';
		_output += '</form>';
		$.prompt(_output,{ submit: saveTraitTekst, buttons: { 'Zapisz': true, 'Anuluj': false } });
		$('div#loading').hide();
	}

	function saveTraitTekst(v,m,f)
	{
		if (m)
		{
			$('div#loading').show();
			$.ajax({
				type: "POST",
				url: PG_BASEURL + 'admin/ajax/editTraitTekst',
				data: {
					action : 'set',
					id : $('#traitEditTekstForm input[name=id]').val(),
					lang : $('#traitEditTekstForm input[name=lang]').val(),
					tekst : $('#traitEditTekstForm textarea[name=saveTraitTekstNew]').val()
				},
				success: processDefaultXml
			});
		}
	}

///////////////

	$('.delTrait').click(function(e) {
		if (!confirm(DELETE_CONFIRM_QUESTION)) return false;
		e.preventDefault();
		$('div#loading').show();
		var id = $(this).parent().parent().data('id');
		var table = $(this).parent().parent().parent().data('table');
		$.ajax({
			type: "POST",
			url: PG_BASEURL + 'admin/ajax/delTrait',
			context: $(this),
			data: {id: id, table: table},
			success: processDelTraitXml
		});
		return false;
	});

	function processDelTraitXml(responseXML) {
		var _save = $("save", responseXML).text();
		if (_save === 'OK') $(this).parent().parent().hide();
		processDefaultXml(responseXML);
	}

///////////////

	$('.tableTraits select[name="view"]').change(function()
		{
			var id = $(this).parent().parent().data('id');
			var table = $(this).parent().parent().parent().data('table');
			var view = $(this).val();

			$('div#loading').show();
			$.ajax({
				type: "POST",
				url: PG_BASEURL + 'admin/ajax/setTraitView',
				data: {
					id: id,
					view: view,
					table: table},
				success:   processDefaultXml
			});

		});

///////////////

	$('.tableTraits input[type="color"]').change(function()
		{
			var id = $(this).parent().parent().data('id');
			var table = $(this).parent().parent().parent().data('table');
			var color = $(this).val();
			var type = $(this).attr('name');

			$('div#loading').show();
			$.ajax({
				type: "POST",
				url: PG_BASEURL + 'admin/ajax/setTraitColor',
				data: {
					id: id,
					color: color,
					table: table,
					type: type},
				success:   processDefaultXml
			});

		});

///////////////

	$('.fileName').focus(function()
		{
			$(this).parent().find('.saveFileName').show();
		});

	$('.saveFileName').click(function()
		{
			var newName = $(this).parent().find('.fileName').html();
			var lang = $(this).parent().find('.fileName').data('lang');
			var id = $(this).parent().parent().parent().parent().data('id');
			$('div#loading').show();
			$.ajax({
				type: "POST",
				url: PG_BASEURL + 'admin/ajax/setFileName',
				data: {
					id: id,
					lang: lang,
					newName: newName},
				success:   processDefaultXml
			});
			$(this).hide();
		});

///////////////

	$('.photoName').focus(function()
		{
			$(this).parent().find('.savePhotoName').show();
		});

	$('.savePhotoName').click(function()
		{
			var newName = $(this).parent().find('.photoName').html();
			var lang = $(this).parent().find('.photoName').data('lang');
			var id = $(this).parent().parent().parent().parent().data('id');
			$('div#loading').show();
			$.ajax({
				type: "POST",
				url: PG_BASEURL + 'admin/ajax/setPhotoName',
				data: {
					id: id,
					lang: lang,
					newName: newName},
				success:   processDefaultXml
			});
			$(this).hide();
		});

///////////////

	$('.kolej_save').click(function()
		{
	    var _mySort = [];
		var _tr = $(this).parent().parent().parent().parent().find('.sortable tr');
		var _lp = _tr.length;

		_tr.each(function(){
        	_id = $(this).data('id');
			_mySort.push(_id + ":" +_lp);
			_lp--;
		});

		$('div#loading').show();
		$.ajax({
			type: "POST",
			url: PG_BASEURL + 'admin/ajax/order',
			data: {type: $(this).data('table'), dane: _mySort},
			success:   processDefaultXml
		});
		$(this).hide();
		});

///////////////

$('#refreshCaptcha').click(function(){
	$('div#loading').show();
	$.ajax({
		type: "POST",
		url: PG_BASEURL + 'admin/login/refreshCaptcha',
		success:   processCaptchaXml
	});
});

function processCaptchaXml(responseXML) {
	_output = $("output", responseXML).text();
	$('#captchaImage').html(_output);
	$('div#loading').hide();
	}

///////////////

	$('.pageHistory').click(function(e) {
		e.preventDefault();
		$('div#loading').show();
		var ver = $(this).parent().parent().data('ver');
		var page_id = $(this).parent().parent().data('id');
		$.ajax({
			type: "POST",
			url: PG_BASEURL + 'admin/ajax/getPageHistory',
			context: $(this),
			data: {ver: ver, page_id: page_id},
			success: processPageHistoryXml
		});
		return false;
	});

	function processPageHistoryXml(responseXML) {
		var _output = $("output", responseXML).text();
		var _news = JSON.parse(_output);
		var _lang;
		for (var i = 0; i < _news.length; i++)
		{
			_lang = _news[i].lang;
			if (typeof _news[i].tytul !== 'undefined') $('input[name="tytul['+ _lang +']"]').val(_news[i].tytul);
			if (typeof _news[i].link !== 'undefined') $('input[name="link['+ _lang +']"]').val(_news[i].link);
			if (typeof _news[i].tekst !== 'undefined')
				{
				$('textarea[name="tekst['+ _lang +']"]').val(_news[i].tekst);
				CKEDITOR.instances['tekst['+ _lang +']'].setData(_news[i].tekst);
				}
		}

		$.prompt('<h1>Tytuł, link oraz tekst zostały przywrócone do wybranej wersji</h1><p>Musisz jeszcze zapisać zmiany</p>');
		processDefaultXml(responseXML);
	}


/////////////// MENU


_obj = null;

$('.zapisz_menu').click(function(){
	var menu = $(this).parent().parent().find('.pageMenu');
	var lang = menu.data('lang');
	zapiszMenu(menu, lang);
	});

$('.pageMenu').each(function(){
	$(this).jstree({
	  "core" : {
		"animation" : 1,
		"check_callback": true,
		"themes" : { "stripes" : true, "variant" : "large" }
	  },

		"dnd" : {
			"check_while_dragging": true,
			"is_draggable" : function(node) {

				if (node[0].type == 'NOT-DRAGGABLE' || node[0].type == 'ROOT' || node[0].type == 'PRZECHOWALNIA') {
					return false;
				}
				return true;
			}
		},
	  "types" : {
		"#" : {
			"max_children" : 1
		},
		"default" : {
		  "valid_children" : ["default"],
		  "max_depth" : 1
		},
		"PRZECHOWALNIA" : {
		},
		"NOT-DRAGGABLE" : {
			"max_depth" : 1
		},
		"ROOT" : {
			"max_depth" : 2
		}
	  },
	  "plugins" : [
		"contextmenu", "dnd", "search",
		"state", "types"
	  ]
	});
});

});
