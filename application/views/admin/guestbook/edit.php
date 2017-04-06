<form class="form-horizontal" method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label for="autor" class="col-sm-2 control-label">Autor</label>
        <div class="col-sm-10">
            <input type="text" value="<?=set_value('autor', $p->autor)?>" class="form-control" name="autor" placeholder="Autor">
            <?=form_error('autor')?>
        </div>
    </div>

    <div class="form-group">
        <label for="tytul" class="col-sm-2 control-label">Tekst</label>
        <div class="col-sm-10">
            <textarea class="form-control" name="tekst"><?=set_value('tekst', $p->tekst)?></textarea>
            <?=form_error('tekst')?>
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
        <label for="tekst" class="col-sm-2 control-label">Język</label>
        <div class="col-sm-4 btn-group-vertical" data-toggle="buttons">
        <?php
        foreach ($langs AS $lang_id => $lang)
            {
                echo '<label class="btn btn-default';
                if ($lang_id == $p->lang) echo ' active';
                echo '">';
                echo '<input name="lang" type="radio" value="'.$lang_id.'"';
                if ($lang_id == $p->lang) echo ' checked';
                echo '>';
                echo $lang['name'].'</label>';


            }
        ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button name="submit" value="true" type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </div>
    </div>
