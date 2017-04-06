<p class="button_bar">
    <a href="<?=base_url('admin/pages/files/'.$p->id)?>" class="btn btn-default">Pliki</a>
    <a href="<?=base_url('admin/pages/photos/'.$p->id)?>" class="btn btn-default">Zdjęcia</a>
    <a href="<?=base_url('admin/pages/comments/'.$p->id)?>" class="btn btn-default">Komentarze</a>
    <a href="<?=base_url('admin/pages')?>" class="btn btn-primary">powrót do listy</a>
</p>

<form class="form-horizontal" method="post">

    <div class="form-group">
        <div class="col-sm-3">
        <label for="nazwa">Typ strony</label>
            <select name="type" class="form-control">
                <?php
                    foreach ($page_typy AS $key => $f)
                        {
                            echo '<option value="'.$key.'"';
                            if ($key == $p->type) echo ' selected';
                            echo '>'.$f.'</option>';
                        }
                ?>
            </select>

        </div>
        <div class="col-sm-9">
            <div class="col-sm-4">
                <label for="tekst" class="">Data utworzenia</label>
                <div class="">
                    <input type="text" value="<?=set_value('dodano', $p->dodano)?>" class="form-control datetimepicker" name="dodano" placeholder="Data utworzenia">
                    <?=form_error('dodano')?>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="tekst" class="">Rozpocznij publikację</label>
                <div class="">
                    <input type="text" value="<?=set_value('publish_up', $p->publish_up)?>" class="form-control datetimepicker" name="publish_up" placeholder="Rozpocznij publikację">
                    <?=form_error('publish_up')?>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="tekst" class="">Zakończ publikację</label>
                <div class="">
                    <input type="text" value="<?=set_value('publish_down', $p->publish_down)?>" class="form-control datetimepicker" name="publish_down" placeholder="nigdy">
                    <?=form_error('publish_down')?>
                </div>
            </div>
        </div>
    </div>

<hr>

<div class="event-box">
    <h4>Wydarzenie</h4>
    <div class="form-group">

        <div class="col-sm-4">
            <label>Lokalizacja</label>
            <textarea class="form-control" name="event_location"><?=set_value('event_location', $p->event_location)?></textarea>
            <?=form_error('event_location')?>
        </div>

        <div class="col-sm-4">
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
                        <label>Organizator</label>
                        <textarea class="form-control" name="event_organizer[<?=$lang_id?>]"><?=set_value('event_organizer['.$lang_id.']', $p->lang_data[$lang_id]->event_organizer)?></textarea>
                        <?=form_error('event_organizer['.$lang_id.']')?>
                </div>
                <?php } ?>
            </div>

        </div>
        <div class="col-sm-4">
            <div class="row">
                <label>Data rozpoczęcia</label>
                <div class="">
                    <input type="text" value="<?=set_value('event_start', $p->event_start)?>" class="form-control datetimepicker" name="event_start" placeholder="Data rozpoczęcia">
                    <?=form_error('event_start')?>
                </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <label>Data zakończenia</label>
                <div class="">
                    <input type="text" value="<?=set_value('event_end', $p->event_end)?>" class="form-control datetimepicker" name="event_end" placeholder="Data zakończenia">
                    <?=form_error('event_end')?>
                </div>
            </div>

        </div>


    </div>
    <hr>
</div>

<div class="form-group">
    <div class="col-sm-3">
        <label for="tekst" >Zezwalaj na komentowanie</label><br>
        <div class="btn-group" data-toggle="buttons">
        <?php
        foreach ($yes_no AS $key => $f)
            {
                echo '<label class="btn btn-default';
                if ($key == $p->comments_allow) echo ' active';
                echo '">';
                echo '<input name="comments_allow" type="radio" value="'.$key.'"';
                if ($key == $p->comments_allow) echo ' checked';
                echo '>';
                echo '<span class="'.$f['icon'].'"></span> '.$f['name'].'</label>';
            }
        ?>
        </div>
    </div>

    <div class="col-sm-3">
        <label for="tekst" >Pokazuj komentarze</label><br>
        <div class="btn-group" data-toggle="buttons">
        <?php
        foreach ($yes_no AS $key => $f)
            {
                echo '<label class="btn btn-default';
                if ($key == $p->comments_show) echo ' active';
                echo '">';
                echo '<input name="comments_show" type="radio" value="'.$key.'"';
                if ($key == $p->comments_show) echo ' checked';
                echo '>';
                echo '<span class="'.$f['icon'].'"></span> '.$f['name'].'</label>';
            }
        ?>
        </div>
    </div>
    <div class="col-sm-3">
        <p><?=$p->ip?></p>
        <p><?=$p->notes?></p>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button name="submit" value="true" type="submit" class="btn btn-primary">Zapisz zmiany</button>
    </div>
</div>

<hr>

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
                <label for="tytul" class="col-sm-2 control-label">Tytuł</label>
                <div class="col-sm-10">
                    <input type="text" value="<?=set_value('tytul['.$lang_id.']', $p->lang_data[$lang_id]->tytul)?>" class="form-control" name="tytul[<?=$lang_id?>]" placeholder="Tytuł strony">
                    <?=form_error('tytul['.$lang_id.']')?>
                </div>
            </div>

            <div class="form-group">
                <label for="lead" class="col-sm-2 control-label">lead</label>
                <div class="col-sm-10">
                    <input type="text" value="<?=set_value('lead['.$lang_id.']', $p->lang_data[$lang_id]->lead)?>" class="form-control" name="lead[<?=$lang_id?>]" placeholder="Lead">
                    <?=form_error('lead['.$lang_id.']')?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Link</label>
                <div class="col-sm-10">
                    <p><a href="<?=base_url().$p->lang_data[$lang_id]->tytul_frd?>" class="external"><?=base_url().$p->lang_data[$lang_id]->tytul_frd?></a></p>
                </div>
            </div>

            <div class="form-group">
                <label for="tekst" class="col-sm-2 control-label">Treść</label>
                <div class="col-sm-10">
                    <textarea class="form-control editor" name="tekst[<?=$lang_id?>]"><?=set_value('tekst['.$lang_id.']', $p->lang_data[$lang_id]->tekst)?></textarea>
                    <p>Aby dodać duże zdjęcie w tekście wstaw znacznik w formacie: {foto:XXX} gdzie XXX to numer kolejny zdjęcia</p>
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
        <label for="link" class="col-sm-2 control-label">Użytkownicy, którzy mogą edytować</label>
        <div class="col-sm-4 btn-group-vertical" data-toggle="buttons">
                <?php
                if (isSet($page_permission) && count($page_permission) > 0) foreach ($page_permission AS $f => $v)
                    {
                        echo '<label class="btn btn-default';
                        if ($v->id_page) echo ' active';
                        echo '">';
                        echo '<input type="checkbox" name="perms[]" value="'.$v->admin_id.'"';
        			    if ($v->id_page) echo ' checked';
        			    echo '> ';
        			    echo $v->login.'</label>';
                    }
                ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button name="submit" value="true" type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </div>
    </div>

    <hr>

    <div class="form-group">
        <label for="link" class="col-sm-2 control-label">Cechy</label>
        <?php

            echo '<div class="col-sm-2 btn-group-vertical traits" data-toggle="buttons" id="categories" data-type="categories">';
            echo '<h4>Kategorie <button class="addTrait btn btn-sm btn-default glyphicon glyphicon-plus">nowa</button></h4>';
            if (isSet($traits['list']['categories']) && count($traits['list']['categories']) > 0) foreach ($traits['list']['categories'] AS  $f)
                {
                    echo '<label class="btn btn-default';
                    if (isSet($traits['data'][$p->id]['categories'][$f->id])) echo ' active';
                    echo '">';
                    echo '<input type="checkbox" name="categories[]" value="'.$f->id.'"';
        		    if (isSet($traits['data'][$p->id]['categories'][$f->id])) echo ' checked';
        		    echo '> ';
        		    echo $f->lang_data[$this->languages->getMainLang()]->nazwa.'</label>';
                }
            if ($action == 'edit' && !$this->cfg->get('show_all_categories')) echo '<p class="showAllTraits"></p>';
            echo '</div>';

        ?>
        <?php

            echo '<div class="col-sm-2 btn-group-vertical traits" data-toggle="buttons" id="tags" data-type="tags">';
            echo '<h4>Tagi <button class="addTrait btn btn-sm btn-default glyphicon glyphicon-plus">nowy</button></h4>';
            if (isSet($traits['list']['tags']) && count($traits['list']['tags']) > 0) foreach ($traits['list']['tags'] AS $f)
                {
                    echo '<label class="btn btn-default';
                    if (isSet($traits['data'][$p->id]['tags'][$f->id])) echo ' active';
                    echo '">';
                    echo '<input type="checkbox" name="tags[]" value="'.$f->id.'"';
        		    if (isSet($traits['data'][$p->id]['tags'][$f->id])) echo ' checked';
        		    echo '> ';
        		    echo $f->lang_data[$this->languages->getMainLang()]->nazwa.'</label>';
                }
            if ($action == 'edit' && !$this->cfg->get('show_all_tags')) echo '<p class="showAllTraits"></p>';
            echo '</div>';

        ?>

        <?php

            echo '<div class="col-sm-2 btn-group-vertical traits" data-toggle="buttons" id="ads" data-type="ads">';
            echo '<h4>Ogłoszenia <button class="addTrait btn btn-sm btn-default glyphicon glyphicon-plus">nowy</button></h4>';
            if (isSet($traits['list']['ads']) && count($traits['list']['ads']) > 0) foreach ($traits['list']['ads'] AS $f)
                {
                    echo '<label class="btn btn-default';
                    if (isSet($traits['data'][$p->id]['ads'][$f->id])) echo ' active';
                    echo '">';
                    echo '<input type="checkbox" name="ads[]" value="'.$f->id.'"';
        		    if (isSet($traits['data'][$p->id]['ads'][$f->id])) echo ' checked';
        		    echo '> ';
        		    echo $f->lang_data[$this->languages->getMainLang()]->nazwa.'</label>';
                }
            if ($action == 'edit' && !$this->cfg->get('show_all_ads')) echo '<p class="showAllTraits"></p>';
            echo '</div>';

        ?>


        <?php

            echo '<div class="col-sm-4 btn-group-vertical traits" data-toggle="buttons" id="params" data-type="params">';
            echo '<h4>Parametry <button class="addTrait btn btn-sm btn-default glyphicon glyphicon-plus">nowy</button></h4>';
            if (isSet($traits['list']['params']) && count($traits['list']['params']) > 0) foreach ($traits['list']['params'] AS $f)
                {
                    echo '<label class="btn btn-default';
                    if (isSet($traits['data'][$p->id]['params'][$f->id])) echo ' active';
                    echo '">';
                    echo $f->lang_data[$this->languages->getMainLang()]->nazwa.': ';
                    echo '<input type="text" name="params['.$f->id.']" value="';
                    if (isSet($traits['data'][$p->id]['params'][$f->id]->value)) echo $traits['data'][$p->id]['params'][$f->id]->value;
                    echo '"';
        		    echo '> ';
        		    echo '</label>';
                }
            if ($action == 'edit' && !$this->cfg->get('show_all_params')) echo '<p class="showAllTraits"></p>';
            echo '</div>';

        ?>
    </div>

    <hr>

    <div class="form-group">
        <label for="link" class="col-sm-2 control-label">Podpięte podstrony</label>

        <div class="col-sm-10 btn-group-vertical subs" data-toggle="buttons">
            <select class="subs-select" name="podstrony[]" multiple>

                <?php
                if (isSet($pages) && count($pages) > 0) foreach ($pages AS $f)
                    {
                        if ($f->id !== $p->id)
                            {
                                echo '<option value="'.$f->id.'"';
                			    if (isSet($p->cons) && in_array($f->id, $p->cons)) echo ' selected';
                			    echo '> ';
                			    echo $f->lang_data[$this->languages->getMainLang()]->tytul.'</option>';
                            }
                    }
                if ($action == 'edit') echo '<p class="showAllSubs"></p>';
                ?>
            </select>
        </div>



    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button name="submit" value="true" type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </div>
    </div>

<?php if (isSet($pageHistory) && count($pageHistory) > 0) { ?>
    <hr>
    <div class="form-group">
        <label for="link" class="col-sm-2 control-label">Historia zmian</label>
        <div class="col-sm-10">
            <table class="table table-stripped">
                <thead>
                    <tr>
                        <th>Autor</th>
                        <th>Data modyfikacji</th>
                        <th>Przywróć</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pageHistory AS $ph) { ?>
                    <tr data-ver="<?=$ph->ver?>" data-id="<?=$id?>">
                        <td><?=$ph->autor_name?></td>
                        <td><?=$ph->dodano?></td>
                        <td><span class="glyphicon glyphicon-share pageHistory"></span></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
</form>
