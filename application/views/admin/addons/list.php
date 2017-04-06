<p class="button_bar">
    <a href="<?=base_url('admin/addons/newAddon')?>" class="btn btn-primary">Nowy dodatek</a>
</p>


<form method="post">

<table class="table table-striped tableAddons" data-table="addons">
<thead>
<tr>
    <th><input type="checkbox" class="bulkAll"></th>
    <th>kolejność<br><button type="button" data-table="addons" class="save kolej_save btn btn-danger">zapisz</button></th>
    <th>nazwa</th>
    <th>strefa</th>
    <th>edytuj</th>
    <th>status</th>
    <th>usuń</th>

</tr>
</thead>
<tbody class="sortable">

<?php

if (isSet($addons)) foreach ($addons AS $f)
{

?>

<tr data-id="<?=$f->id?>">
    <td><input type="checkbox" name="bulk[<?=$f->id?>]" class="bulk"></td>
    <td class="handle"><span class="glyphicon glyphicon-sort"></span></td>
    <td><?=$f->nazwa?></td>
    <td><?=$addon_zones[$f->zone]?></td>
    <td><a href="<?=site_url('admin/addons/edit/'.$f->id)?>" class="glyphicon glyphicon-pencil"></a></td>
    <td><span class="<?=$element_status[$f->status]['icon']?> switchStatus" title="<?=$element_status[$f->status]['name']?>"></span></td>
    <td><a href="<?=site_url('admin/addons/del/'.$f->id)?>" class="glyphicon glyphicon-trash delAddon confirm"></a></td>

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
    <option value="bulkZone">zmień strefę na</option>
</select>

<select name="bulkStatus">
    <?php foreach ($element_status AS $k => $ps) { ?>
    <option value="<?=$k?>"><?=$ps['name']?></option>
    <?php } ?>
</select>

<select name="bulkZone">
    <?php foreach ($addon_zones AS $k => $c) { ?>
    <option value="<?=$k?>"><?=$c?></option>
    <?php } ?>
</select>

<input type="text" name="bulkRename" value=""/>

<button name="bulkSubmit" value="true" type="submit" class="btn-xs btn-primary">wykonaj</button>
</p>


</form>
