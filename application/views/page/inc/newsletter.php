    <div id="newsletter">
        <form class="form form-newsletter" method="POST" action="<?=base_url('newsletter')?>">
            <div class="form-group">
                <label for="nazwa">newsletter <span class="glyphicon glyphicon-envelope"></span></label>
                <input type="text" class="form-control input-sm" name="newsletter" value="<?=set_value('newsletter')?>" placeholder="twój email" required>
                <?=form_error('newsletter')?>
            </div>
            <div class="form-group">
            <button name="submit_newsletter" value="true" type="submit" class="btn btn-primary btn-xs">zapisz się</button>
            <button name="remove_newsletter" value="true" type="submit" class="btn btn-default btn-xs">wypisz się</button>
            </div>
        </form>
    </div>
