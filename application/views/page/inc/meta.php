<meta property="og:url" content="<?=base_url($this->uri->uri_string())?>" />
<meta property="og:type" content="website" />

<?php if (isSet($page['tytul'])) { ?>
<meta property="og:title" content="<?=$page['tytul']?>" />
<?php } ?>

<?php if (isSet($page['tekst'])) { ?>
<meta property="og:description" content="<?=cuts($page['tekst'])?>" />
<?php } ?>

<?php if (isSet($photos, $photos[0], $photos[0]['icon'])) { ?>
<meta property="og:image" content="<?=base_url(PHOTO_UPLOAD_FOLDER.$photos[0]['icon'])?>" />
<?php } ?>

<meta property="fb:app_id" content="191182941320777" />
