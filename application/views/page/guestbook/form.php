<p class="button_bar">
    <a href="#" class="btn btn-primary showGuestbookForm">Dopisz się :)</a>
</p>

<form class="form-horizontal guestbookForm" method="post">

    <div class="form-group">
        <label for="link" class="col-sm-2 control-label">Treść</label>
        <div class="col-sm-10">
            <textarea name="tekst" class="form-control"><?=set_value('tekst')?></textarea>
            <?=form_error('tekst')?>
        </div>
    </div>

    <div class="form-group guestbookEmail">
        <label for="tytul" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" value="" class="form-control" name="email" placeholder="Email">
        </div>
    </div>

    <div class="form-group">
        <label for="tytul" class="col-sm-2 control-label">Imię</label>
        <div class="col-sm-10">
            <input type="text" value="<?=set_value('autor')?>" class="form-control" name="autor" placeholder="Imię" required>
            <?=form_error('login')?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button name="submit" value="true" type="submit" class="btn btn-primary">Zapisz</button>
        </div>
    </div>

</form>
