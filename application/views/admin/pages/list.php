<p class="button_bar">
    <a href="<?=base_url('admin/traits/categories')?>" class="btn btn-default">Kategorie</a>
    <a href="<?=base_url('admin/traits/tags')?>" class="btn btn-default">Tagi</a>
    <a href="<?=base_url('admin/traits/params')?>" class="btn btn-default">Parametry</a>
    <a href="<?=base_url('admin/pages/newPage')?>" class="btn btn-primary">Nowa strona</a>
</p>

<form class="form-inline form-file-upload filtr" method="GET">
  <div class="form-group">

    <label for="filtr_type">Typ: </label>
    <select name="filtr_type" class="form-control">
        <option value="">wszystkie</option>
        <?php
            foreach ($page_typy AS $k => $f)
                {
                    echo '<option value="'.$k.'"';
                    if ($filtr['type'] == $k) echo ' selected';
                    echo '>'.$f.'</option>';
                }
        ?>
    </select>

    <label for="filtr_cat">Kategoria: </label>
    <select name="filtr_cat" class="form-control">
        <option value="">wszystkie</option>
        <option value="-1"
        <?php if ($filtr['categories'] == -1) echo ' selected'; ?>
        >--- NIEPRZYPISANE ---</option>
        <?php
            if (isSet($traits['filtr']['categories'])) foreach ($traits['filtr']['categories'] AS $k => $f)
                {
                    echo '<option value="'.$k.'"';
                    if ($filtr['categories'] == $k) echo ' selected';
                    echo '>'.$f.'</option>';
                }
        ?>
    </select>

    <label for="filtr_tag">Tag: </label>
    <select name="filtr_tag" class="form-control">
        <option value="">wszystkie</option>
        <?php
            if (isSet($traits['filtr']['tags'])) foreach ($traits['filtr']['tags'] AS $k => $f)
                {
                    echo '<option value="'.$k.'"';
                    if ($filtr['tags'] == $k) echo ' selected';
                    echo '>'.$f.'</option>';
                }
        ?>
    </select>

    <label for="filtr_ad">Ogłoszenia: </label>
    <select name="filtr_ad" class="form-control">
        <option value="">wszystkie</option>
        <?php
            if (isSet($traits['filtr']['ads'])) foreach ($traits['filtr']['ads'] AS $k => $f)
                {
                    echo '<option value="'.$k.'"';
                    if ($filtr['ads'] == $k) echo ' selected';
                    echo '>'.$f.'</option>';
                }
        ?>
    </select>

    <label for="search_text">Szukaj: </label>
    <input name="search_text" class="form-control" value="<?=$filtr['search_text']?>">

  </div>

  <input type="hidden" value="true" name="filtr_make">
  <button name="filtr" value="true" type="submit" class="btn btn-primary">filtruj</button>
</form>

<form method="post">
<table class="table table-striped tablePages" data-table="pages">
<thead>
<tr>
    <th><input type="checkbox" class="bulkAll"></th>
    <th>kolejność<br><button type="button" data-table="pages" class="save kolej_save btn btn-danger">zapisz</button></th>
    <th>typ</th>
    <th>podstrona</th>
    <th>kategorie</th>
    <th>tagi</th>
    <th>kom.</th>
    <th>pliki</th>
    <th>zdjęcia</th>
    <th>operacje</th>
</tr>
</thead>
<tbody class="sortable">

<?php

if (count($pages) == 0) echo '<div class="alert alert-warning" role="alert">Brak wyników do wyświetlenia</div>';
else foreach ($pages AS $p)
{

?>

<tr data-id="<?=$p->id?>">
    <td style="font-size: 80%;"><?=$p->dodano?><br><input type="checkbox" name="bulk[<?=$p->id?>]" class="bulk"><br><?=$p->id?></td>
    <td class="handle"><span class="glyphicon glyphicon-sort"></span></td>
    <td>
<?php
    if ($p->type == TYPE_PAGE) echo '<img class="icon" src="'.base_url(FILE_ICONS_FOLDER).'/txt.png"></span>';
    if ($p->type == TYPE_GALLERY) echo '<img class="icon" src="'.base_url(FILE_ICONS_FOLDER).'/jpg.png"></span>';
    if ($p->type == TYPE_ADD) echo '<img class="icon" src="'.base_url(FILE_ICONS_FOLDER).'/_page.png"></span>';
    if ($p->type == TYPE_EVENT) echo '<img class="icon" src="'.base_url(FILE_ICONS_FOLDER).'/event.png"></span>';
?>
    </td>
    <td class="art">
        <ul>
        <?php foreach ($langs AS $lang_id => $lang)
            {
            if (isSet($p->lang_data[$lang_id]->tytul) && $p->lang_data[$lang_id]->tytul != '')
                {
                    echo '<li>';
                    echo '<img class="flag" src="'.base_url($lang['flag']).'">';
                    echo $p->lang_data[$lang_id]->tytul;
                    echo '</li>';
                }
            }
        ?>
        </ul>
    </td>
    <td class="traits categories">
    <?php
        if (isSet($traits['data'][$p->id]['categories']))
            {
                foreach ($traits['data'][$p->id]['categories'] AS $c)
                    {
                        echo '<p><span style="background: #'.$c->kolor.'; color: #'.$c->font.';">'.$c->lang_data[$this->languages->getMainLang()]->nazwa.'</span></p>';
                    }
            }
    ?>
    </td>

    <td class="traits tags">
    <?php
        if (isSet($traits['data'][$p->id]['tags']))
            {
                foreach ($traits['data'][$p->id]['tags'] AS $c)
                    {
                        echo '<p><span style="background: #'.$c->kolor.'; color: #'.$c->font.';">'.$c->lang_data[$this->languages->getMainLang()]->nazwa.'</span></p>';
                    }
            }
        if (isSet($traits['data'][$p->id]['tags']) && isSet($traits['data'][$p->id]['ads'])) { echo '---';}
        if (isSet($traits['data'][$p->id]['ads']))
            {
                foreach ($traits['data'][$p->id]['ads'] AS $c)
                    {
                        echo '<p><span style="background: #'.$c->kolor.'; color: #'.$c->font.';">'.$c->lang_data[$this->languages->getMainLang()]->nazwa.'</span></p>';
                    }
            }
    ?>
    </td>

    <td><a href="<?=site_url('admin/pages/comments/'.$p->id)?>" class="glyphicon glyphicon-comment"></a>
    <?php
        if (isSet($counts[$p->id], $counts[$p->id]['comments']))
            {
                echo '<br><span class="badge">';
                echo $counts[$p->id]['comments'];
                echo '</span>';
            }
    ?>
    </td>

    <td><a href="<?=site_url('admin/pages/files/'.$p->id)?>" class="glyphicon glyphicon-folder-open"></a>
    <?php
        if (isSet($counts[$p->id], $counts[$p->id]['files']))
            {
                echo '<br><span class="badge">';
                echo $counts[$p->id]['files'];
                echo '</span>';
            }
    ?>
    </td>
    <td><a href="<?=site_url('admin/pages/photos/'.$p->id)?>" class="glyphicon glyphicon-picture"></a>
    <?php
        if (isSet($counts[$p->id], $counts[$p->id]['photos']))
            {
                echo '<br><span class="badge">';
                echo $counts[$p->id]['photos'];
                echo '</span>';
            }
    ?>
    </td>
    <td>

        <a href="<?=site_url('admin/pages/edit/'.$p->id)?>" class="glyphicon glyphicon-pencil"></a>
        <br><span class="<?=$element_status[$p->status]['icon']?> switchStatus" title="<?=$element_status[$p->status]['name']?>"></span>
        <br><a href="<?=site_url('admin/pages/del/'.$p->id)?>" class="glyphicon glyphicon-trash delPage confirm"></a>
    </td>
</tr>

<?php
}
?>

</tbody>
</table>

<p class="bulkRow">
<select name="bulkOperation">
    <option value="">operacja grupowa</option>
    <optgroup label="Strony">
        <option value="bulkDel">usuń zaznaczone</option>
        <option value="bulkStatus">zmień status na</option>
        <option value="bulkType">zmień typ na</option>
    </optgroup>
    <optgroup label="Kategoria">
        <option value="bulkCatAdd">dodaj do kategorii</option>
        <option value="bulkCatRemove">usuń z kategorii</option>
    </optgroup>
    <optgroup label="Tagi">
        <option value="bulkTagAdd">dodaj tag</option>
        <option value="bulkTagRemove">usuń tag</option>
        <option value="bulkAdAdd">dodaj do ogłoszeń</option>
        <option value="bulkAdRemove">usuń z ogłoszeń</option>
    </optgroup>
    <optgroup label="Uprawnienia">
        <option value="bulkPermsAdd">dodaj uprawnienia dla</option>
        <option value="bulkPermsRemove">usuń uprawnienia dla</option>
    </optgroup>
</select>

<select name="bulkStatus">
    <?php foreach ($element_status AS $k => $ps) { ?>
    <option value="<?=$k?>"><?=$ps['name']?></option>
    <?php } ?>
</select>

<select name="bulkType">
    <?php foreach ($page_typy AS $k => $ps) { ?>
    <option value="<?=$k?>"><?=$ps?></option>
    <?php } ?>
</select>

<select name="bulkCatAdd">
    <?php foreach ($traits['list']['categories'] AS $c) { ?>
    <option value="<?=$c->id?>"><?=$c->lang_data[$this->languages->getMainLang()]->nazwa?></option>
    <?php } ?>
</select>

<select name="bulkCatRemove">
    <?php foreach ($traits['list']['categories'] AS $c) { ?>
    <option value="<?=$c->id?>"><?=$c->lang_data[$this->languages->getMainLang()]->nazwa?></option>
    <?php } ?>
</select>

<select name="bulkTagAdd">
    <?php foreach ($traits['list']['tags'] AS $c) { ?>
    <option value="<?=$c->id?>"><?=$c->lang_data[$this->languages->getMainLang()]->nazwa?></option>
    <?php } ?>
</select>

<select name="bulkTagRemove">
    <?php foreach ($traits['list']['tags'] AS $c) { ?>
    <option value="<?=$c->id?>"><?=$c->lang_data[$this->languages->getMainLang()]->nazwa?></option>
    <?php } ?>
</select>

<select name="bulkAdAdd">
    <?php foreach ($traits['list']['ads'] AS $c) { ?>
    <option value="<?=$c->id?>"><?=$c->lang_data[$this->languages->getMainLang()]->nazwa?></option>
    <?php } ?>
</select>

<select name="bulkAdRemove">
    <?php foreach ($traits['list']['ads'] AS $c) { ?>
    <option value="<?=$c->id?>"><?=$c->lang_data[$this->languages->getMainLang()]->nazwa?></option>
    <?php } ?>
</select>

<select name="bulkPermsAdd">
    <?php foreach ($page_permission AS $k => $c) { ?>
    <option value="<?=$c->admin_id?>"><?=$c->login?></option>
    <?php } ?>
</select>

<select name="bulkPermsRemove">
    <?php foreach ($page_permission AS $k => $c) { ?>
    <option value="<?=$c->admin_id?>"><?=$c->login?></option>
    <?php } ?>
</select>

<input type="text" name="bulkRename" value=""/>

<button name="bulkSubmit" value="true" type="submit" class="btn-xs btn-primary">wykonaj</button>
</p>
</form>

<p class="button_bar">
<a href="<?=base_url('admin/traits/categories')?>" class="btn btn-default">Kategorie</a>
<a href="<?=base_url('admin/traits/tags')?>" class="btn btn-default">Tagi</a>
<a href="<?=base_url('admin/traits/params')?>" class="btn btn-default">Parametry</a>
    <a href="<?=base_url('admin/pages/newPage')?>" class="btn btn-primary">Nowa strona</a>
</p>
