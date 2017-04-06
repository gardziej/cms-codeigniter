<div class="tags"><ul>
<?php
foreach ($tags AS $t)
    {
        echo '<li><a href="'.base_url().$t['nazwa_frd'].'"';
        echo ' style="background: #'.$t['kolor'].'; color: #'.$t['font'].'"';
        echo '>'.$t['nazwa'].'</a></li>';
    }
?>
</ul></div>
