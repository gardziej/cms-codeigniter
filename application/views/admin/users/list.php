<p class="button_bar"><a href="<?=base_url('admin/users/newUser')?>" class="btn btn-primary">Nowy użytkownik</a></p>
<form method="post">
<table class="table table-striped tableUsers">
<thead>
<tr>
    <th><input type="checkbox" class="bulkAll"></th>
    <th>imię</th>
    <th>email</th>
    <th>rola</th>
    <th>stan</th>
    <th>edytuj</th>
    <th>usuń</th>
</tr>
</thead>
<tbody>

<?php

foreach ($users AS $u)
{

?>

<tr data-id="<?=$u->admin_id?>">
    <td><input type="checkbox" name="bulk[<?=$u->admin_id?>]" class="bulk"></td>
    <td><?=$u->login?></td>
    <td><?=$u->email?></td>
    <td><?=$admin_role[$u->level]?></td>
    <td><?=$admin_locked[$u->locked]?></td>

    <td>
    <?php if ($u->level >= 1) { ?>
        <a href="<?=site_url('admin/users/edit/'.$u->admin_id)?>" class="glyphicon glyphicon-pencil"></a>
    <?php } ?>
    </td>

    <td>
    <?php if ($u->level >= 5) { ?>
        <a href="<?=site_url('admin/users/del/'.$u->admin_id)?>" class="glyphicon glyphicon-trash delUser confirm"></a>
    <?php } ?>
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
    <option value="bulkDel">usuń zaznaczone</option>
    <option value="bulkStan">zmień stan na</option>
</select>

<select name="bulkStan">
    <?php foreach ($admin_locked AS $k => $al) { ?>
    <option value="<?=$k?>"><?=$al?></option>
    <?php } ?>
</select>

<input type="text" name="bulkRename" value=""/>

<button name="bulkSubmit" value="true" type="submit" class="btn-xs btn-primary">wykonaj</button>
</p>

<p class="button_bar"><a href="<?=base_url('admin/users/newUser')?>" class="btn btn-primary">Nowy użytkownik</a></p>
