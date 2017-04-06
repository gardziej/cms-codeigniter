    <header>
        <h1><?=$tytul?></h1>
        <p class="info">
            <span class="data_publikacji"><?=datePL('l j f Y',strtotime($dodano))?></span>
            <a class="label label-warning" href="#comments"><?=$comments_text?></a>
        </p>
        <?=($page['lead'] !=='')?'<p class="lead">'.$page['lead'].'</p>':""?>
    </header>
