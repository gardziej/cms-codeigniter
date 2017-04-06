<?php
$this->load->helper('pg_helper');

 ?>


    <header>
        <h2><a href="<?=$link?>"><i class="fa fa-arrow-right"></i> <?=$tytul?></a></h2>
        <p class="data_publikacji"><?=datePL('l j f Y',strtotime($dodano))?></p>
    </header>
