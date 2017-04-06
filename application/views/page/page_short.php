<article>
<?php

$this->load->view('page/category/title', array(
    'tytul' => $page['tytul'],
    'link' => $page['tytul_frd'],
    'dodano' => $page['data_publikacji']));
$this->load->view('page/category/tekst', array('tekst' => cuts($page['tekst'])));
$this->load->view('page/category/more', array('link' => $page['tytul_frd']));
?>
</article>
