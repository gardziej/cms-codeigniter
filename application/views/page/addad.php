<div id="ad_form_box">
    <h1>Dodaj ogłoszenie</h1>
    <p class="ads-info">Zamieszczając ogłoszenia wyrażasz jednocześnie zgodę na warunki korzystania z portalu określone w regulaminie.</p>
    <form class="form-horizontal" method="POST" id="comments_form" enctype="multipart/form-data">
        <input type="hidden" name="parent_id" value="0">
        <div class="form-group">
            <label for="tytul" class="control-label col-sm-2">Tytuł:</label>
            <div class="col-sm-10">
                <input name="tytul" type="text" class="form-control" value="<?=set_value('tytul')?>" required>
                <?=form_error('tytul')?>
            </div>

        </div>
        <div class="form-group">
            <label for="tresc" class="control-label col-sm-2">Kategoria:</label>
            <div class="col-sm-10">
                <select class="form-control" name="category">
                    <?php
                        if (isSet($ads_cats) && count($ads_cats) > 0) foreach ($ads_cats AS  $f)
                            {
                                echo '<option value="'.$f->id.'"';
                                if ($f->id == set_value('category')) echo ' selected';
                                echo '>';
                    		    echo $f->nazwa.'</option>';
                            }
                    ?>
                </select>
                <?=form_error('category')?>
            </div>
        </div>
        <div class="form-group">
            <label for="tresc" class="control-label col-sm-2">Treść:</label>
            <div class="col-sm-10">
                <textarea name="tresc" class="form-control" required><?=set_value('tresc')?></textarea>
                <?=form_error('tresc')?>
            </div>

        </div>
        <div class="form-group">
            <label for="email" class="control-label col-sm-2">Email*:</label>
            <div class="col-sm-10">
                <input name="email" type="email" class="form-control" value="<?=set_value('email')?>" required>
                <p class="form-info">* Twój adres nie będzie nigdzie wyświetlany</p>
                <?=form_error('email')?>
            </div>

        </div>
        <div class="form-group">
            <label for="tytul" class="control-label col-sm-2">Zdjęcie:</label>
            <div class="col-sm-10">
                <input name="userfile[]" type="file" multiple>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button name="submit" value="true" type="submit" class="btn btn-warning">Dodaj</button>
            </div>
        </div>
    </form>
</div>
