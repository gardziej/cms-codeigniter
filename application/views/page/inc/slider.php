<?php if ($this->cfg->get('show_main_slider') && isSet($slider, $slider['pages']['list']) && !empty($slider['pages']['list'])) { ?>

<!-- Content Header (Page header) -->
<!-- Main content -->
<div class="container" id="main-slider-container">
<section class="content">
    <section id="main-slider" class="no-margin carousel">
<div class="carousel slide">
    <ol class="carousel-indicators">

<?php
//echo "<pre>"; print_r($slider); echo "</pre><hr>"; exit;
$start = 0;

for ($i = 0; $i < $slider['pages']['count']; $i++)
{
?>
<li data-target="#main-slider" data-slide-to="<?=$i?>" class="<?php if($i==0) echo 'active';?>"></li>
<?php
}
?>

                    </ol>
                    <div class="carousel-inner">

<?php
$k = 1;

if (isSet($slider['pages'], $slider['pages']['list'])) foreach ($slider['pages']['list'] AS $p)
{
//echo "<pre>"; print_r($slider['photos']); echo "</pre><hr>"; exit;
    ?>

    <div class="item <?php if($k==1) echo 'active';?>">
        <div class="container">
            <div class="row slide-margin">

                <a href="<?=$p['tytul_frd']?>" class="col-xs-12 col-sm-6 slide-img"
<?php

if (isSet($slider['photos'][$p['id']]))
{
    ?>
    style="background-image: url(<?=base_url(PHOTO_UPLOAD_FOLDER.$slider['photos'][$p['id']]['icon'])?>)"
    <?php
}

?>

                >

            </a>

                <div class="col-xs-12 col-sm-6 carousel-content-container">
                    <div class="carousel-content">

<?php


if (isSet($slider['tags'], $slider['tags'][$p['id']]))
    {
        $tag_hrefs = array();
        foreach ($slider['tags'][$p['id']] AS $t)
            {
                $tag_hrefs[] = '<a href="'.base_url().$t['nazwa_frd'].'">'.$t['nazwa'].'</a>';
            }
    if (isSet($tag_hrefs))
        {
            echo '<p class="tags">';
            echo implode(' | ', $tag_hrefs);
            echo '</p>';
        }
    }

if (!isSet($slider['comments_count'][$p['id']]))
    {
        $slider['comments_count'][$p['id']] = 0;
    }
$p['comments_text'] = commentsText($slider['comments_count'][$p['id']]);

?>

                        <h1>
                            <a href="<?=$p['tytul_frd']?>"><?=$p['tytul']?></a>
                        </h1>

                        <p>
                        <span class="slider-data_publikacji"><?=datePL('l j f Y',strtotime($p['data_publikacji']))?></span>
                        <a class="label label-warning" href="<?=base_url().$p['tytul_frd']?>#comments"><?=$p['comments_text']?></a>
                        </p>

                        <?=($p['lead'] !=='')?'<h2>'.$p['lead'].'</h2>':""?>
                        <p class="tekst"><?=cuts($p['tekst'])?></p>
                        <a class="btn-slide" href="<?=$p['tytul_frd']?>">Zobacz więcej</a>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/.item-->


    <?php


    $k++;
}

?>

                    </div><!--/.carousel-inner-->
</div>
</section><!--/#main-slider-->
</section><!-- /.content -->
</div>

<?php } ?>

<?php $this->load->view('page/inc/banner_zone', array('zone_id' => 150, 'banners' => $banners, 'banners_cats' => $banners_cats)); ?>
