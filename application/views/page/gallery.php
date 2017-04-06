<header>
    <h1>galeria zdjęć</h1>
</header>

<div class="galleryMaster">
<?php
if ($pages) foreach ($pages AS $f) {
    if (isSet($f['photo'], $f['photo']['ile']) && $f['photo']['ile'] > 0)
    {
    ?>

        <div class="photoHover photoHover-type-move">
    		<a class="photoHover-hover" href="<?=base_url().$f['tytul_frd']?>">
    			<div class="photoHover-info">
    				<div class="headline">
    					<?=$f['tytul']?>
    					<div class="line"></div>
    				</div>
    				<div class="date">zdjęć --> <?=$f['photo']['ile']?></div>
    			</div>
    			<div class="mask"></div>
    		</a>
    		<div class="photoHover-img"><img src="<?=base_url(PHOTO_UPLOAD_FOLDER).'/'.$f['photo']['plik']?>" alt="" /></div>
        </div>


    <?php
    }
}
?>





</div>
