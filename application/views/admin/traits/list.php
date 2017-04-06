<p class="button_bar">
    <?php foreach ($types AS $t)
        {
        echo '<a href="'.base_url('admin/traits/'.$t['href']).'" class="btn ';
        if ($typ == $t['href'])
            {
                echo 'btn-primary';
            }
            else
            {
                echo 'btn-default';
            }
        echo '">'.$t['name'].'</a>';
        }
    ?>
</p>

<form class="form-inline form-file-upload" method="POST">
  <div class="form-group">
    <label for="nazwa">Dodaj: </label>
    <input type="text" class="form-control" name="nazwa" placeholder="nazwa">
  </div>
  <div class="form-group">
    <input type="color"  name="kolor" value="#535353">
  </div>

  <button name="submit" value="true" type="submit" class="btn btn-primary">Dodaj</button>
</form>
<?=form_error('nazwa')?>

<form method="post">
<table class="table table-striped tableTraits" data-table="traits">
<thead>
<tr>
    <th><input type="checkbox" class="bulkAll"></th>
    <th>kolejność<br><button type="button" data-table="traits" class="save kolej_save btn btn-danger">zapisz</button></th>
    <th>nazwa</th>
    <th>kolor etykiety</th>
    <th>kolor czcionki</th>
    <th>widok</th>
    <th>status</th>
    <th>usuń</th>
</tr>
</thead>
<tbody class="sortable">

<?php

if (isSet($lista[$typ])) foreach ($lista[$typ] AS $p)
{

?>

<tr data-id="<?=$p->id?>">

    <td><?=$p->id?><br><input type="checkbox" name="bulk[<?=$p->id?>]" class="bulk"></td>

    <td class="handle"><span class="glyphicon glyphicon-sort"></span></td>

    <td>
        <ul class="flag-list">
        <?php foreach ($langs AS $lang_id => $lang)
            {
                echo '<li data-lang="'.$lang_id.'">';
                echo '<img class="flag" src="'.base_url($lang['flag']).'">';
                echo '<span class="traitName" contenteditable="true">'.$p->lang_data[$lang_id]->nazwa.'</span>';
                echo ' <span class="saveTraitName glyphicon glyphicon-floppy-disk g1"></span>';
                echo ' <span class="editTraitTekst glyphicon glyphicon-info-sign g1"></span>';

                echo '</li>';
            }
        ?>
        </ul>
    </td>


    <td><input name="kolor" type="color" value="#<?=$p->kolor?>"/></td>
    <td><input name="font" type="color" value="#<?=$p->font?>"/></td>

    <td>
    <select name="view" class="form-control">
        <?php
            if (isSet($category_typy)) foreach ($category_typy AS $k => $f)
                {
                    echo '<option value="'.$k.'"';
                    if ($p->view == $k) echo ' selected';
                    echo '>'.$f.'</option>';
                }
        ?>
    </select>
    </td>

    <td><span class="<?=$element_status[$p->status]['icon']?> switchStatus" title="<?=$element_status[$p->status]['name']?>"></span></td>

    <td><a href="<?=site_url('admin/traits/'.$typ.'/del/'.$p->id)?>" class="glyphicon glyphicon-trash delTrait confirm"></a></td>
</tr>

<?php
}
?>

</tbody>
</table>


<p class="bulkRow">
<select name="bulkOperation">
    <option value="">operacja grupowa</option>
    <option value="bulkDel">usuń zaznaczone</option>
    <option value="bulkStatus">zmień status na</option>
    <option value="bulkView">zmień widok na</option>
</select>

<select name="bulkStatus">
    <?php foreach ($element_status AS $k => $ps) { ?>
    <option value="<?=$k?>"><?=$ps['name']?></option>
    <?php } ?>
</select>

<select name="bulkView">
    <?php foreach ($category_typy AS $k => $f) { ?>
    <option value="<?=$k?>"><?=$f?></option>
    <?php } ?>
</select>

<input type="text" name="bulkRename" value=""/>

<button name="bulkSubmit" value="true" type="submit" class="btn-xs btn-primary">wykonaj</button>
</p>
</form>
