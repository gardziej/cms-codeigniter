<div class="page_preview">
        <?php foreach ($langs AS $lang_id => $lang)
            {
            if (isSet($p->lang_data[$lang_id]->tytul) && $p->lang_data[$lang_id]->tytul != '')
                {
                    echo '<h5>';
                    echo '<img class="flag" src="'.base_url($lang['flag']).'">';
                    echo $p->lang_data[$lang_id]->tytul;
                    echo '</h5>';
                }
            }
        ?>
</div>

<form class="form-inline form-file-upload" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="nazwa">Dodaj nowy załącznik: </label>
    <input type="text" class="form-control" name="nazwa" value="file" placeholder="nazwa wyświetlana">
  </div>
    <span class="btn btn-default btn-file">
        <input type="file" name="userfile[]" multiple>
    </span>
  <button name="submit" value="true" type="submit" class="btn btn-primary">Dodaj załącznik</button>
</form>
<?=form_error('nazwa')?>

<form method="post">
<table class="table table-striped tableFiles" data-table="pages_zalaczniki">
<thead>
<tr>
    <th><input type="checkbox" class="bulkAll"></th>
    <th>kolejność<br><button type="button" data-table="pages_zalaczniki" class="save kolej_save btn-sm btn-danger">zapisz</button></th>
    <th>nazwa</th>
    <th>typ</th>
    <th>link</th>
    <th>waga</th>
    <th>status</th>
    <th>usuń</th>
</tr>
</thead>
<tbody class="sortable">

<?php

if (isSet($files)) foreach ($files AS $f)
{

?>

<tr data-id="<?=$f->id?>">
    <td><input type="checkbox" name="bulk[<?=$f->id?>]" class="bulk"></td>
    <td class="handle"><span class="glyphicon glyphicon-sort"></span></td>
    <td>
        <ul class="flag-list">
        <?php foreach ($langs AS $lang_id => $lang)
            {
                echo '<li>';
                echo '<img class="flag" src="'.base_url($lang['flag']).'">';
                echo '<span class="fileName" data-lang="'.$lang_id.'" contenteditable="true">'.$f->lang_data[$lang_id]->nazwa.'</span>';
                echo ' <span class="saveFileName glyphicon glyphicon-floppy-disk g1"></span>';

                echo '</li>';
            }
        ?>
        </ul>
    </td>
    <td>
        <?php
            echo '<img src="'.base_url(FILE_ICONS_FOLDER.$f->rozszerzenie.'.png').'"/>';
        ?>
    </td>
    <td><a href="<?=base_url(FILE_UPLOAD_FOLDER.$f->plik)?>"><?=$f->plik?></a></td>
    <td><?=decorate_file_size($f->waga)?></td>
    <td><span class="<?=$element_status[$f->status]['icon']?> switchStatus" title="<?=$element_status[$f->status]['name']?>"></span></td>
    <td><a href="<?=site_url('admin/pages/files/'.$p->id.'/del/'.$f->id)?>" class="glyphicon glyphicon-trash confirm"></a></td>

</tr>

<?php
}
?>

</tbody>
</table>

<p class="bulkRow">
<select name="bulkOperation">
    <option value="">operacja grupowa</option>
    <option value="bulkStatus">zmień status na</option>
    <option value="bulkDel">usuń zaznaczone</option>
    <option value="bulkMove">przenieś do</option>
    <option value="bulkCopy">skopiuj do</option>
</select>

<select name="bulkStatus">
    <?php foreach ($element_status AS $k => $ps) { ?>
    <option value="<?=$k?>"><?=$ps['name']?></option>
    <?php } ?>
</select>

<select name="bulkMove">
    <?php foreach ($pages AS $pg) { if ($pg->id !== $p->id) {?>
    <option value="<?=$pg->id?>"><?=$pg->lang_data[$this->languages->getMainLang()]->tytul?></option>
    <?php } } ?>
</select>

<select name="bulkCopy">
    <?php foreach ($pages AS $pg) { if ($pg->id !== $p->id) {?>
    <option value="<?=$pg->id?>"><?=$pg->lang_data[$this->languages->getMainLang()]->tytul?></option>
    <?php } } ?>
</select>

<button name="bulkSubmit" value="true" type="submit" class="btn-xs btn-primary">wykonaj</button>
</p>

</form>
