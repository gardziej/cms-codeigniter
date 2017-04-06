<?php $p = $comment[0]; ?>

<form class="form-horizontal" method="POST" id="comments_form">
    <input type="hidden" name="parent_id" value="0">
    <div class="form-group">
        <label for="tresc" class="control-label col-sm-2">Komentarz:</label>
        <div class="col-sm-10">
            <textarea name="tresc" class="form-control" required><?=set_value('tresc', $p->tresc)?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="username" class="control-label col-sm-2">Imię:</label>
        <div class="col-sm-10">
            <input name="username" type="text" class="form-control" value="<?=set_value('username', $p->username)?>" required>
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="control-label col-sm-2">Email:</label>
        <div class="col-sm-10">
            <input name="email" type="email" class="form-control" value="<?=set_value('email', $p->email)?>" required>
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="control-label col-sm-2">IP:</label>
        <div class="col-sm-10">
            <input name="ip" type="text" class="form-control" value="<?=set_value('ip', $p->ip)?>" required>
        </div>
    </div>

    <div class="form-group">
        <label for="tekst" class="control-label col-sm-2">Nie edytowany<br>przez moderatora</label><br>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
            <?php
            foreach ($yes_no AS $key => $f)
                {
                    echo '<label class="btn btn-default';
                    if ($key == $p->edytowano) echo ' active';
                    echo '">';
                    echo '<input name="edytowano" type="radio" value="'.$key.'"';
                    if ($key == $p->edytowano) echo ' checked';
                    echo '>';
                    echo '<span class="'.$f['icon'].'"></span> '.$f['name'].'</label>';
                }
            ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button name="submit" value="true" type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </div>
    </div>
</form>
