<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
    <title><?=isSet($page['tytul']) ? $page['tytul'].' : '.$page_info['page_name'] : $page_info['page_name']?></title>
<?php $page_info['page_description'] = str_replace( array("\r\n", "\n","\r"), ' ', $page_info['page_description'] ); ?>
 	<meta name="description" content="<?=$page_info['page_description']?>">
    <meta name="keywords" content="<?=$page_info['page_key_words']?>">

	<script>
		var PG_BASEURL = '<?=base_url()?>';
		var MAIN_SLIDER_SPEED = <?=$main_slider_speed?>;
	</script>

    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Courgette&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Sarala:400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Oswald%3A400%2C300%7COpen+Sans%3A400%2C300&#038;ver=4.6.1' rel='stylesheet' type='text/css' media='screen' />
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/page/css/animate.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/bootstrap/css/bootstrap.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/page/css/bootstrap-social.css')?>"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/page/css/photoHover.css')?>"/>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/page/css/facebook.css')?>"/>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/bootstrap/font-awesome/css/font-awesome.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/datetimepicker/jquery.datetimepicker.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/jquery-ui-1.12.1.custom/jquery-ui.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/lightbox/css/lightbox.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/libs/tip/tip.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/page/css/style.css')?>"/>

    <?php

	if (isSet($style))
	{
		echo '<style>'.implode(' ', $style).'</style>';
	}

    if (isSet($addons[0])) foreach ($addons[0] AS $a)
    	{
    		echo $a."\n";
    	}

	$this->view('page/inc/meta');
	?>

</head>
