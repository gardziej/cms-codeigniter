<div class="form-group">
    <label class="col-sm-3 control-label"><?=$f['cfg_description']?>
    <?=$f['req']?"*":" "?>

    </label>
    <div class="col-sm-9">

<div data-toggle="buttons">
<?php


    $cfg_options = json_decode($f['cfg_options']);

    if (!$cfg_options && strpos($f['cfg_options'], 'conf:') !== false)
    {
        $exp = explode(':', $f['cfg_options']);
        $name = $exp[1];
        $cfg_options = $this->config->item($name);
    }

    foreach ($cfg_options AS $key => $nazwa)
        {
            echo '<label class="btn btn-default';
            if ($key == $f['cfg_value']) echo ' active';
            echo '">';
            echo '<input name="dane['.$f['cfg_name'].']" type="radio" value="'.$key.'"';
            if ($key == $f['cfg_value']) echo ' checked';
            echo '>';
            echo $nazwa.'</label>';
        }
?>
</div>
<?=form_error('dane['.$f['cfg_name'].']')?>


    </div>
</div>
