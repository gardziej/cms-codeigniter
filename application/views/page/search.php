<div class="categoriesList">
<?php
echo '<h1>Wyniki wyszukiwania</h1>';

if (count($categories['list']) > 0)
    {
        echo '<h4>Dla Twojego zapytania "<strong>'.$categories['fraza'].'</strong>" znaleźliśmy:</h4>';
        foreach ($categories['list'] AS $f)
            {
                $this->load->view('page/page_short', array('page' => $f));
            }
    }
    else
    {
        echo '<div class="alert alert-warning">';
        echo '<p>Niestety, zapytania "<strong>'.$categories['fraza'].'</strong>" nie udało się dopasować.</p>';
        echo '<p>Spróbuj zmienić zapytanie lub skorzystaj z menu strony.</p>';
        echo '</div>';
    }
?>
</div>
