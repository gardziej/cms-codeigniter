<ul class="alert alert-info">
    <li>Kliknij prawym klawiszem na elemencie drzewa, aby dodać węzeł, podlinkować go, zmienić nazwę lub usunąć.</li>
    <li>Lewym klawiszem możesz przesuwać elementy.</li>
    <li>Pamiętaj, aby po wszystkich zapisać menu.</li>
</ul>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <?php foreach ($langs AS $lang_id => $lang)
            {
                echo '<li role="presentation"';
                if ($lang_main == $lang_id) { echo ' class="active"'; }
                echo '><a href="#'.$lang_id.'" aria-controls="'.$lang_id.'" role="tab" data-toggle="tab">';
                echo '<img class="flag" src="'.base_url($lang['flag']).'">';
                echo $lang['name'].'</a></li>';
            }
        ?>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
    <?php foreach ($langs AS $lang_id => $lang)
        {
        echo '<div role="tabpanel" class="tab-pane';
        if ($lang_main == $lang_id) { echo ' active'; }
        echo '" id="'.$lang_id.'">';
        ?>
        <p class="button_bar"><button class="zapisz_menu btn btn-primary" value="zapisz">zapisz zmiany</button></p>
        <div class="pageMenu" id="pageMenu_<?=$lang_id?>" data-lang="<?=$lang_id?>">
        <ul>
        <?=printTree($menu[$lang_id])?>
        </ul>
        </div>
        <p class="button_bar"><button class="zapisz_menu btn btn-primary" value="zapisz">zapisz zmiany</button></p>
        </div>
        <?php
        } ?>
    </div>
