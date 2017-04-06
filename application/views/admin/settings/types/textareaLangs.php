<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <?php foreach ($langs AS $lang_id => $lang)
        {
            echo '<li role="presentation"';
            if ($lang_main == $lang_id) { echo ' class="active"'; }
            echo '><a href="#'.$f['cfg_name'].'_'.$lang_id.'" aria-controls="'.$lang_id.'" role="tab" data-toggle="tab">';
            echo '<img class="flag" src="'.base_url($lang['flag']).'">';
            echo $lang['name'].'</a></li>';
        }
    ?>
</ul>

    <!-- Tab panes -->
    <div class="tab-content">
    <?php foreach ($langs AS $lang_id => $lang)
        {
        echo '<div role="tabpanel" class="tab-pane';
        if ($lang_main == $lang_id) { echo ' active'; }
        echo '" id="'.$f['cfg_name'].'_'.$lang_id.'">';
        ?>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?=$f['cfg_description']?>
                <?=$f['req']?"*":" "?>

                </label>
                <div class="col-sm-9">

    <textarea class="form-control" name="dane[<?=$f['cfg_name']?>][<?=$lang_id?>]"><?=set_value('dane['.$lang_id.']['.$f['cfg_name'].']', $f['lang_data'][$lang_id])?></textarea>
    <?=form_error('dane['.$f['cfg_name'].']['.$lang_id.']')?>

                </div>
            </div>
        </div>
        <?php } ?>
    </div>
