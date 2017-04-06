<hr>

<div class="row prev_next">

    <div class="col-xs-12 col-sm-6 prev_next_left">
        <?php if ($walk_pages['prev']) { ?>
            <a href="<?=$walk_pages['prev']['tytul_frd']?>">
            <p><i class="fa fa-arrow-circle-left"></i> poprzedni artykuł</p>
            <h4><?=$walk_pages['prev']['tytul']?></h4>
            </a>
        <?php } ?>
    </div>

    <div class="col-xs-12 col-sm-6 prev_next_right">
        <?php if ($walk_pages['next']) { ?>
            <a href="<?=$walk_pages['next']['tytul_frd']?>">
            <p>następny artykuł <i class="fa fa-arrow-circle-right"></i></p>
            <h4><?=$walk_pages['next']['tytul']?></h4>
            </a>
        <?php } ?>
    </div>

</div>
