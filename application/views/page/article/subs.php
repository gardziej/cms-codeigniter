
<div class="subs">
    <h3>Zobacz także</h3>
    <ul>
        <?php foreach ($subs AS $f) {
            if ($f['type'] == 1)
                {
                    echo '<li><i class="fa fa-pencil fa-fw">';
                }
                else
                {
                    echo '<li><i class="fa fa-image fa-fw">';
                }
            echo '</i>&nbsp; <a href="';
            echo base_url($f['tytul_frd']);
            echo '">';
            echo $f['tytul'];
            echo '</a></li>';

        } ?>
    </ul>
</div>
