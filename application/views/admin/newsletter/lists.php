<?php foreach ($lists AS $lang => $list) { ?>

        <h2><img class="flag" src="<?=base_url($langs[$lang]['flag'])?>">maile <?=$langs[$lang]['name']?>e</h2>

        <textarea class="emails"><?=implode("\n", $list)?></textarea>

<?php } ?>
