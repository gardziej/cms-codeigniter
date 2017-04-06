<form class="form-horizontal" method="POST" enctype="multipart/form-data">


    <div class="form-group">
        <label for="tytul" class="col-sm-2 control-label">Nazwa</label>
        <div class="col-sm-10">
            <input type="text" value="<?=set_value('nazwa', $p->nazwa)?>" class="form-control" name="nazwa" placeholder="Nazwa">
            <?=form_error('nazwa')?>
        </div>
    </div>

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
                <label for="tytul" class="col-sm-2 control-label">Tekst</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="tekst[<?=$lang_id?>]"><?=set_value('tekst['.$lang_id.']', $p->lang_data[$lang_id]->tekst)?></textarea>
                    <?=form_error('tekst['.$lang_id.']')?>
                </div>
            </div>
        </div>
        <?php } ?>
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
        foreach ($addon_zones AS $key => $f)
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
        <div class="col-sm-offset-2 col-sm-10">
            <button name="submit" value="true" type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </div>
    </div>
