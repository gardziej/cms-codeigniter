<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
    <title>Panel Administracyjny - <?=isSet($title)?$title:''?></title>

	<script>
		var PG_BASEURL = '<?=base_url()?>';
	</script>

	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/bootstrap/css/bootstrap.min.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/admin/css/style.css')?>"/>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/admin/css/impromptu.css')?>"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/bootstrap/css/sb-admin.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/bootstrap/font-awesome/css/font-awesome.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/jquery-ui-1.12.1.custom/jquery-ui.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/lightbox/css/lightbox.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/datetimepicker/jquery.datetimepicker.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/jstree/dist/themes/default/style.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/jcrop/css/jquery.Jcrop.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/tip/tip.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/select2/css/select2.min.css')?>">

	

</head>
<body>

	<div id="loading"></div>
