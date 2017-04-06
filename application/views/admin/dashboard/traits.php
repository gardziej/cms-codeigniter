<div class="row">

    <?php if (!empty($tags)) { ?>
    <div class="col-xs-6">

        <div class="panel panel-default">
            <div class="panel-heading">Tagi</div>
            <div class="panel-body">

                <div class="list-group">
                <?php foreach ($tags AS $trait_id => $t) { ?>
                    <a class="list-group-item" href="<?=base_url('admin/pages')?>?filtr_type=1&filtr_cat=&filtr_tag=<?=$trait_id?>&filtr_ad=&search_text=&filtr_make=true">
                        <?=$t['nazwa']?>
                        <span class="pull_right badge"><?=$t['count']?></span>
                    </a>
                <?php } ?>

                </div>

            </div>
        </div>

    </div>
    <?php } ?>

    <?php if (!empty($categories)) { ?>
    <div class="col-xs-6">

        <div class="panel panel-default">
            <div class="panel-heading">Kategorie</div>
            <div class="panel-body">

                <div class="list-group">
                <?php foreach ($categories AS $trait_id => $t) { ?>
                    <a class="list-group-item" href="<?=base_url('admin/pages')?>?filtr_type=1&filtr_cat=<?=$trait_id?>&filtr_tag=&filtr_ad=&search_text=&filtr_make=true">
                        <?=$t['nazwa']?>
                        <span class="pull_right badge"><?=$t['count']?></span>
                    </a>
                <?php } ?>

                </div>

            </div>
        </div>

    </div>
    <?php } ?>

</div>
