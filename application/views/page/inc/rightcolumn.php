<?php $this->load->view('page/inc/banner_zone', array('zone_id' => 500, 'banners' => $banners, 'banners_cats' => $banners_cats)); ?>


    </div>

    <div id="rightColumn" class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

        <?php if (isSet($addad)) {
            echo '<a href="dodaj-ogloszenie" class="btn btn-warning btn-lg btn-block dodaj-ogloszenie">dodaj nowe ogłoszenie</a>';
        } ?>

        <?php $this->load->view('page/inc/banner_zone', array('zone_id' => 300, 'banners' => $banners, 'banners_cats' => $banners_cats)); ?>

        <?php if ($this->cfg->get('show_weather_widget')) {
            echo '<div class="panel panel-default panel-widget-weather">';
            echo '<div class="panel-heading">'.datePL('l j f Y').' <span class="clock">'.date('G:i:s').'</span></div>';
            echo '<div class="panel-body">';
            echo '<ul class="list-group">';
                echo '<li class="list-group-item">';
                echo '<p>imieniny obchodzą:</p>';
                echo '<p class="stronger">'.imieniny().'</p>';
                echo '</li>';
                echo '<li class="list-group-item">';
                echo '<iframe frameborder="0" marginwidth="0" marginheight="0" width="300" height="210" scrolling="NO" src="http://instytutmeteo.pl/userwidget/sitewidgets?id=10&city_id=3085495"></iframe>';
                echo '</li>';
            echo '</ul>';
            echo '</div>';
            echo '</div>';
        } ?>


        <?php if (!empty($comments_last)) {
            echo '<div class="panel panel-default panel-comments panel-comments-last">';
            echo '<div class="panel-heading">Ostatnie komentarze</div>';
            echo '<div class="panel-body">';
            echo '<ul class="list-group">';
            foreach ($comments_last AS $cl)
                {
                    echo '<li class="list-group-item">';
                    echo '<h4><a href="'.base_url().$cl['tytul_frd'].'">'.$cl['tytul'].'</a></h4>';
                    echo '<p><strong>'.$cl['username'].'</strong>: '.cuts($cl['tresc']).'</p>';
                    echo '<p class="info">';
                    echo '<span class="data_publikacji">'.datePL('l j f Y',strtotime($cl['dodano'])).'</span>';
                    echo '</p>';
                    echo '</li>';
                }
            echo '</ul>';
            echo '</div>';
            echo '</div>';
        } ?>
        <?php if (!empty($comments_most)) {
            echo '<div class="panel panel-default panel-comments panel-comments-most">';
            echo '<div class="panel-heading">Najczęściej komentowane</div>';
            echo '<div class="panel-body">';
            echo '<ul class="list-group">';
            foreach ($comments_most AS $cl)
                {
                    echo '<li class="list-group-item">';
                    echo '<h4><a href="'.base_url().$cl['tytul_frd'].'">'.$cl['tytul'].'</a></h4>';
                    echo '<p class="info">';
                    echo '<span class="data_publikacji">'.datePL('l j f Y',strtotime($cl['dodano'])).'</span>';
                    echo ' <a class="label label-warning" href="'.base_url().$cl['tytul_frd'].'#comments">'.commentsText($cl['ile']).'</a>';
                    echo '</p>';
                    echo '</li>';
                }
            echo '</ul>';
            echo '</div>';
            echo '</div>';
        } ?>


        <?php $this->load->view('page/inc/banner_zone', array('zone_id' => 400, 'banners' => $banners, 'banners_cats' => $banners_cats)); ?>

    </div>

</div>
