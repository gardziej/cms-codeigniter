<form class="form-horizontal" method="post">

    <div class="form-group">
        <label for="tytul" class="col-sm-2 control-label">Imię</label>
        <div class="col-sm-10">
            <input type="text" value="<?=set_value('login', $p->login)?>" class="form-control" name="login" placeholder="Nazwa użytkownika" required>
            <?=form_error('login')?>
        </div>
    </div>

    <div class="form-group">
        <label for="link" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" value="<?=set_value('email', $p->email)?>" class="form-control" name="email" placeholder="Email" required>
            <?=form_error('email')?>
        </div>
    </div>

    <div class="form-group">
        <label for="link" class="col-sm-2 control-label">Hasło</label>
        <div class="col-sm-5">
            <input type="password" value="" class="form-control checkStrength" name="password" placeholder="Hasło" autocomplete="off">
            <?=form_error('password')?>
        </div>
        <div class="col-sm-5"><span class="passwordStrengthMeter"></span></div>
    </div>

    <div class="form-group">
        <label for="link" class="col-sm-2 control-label">Powtórz hasło</label>
        <div class="col-sm-5">
            <input type="password" value="" class="form-control" name="password2" placeholder="Powtórz hasło" autocomplete="off">
            <?=form_error('password2')?>
        </div>
    </div>

    <div class="form-group">
        <label for="locked" class="col-sm-2 control-label">Stan</label>
        <div class="col-sm-10 btn-group" data-toggle="buttons">
        <?php

        foreach ($admin_locked AS $key => $f)
            {
                echo '<label class="btn btn-default';
                if ($key == $p->locked) echo ' active';
                echo '">';
                echo '<input name="locked" type="radio" value="'.$key.'"';
                if ($key == $p->locked) echo ' checked';
                echo '>';
                echo $f.'</label>';
            }
        ?>
        </div>
    </div>

    <div class="form-group">
        <label for="level" class="col-sm-2 control-label">Rola</label>
        <div class="col-sm-10 btn-group" data-toggle="buttons">
        <?php

        foreach ($admin_role AS $key => $f)
            {
                if ($key > 0)
                {
                    echo '<label class="btn btn-default';
                    if ($key == $p->level) echo ' active';
                    echo '">';
                    echo '<input name="level" type="radio" value="'.$key.'"';
                    if ($key == $p->level) echo ' checked';
                    echo '>';
                    echo $f.'</label>';
                }
            }
        ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button name="submit" value="true" type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </div>
    </div>


    <h2 class="page-header">Przywileje <input type="checkbox" class="togglePermsAll"></h2>

    <?php
    foreach ($admin_menu AS $am)
        {
            if(isSet($am['permissions']))
            {
                    echo '<div class="form-group permsBox">';
                        echo '<label class="col-sm-2 control-label">'.$am['name'].' <input type="checkbox" class="togglePermsBox"/></label>';
                        echo '<div class="col-sm-10 btn-group" data-toggle="buttons">';
                        foreach ($am['permissions'] AS $key => $f)
                            {
                                echo '<label class="btn btn-default';
                                if ($user_permission[$am['id'].'::'.$key] == 1) echo ' active';
                                echo '">';
                                echo '<input name="perms['.$am['id'].'::'.$key.']" type="checkbox" value="1"';
                                if ($user_permission[$am['id'].'::'.$key] == 1) echo ' checked';
                                echo '>';
                                echo $f.'</label>';
                            }
                        echo '</div>';
                    echo '</div>';

            }
        }
    ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button name="submit" value="true" type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </div>
    </div>

</form>
