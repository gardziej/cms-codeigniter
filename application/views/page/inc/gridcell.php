<a href="<?=$p['tytul_frd']?>" class="grid-img"
<?php if (isSet($grid['photos'][$p['id']])) { ?>
style="background-image: url(<?=base_url(PHOTO_UPLOAD_FOLDER.$grid['photos'][$p['id']]['icon'])?>)"
<?php } ?> >
</a>
<div class="main-grid-data">
<?php

if (isSet($grid['tags'], $grid['tags'][$p['id']]))
    {
        $tag_hrefs = array();
        foreach ($grid['tags'][$p['id']] AS $t)
            {
                $tag_hrefs[] = '<a href="'.base_url().$t['nazwa_frd'].'">'.$t['nazwa'].'</a>';
            }
        if (isSet($tag_hrefs))
            {
                echo '<ul>';
                foreach ($tag_hrefs AS $th)
                    {
                        echo '<li class="tags">';
                        echo $th;
                        echo '</li>';
                    }
                echo '</ul>';
            }
    }

if (!isSet($grid['comments_count'][$p['id']]))
    {
        $grid['comments_count'][$p['id']] = 0;
    }
$p['comments_text'] = commentsText($grid['comments_count'][$p['id']]);
?>

<h1>
    <a href="<?=$p['tytul_frd']?>"><?=$p['tytul']?></a>
</h1>

<p>
<span class="grid-data_publikacji"><?=datePL('l j f Y',strtotime($p['data_publikacji']))?></span>
<a class="label label-warning" href="<?=base_url().$p['tytul_frd']?>#comments"><?=$p['comments_text']?></a>
</p>

</div>
