<p class="button_bar">
    <a href="<?=base_url('admin/banners/newBanner')?>" class="btn btn-primary">Nowy baner</a>
</p>


<form method="post">

<table class="table table-striped tableBanners" data-table="banners">
<thead>
<tr>
    <th><input type="checkbox" class="bulkAll"></th>
    <th>kolejność<br><button type="button" data-table="banners" class="save kolej_save btn btn-danger">zapisz</button></th>
    <th>baner</th>
    <th>nazwa</th>
    <th>link</th>
    <th>strefa</th>
    <th>edytuj</th>
    <th>status</th>
    <th>usuń</th>

</tr>
</thead>
<tbody class="sortable">

<?php

if (isSet($banners)) foreach ($banners AS $f)
{

?>

<tr data-id="<?=$f->id?>">
    <td><input type="checkbox" name="bulk[<?=$f->id?>]" class="bulk"></td>
    <td class="handle"><span class="glyphicon glyphicon-sort"></span></td>
    <td>
        <?php if($f->plik != '') { ?>
        <img src="<?=base_url(BANNER_UPLOAD_FOLDER.$f->plik)?>">
        <?php } ?>
    </td>
    <td>
        <ul class="flag-list">
        <?php foreach ($langs AS $lang_id => $lang)
            {
                echo '<li>';
                echo '<img class="flag" src="'.base_url($lang['flag']).'">';
                echo '<span>'.htmlentities($f->lang_data[$lang_id]->nazwa).'</span>';
                echo '</li>';
            }
        ?>
        </ul>
    </td>
    <td><a href="<?=$f->link?>" class="external"><?=$f->link?></a></td>
    <td>
        <?=$banner_zones[$f->zone]?>
    </td>
    <td><a href="<?=site_url('admin/banners/edit/'.$f->id)?>" class="glyphicon glyphicon-pencil"></a></td>
    <td><span class="<?=$element_status[$f->status]['icon']?> switchStatus" title="<?=$element_status[$f->status]['name']?>"></span></td>
    <td><a href="<?=site_url('admin/banners/del/'.$f->id)?>" class="glyphicon glyphicon-trash delBanner confirm"></a></td>

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
    <?php foreach ($banner_zones AS $k => $c) { ?>
    <option value="<?=$k?>"><?=$c?></option>
    <?php } ?>
</select>

<input type="text" name="bulkRename" value=""/>

<button name="bulkSubmit" value="true" type="submit" class="btn-xs btn-primary">wykonaj</button>
</p>


</form>
