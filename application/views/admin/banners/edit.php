<form class="form-horizontal" method="POST" enctype="multipart/form-data">

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
            <div class="form-group">
                <label for="tytul" class="col-sm-2 control-label">Nazwa</label>
                <div class="col-sm-10">
                    <input type="text" value="<?=set_value('nazwa['.$lang_id.']', $p->lang_data[$lang_id]->nazwa)?>" class="form-control" name="nazwa[<?=$lang_id?>]" placeholder="Nazwa">
                    <?=form_error('nazwa['.$lang_id.']')?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <div class="form-group">
        <label for="tytul" class="col-sm-2 control-label">Baner</label>
        <div class="col-sm-10">
            <?php if($p->plik != '') { ?>
            <img src="<?=base_url(BANNER_UPLOAD_FOLDER.$p->plik)?>"/>
            <?php } ?>
            <br>
            <span class="btn btn-default btn-file">
                <input type="file" name="userfile">
            </span>
        </div>
    </div>

    <div class="form-group">
        <label for="tytul" class="col-sm-2 control-label">Link</label>
        <div class="col-sm-10">
            <input type="text" value="<?=set_value('link', $p->link)?>" class="form-control" name="link" placeholder="Link">
            <?=form_error('link')?>
        </div>
    </div>

    <div class="form-group">
        <label for="tekst" class="col-sm-2 control-label">Status</label>
        <div class="col-sm-10 btn-group" data-toggle="buttons">
        <?php
        foreach ($element_status AS $key => $f)
            {
                echo '<label class="btn btn-default';
                if ($key == $p->status) echo ' active';
                echo '">';
                echo '<input name="status" type="radio" value="'.$key.'"';
                if ($key == $p->status) echo ' checked';
                echo '>';
                echo '<span class="'.$f['icon'].'"></span> '.$f['name'].'</label>';


            }
        ?>
        </div>
    </div>

    <div class="form-group">
        <label for="tekst" class="col-sm-2 control-label">Strefa</label>
        <div class="col-sm-4 btn-group-vertical" data-toggle="buttons">
        <?php
        foreach ($banner_zones AS $key => $f)
            {
                echo '<label class="btn btn-default';
                if ($key == $p->zone) echo ' active';
                echo '">';
                echo '<input name="zone" type="radio" value="'.$key.'"';
                if ($key == $p->zone) echo ' checked';
                echo '>';
                echo $f.'</label>';
            }
        ?>
        </div>
    </div>
    <div class="form-group">
        <label for="tekst" class="col-sm-2 control-label">Kategoria</label>
        <div class="col-sm-4 btn-group-vertical" data-toggle="buttons">
        <?php

        echo '<select class="form-control" name="cat_only[]" multiple>';
        echo '<option value="0">wszędzie</option>';
        foreach ($traits AS $type => $set)
            {
                echo '<optgroup label="'.$traits_dic[$type].'">';
                foreach ($set AS $trait)
                    {
                        echo '<option value="';
                        echo $trait->id;
                        echo '"';
                        if (in_array($trait->id, $traits_con)) { echo ' selected';}
                        echo '>';
                        echo $trait->lang_data['pl']->nazwa;
                        echo '</option>';
                    }
                echo '</optgroup>';
            }
        echo '</select>';
        ?>
        </div>
    </div>

    <div class="form-group">
        <label for="tekst" class="col-sm-2 control-label">Otwieraj w</label>
        <div class="col-sm-4 btn-group-vertical" data-toggle="buttons">
        <?php
        foreach ($link_targets AS $key => $f)
            {
                echo '<label class="btn btn-default';
                if ($key == $p->link_target) echo ' active';
                echo '">';
                echo '<input name="link_target" type="radio" value="'.$key.'"';
                if ($key == $p->link_target) echo ' checked';
                echo '>';
                echo $f.'</label>';


            }
        ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button name="submit" value="true" type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </div>
    </div>
