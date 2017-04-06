<?php

if (isSet($page['leading_photo']))
    {
        echo '<article class="col-lg-6 col-md-6 col-sm-12 col-xs-12 article-box';

        if (isSet($page['traits']['cats'])) foreach ($page['traits']['cats'] AS $c)
            {
                if ($c['id'] == CATEGORY_HIGHLIGHT)
                {
                    echo ' highlighted';
                }
            }

        echo '">';

        echo '<a href="'.base_url().$page['tytul_frd'].'">';
        echo '<img class="leading_photo" src="'.PHOTO_UPLOAD_FOLDER.$page['leading_photo'].'">';
        echo '<h4>'.$page['tytul'].'</h4>';
        echo '</a>';
        echo ' <a class="label label-warning" href="'.base_url().$page['tytul_frd'].'#comments">'.$page['comments']['text'].'</a>';
        echo '</article>';
    }
    else
    {
        echo '<article class="col-lg-6 col-md-6 col-sm-12 col-xs-12 article-box article-box-nophoto">';
        echo '<a href="'.base_url().$page['tytul_frd'].'">';
        echo '<h4>'.$page['tytul'].'</h4>';
        echo '</a>';
        echo ' <a class="label label-warning" href="'.base_url().$page['tytul_frd'].'#comments">'.$page['comments']['text'].'</a>';
        echo '</article>';
    }

?>
