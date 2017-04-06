<p class="button_bar">
    <a href="<?=base_url('admin/guestbook/newPost')?>" class="btn btn-primary">Nowy wpis</a>
</p>



<form class="form-inline form-file-upload filtr" method="GET">
  <div class="form-group">
    <label for="nazwa">Status: </label>
    <select name="filtr_status" class="form-control">
        <option value="">--- WSZYSTKIE ---</option>
        <?php
            foreach ($element_status AS $k => $f)
                {
                    echo '<option value="'.$k.'"';
                    if ($filtr['status'] == $k) echo ' selected';
                    echo '>'.$f['name'].'</option>';
                }
        ?>
    </select>

  </div>
  <div class="form-group">
    <label for="nazwa">Lang: </label>
    <select name="filtr_lang" class="form-control">
        <option value="">--- WSZYSTKIE ---</option>
        <?php
            foreach ($langs AS $lang_id => $lang)
                {
                    echo '<option value="'.$lang_id.'"';
                    if ($filtr['lang'] == $lang_id) echo ' selected';
                    echo '>'.$lang['name'].'</option>';
                }
        ?>
    </select>
  </div>
  <button name="filtr" value="true" type="submit" class="btn btn-primary">filtruj</button>
</form>

<form method="post">

<table class="table table-striped tableGuestbook" data-table="guestbook">
<thead>
<tr>
    <th><input type="checkbox" class="bulkAll"></th>
    <th>język</th>
    <th>treść</th>
    <th>autor</th>
    <th>dodano</th>
    <th>edytuj</th>
    <th>status</th>
    <th>usuń</th>
</tr>
</thead>
<tbody class="sortable">

<?php
if (isSet($posts)) foreach ($posts AS $f)
{
?>

<tr data-id="<?=$f->id?>">
    <td><input type="checkbox" name="bulk[<?=$f->id?>]" class="bulk"></td>
    <td><img class="flag" src="<?=base_url($langs[$f->lang]['flag'])?>"></td>

    <td><?=$f->tekst?></td>
    <td><?=$f->autor?></td>
    <td><?=$f->dodano?></td>
    <td><a href="<?=site_url('admin/guestbook/edit/'.$f->id)?>" class="glyphicon glyphicon-pencil"></a></td>
    <td><span class="<?=$element_status[$f->status]['icon']?> switchStatus" title="<?=$element_status[$f->status]['name']?>"></span></td>
    <td><a href="<?=site_url('admin/guestbook/del/'.$f->id)?>" class="glyphicon glyphicon-trash delGuestbook confirm"></a></td>

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
</select>

<select name="bulkStatus">
    <?php foreach ($element_status AS $k => $ps) { ?>
    <option value="<?=$k?>"><?=$ps['name']?></option>
    <?php } ?>
</select>

<button name="bulkSubmit" value="true" type="submit" class="btn-xs btn-primary">wykonaj</button>
</p>


</form>
