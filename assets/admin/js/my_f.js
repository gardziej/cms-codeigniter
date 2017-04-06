_obj = null;

function processDefaultXml(responseXML) {
	$('div#loading').hide();
	var _save = $("save", responseXML).text();
	var _error = $("error", responseXML).text();
	if (_save != 'OK')
		{
		_output = '<h1>' + _save + '</h1>';
		if (_error != 'OK') _output += '<p>' + _error + '</p>';
		$.prompt(_output);
		return false;
		}
	return false;
}

function zapiszMenu(menu, lang) {
	$('div#loading').show();

	var v = menu.jstree(true).get_json('#', { 'flat': true });
	v = JSON.stringify(v);
	$.ajax({
		type: "POST",
		url: PG_BASEURL + 'admin/ajax/menuSave',
		data: {new_menu: v, lang: lang},
		success:   processDefaultXml
	});
}

function showMenusPos(obj)
{
    _obj = obj;
    var v = obj.li_attr.rel;

    $.ajax({
    	type: "POST",
    	url: PG_BASEURL + 'admin/ajax/menuShowForm',
    	data: {id: v},
    	success:   processShowFormXml
    });
}

function processShowFormXml(responseXML) {
	var _output = $("output", responseXML).text();
	$.prompt(_output,{ submit: zapiszLinkMenu, buttons: { Zapisz: true, Anuluj: false } });

	$('#setMenuLink .col2').click(function(){
		$('#setMenuLink .col1 input:checked').each(function () {
			$(this).prop('checked', false);
			});
		$(this).parent().find('.col1 input').prop('checked', true);
	});
}

function zapiszLinkMenu(v,m,f)
{

	if (m === true)
	{
		var lang = $('input[name=link_lang]').val();
		var menu = $('#pageMenu_' + lang);
		_obj.li_attr['data-link_typ'] = $('input[name=link_typ]:checked').val();
		var link_value = $('input[name=link_typ]:checked').parent().parent().find('.col2').find('[name=link_value]').val();
		_obj.li_attr['data-link_value'] = link_value;
		zapiszMenu(menu, lang);
	}
}

function passwordStrength(pwd)
{
	var value = pwd.val();
	var veryStrongRegex = new RegExp("^(?=.{12,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^0-9A-Za-z]).*$", "g");
	var strongRegex = new RegExp("^(?=.{10,})(((?=.*[A-Z])(?=.*[a-z])(?=.*[^0-9A-Za-z]))|((?=.*[A-Z])(?=.*[0-9])(?=.*[^0-9A-Za-z]))|((?=.*[a-z])(?=.*[0-9])(?=.*[^0-9A-Za-z]))).*$", "g");
	var mediumRegex = new RegExp("^(?=.{8,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
	var enoughRegex = new RegExp("(?=.{5,}).*", "g");

	if (value.length === 0)
		{
			return '';
		}
		else if (false === enoughRegex.test(value))
		{
			return 'więcej znaków';
		}
		else if (veryStrongRegex.test(value))
		{
			return 'bardzo mocne';
		}
		else if (strongRegex.test(value))
		{
			return 'mocne';
		}
		else if (mediumRegex.test(value))
		{
			return 'średnie';
		} else {
			return 'słabe';
		}
}
