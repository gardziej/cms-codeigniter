<?php
        echo '<article class="col-lg-12 col-md-12 col-sm-12 col-xs-12 article-box_big article-'.$class;

        if (isSet($page['traits']['cats'])) foreach ($page['traits']['cats'] AS $c)
            {
                if ($c['id'] == CATEGORY_HIGHLIGHT)
                {
                    echo ' highlighted';
                }
                else if ($c['id'] == CATEGORY_SPEED_NEWS)
                {
                    echo ' highlighted_speed';
                }
            }

        echo '">';

        if (isSet($page['leading_photo']))
            {
                echo '<a class="leading_photo_anchor" href="'.base_url().$page['tytul_frd'].'"><img src="'.PHOTO_UPLOAD_FOLDER.$page['leading_photo'].'"></a>';
            }

        if (isSet($page['traits']['tags']))
            {
                $tag_hrefs = array();
                foreach ($page['traits']['tags'] AS $t)
                    {
                        $tag_hrefs[] = '<a href="'.base_url().$t['nazwa_frd'].'">'.$t['nazwa'].'</a>';
                    }
                echo '</p>';

                if (isSet($tag_hrefs))
                    {
                        echo '<p class="tags">';
                        echo implode(' | ', $tag_hrefs);
                        echo '</p>';
                    }
            }

        echo '<h2><a href="'.base_url().$page['tytul_frd'].'">'.$page['tytul'].'</a></h2>';
        echo '<p>';
        echo '<span class="data_publikacji">'.datePL('l j f Y',strtotime($page['data_publikacji'])).'</span>';
        echo ' <a class="label label-warning" href="'.base_url().$page['tytul_frd'].'#comments">'.$page['comments']['text'].'</a>';
        echo '</p>';
        echo ($page['lead'] !=='')?'<p class="lead">'.$page['lead'].'</p>':"";
        echo '<p class="tekst">'.cuts($page['tekst']).'</p>';

        echo '</article>';

?>
