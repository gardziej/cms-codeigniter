


    <?php $this->load->view('page/inc/banner_zone', array('zone_id' => 600, 'banners' => $banners, 'banners_cats' => $banners_cats)); ?>

<div class="container-fluid" id="footer_bar">

    <div class="container">
        <ul class="nav navbar-nav">
            <?php if (isSet($menus[3], $menus[3]['children'])) printMenuHorizontal($menus[3]['children']); ?>
        </ul>
    </div>


    <div class="container"  id="brand_info">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <h3><?=$this->cfg->get('page_name', $lang_page)?></h3>

            <p>Stworzył: <strong>Paweł Gardziejewski</strong><br>
            <i class="fa fa-envelope"></i> <a href="mailto:<?=$this->cfg->get('contact_email', $lang_page)?>"><?=$this->cfg->get('contact_email', $lang_page)?></a><br>
            <i class="fa fa-phone"></i> <a href="tel:<?=$this->cfg->get('contact_tel', $lang_page)?>"><?=$this->cfg->get('contact_tel', $lang_page)?></a>

        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <?php $this->load->view('page/inc/newsletter')?>
        </div>
    </div>
</div>

<?php
if (isSet($addons[2])) foreach ($addons[2] AS $a)
	{
		echo $a."\n";
	}
?>

<div id="gotop" class="hidden-xs" style="background: url(<?=base_url('assets/page/img')?>/go-top.png)">
    do góry strony
</div>


<script src="<?=base_url('assets/libs/jquery/js/jquery-2.1.4.min.js')?>"></script>
<script src="<?=base_url('assets/libs/json2.js')?>"></script>
<script src="<?=base_url('assets/libs/jquery-ui-1.12.1.custom/jquery-ui.min.js')?>"></script>
<script src="<?=base_url('assets/libs/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?=base_url('assets/libs/tip/tip.js')?>"></script>
<script src="<?=base_url('assets/page/js/inview.js')?>"></script>
<script src="<?=base_url('assets/libs/lightbox/js/lightbox.js')?>"></script>
<script src="<?=base_url('assets/page/js/clock.js')?>"></script>
<script src="<?=base_url('assets/libs/datetimepicker/jquery.datetimepicker.js')?>"></script>
<script src="<?=base_url('assets/page/js/my.js')?>"></script>
<script src="<?=base_url('assets/page/js/calendar.js')?>"></script>
<script src="<?=base_url('assets/page/js/facebook.js')?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTVm8ab-UPA6AWDp7qMngyebXXkxc6Na8"
    async defer></script>


<?php return; ?>

1:<br><div class="fb-page"
         data-href="https://www.facebook.com/NaszeSlubicePL/"
         data-tabs="messages"
         data-width="400"
         data-height="300"
         data-small-header="true">
      <div class="fb-xfbml-parse-ignore">
        <blockquote></blockquote>
      </div>
    </div>
</p>
<br>2:<br> <a href="https://m.me/NaszeSlubicePL">
    Dowolny link
 </a>
<br>3:<br><div class="fb-send" data-href="http://powiatslubicki24.pl"></div>
