<div class="form-group">
    <label class="col-sm-3 control-label"><?=$f['cfg_description']?>
    <?=$f['req']?"*":" "?>

    </label>
    <div class="col-sm-9">

        <input type="text" value="<?=set_value('dane['.$f['cfg_name'].']', $f['cfg_value'])?>" class="form-control"
            name="dane[<?=$f['cfg_name']?>]" placeholder="<?=$f['cfg_description']?>">
        <?=form_error('dane['.$f['cfg_name'].']')?>

    </div>
</div>
