
<body>


<?php

if (isSet($addons[1])) foreach ($addons[1] AS $a)
	{
		echo $a."\n";
	}
?>

<?php $this->load->view('page/inc/banner_zone', array('zone_id' => 0, 'banners' => $banners, 'banners_cats' => $banners_cats)); ?>



<div class="container-fluid" id="container-top">
	<div class="container" id="top">
	    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" id="pageLogo">
	        <a href="<?=base_url()?>"><img src="<?=base_url('assets/page/img/logo.png')?>"></a>
	    </div>

		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="pageInfo">
			<p class="page-name"><?=$this->cfg->get('page_name', $lang_page)?></p>
			<p class="page-contact">
				<i class="fa fa-envelope"></i><a href="mailto:<?=$this->cfg->get('contact_email', $lang_page)?>"><?=$this->cfg->get('contact_email', $lang_page)?></a>
				<i class="fa fa-phone"></i><a href="tel:<?=$this->cfg->get('contact_tel', $lang_page)?>"><?=$this->cfg->get('contact_tel', $lang_page)?></a>
			</p>
		</div>

		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" id="socialMedia">
			<ul>
				<li>
					<a class="instagram-icon" href="<?=$this->cfg->get('social_instagram')?>">
						<img src="<?=base_url('assets/page/img/instagram_icon.png')?>">
					</a>

				</li>
				<li>
					<a class="btn btn-social-icon btn-twitter" href="<?=$this->cfg->get('social_twitter')?>">
						<span class="fa fa-twitter"></span>
					</a>
				</li>
				<li>
					<a class="btn btn-social-icon btn-facebook" href="<?=$this->cfg->get('social_facebook')?>">
						<span class="fa fa-facebook"></span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
