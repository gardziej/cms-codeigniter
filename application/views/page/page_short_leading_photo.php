<article class="article-short

<?php

if (isSet($page['traits']['cats'])) foreach ($page['traits']['cats'] AS $c)
    {
        if ($c['id'] == CATEGORY_HIGHLIGHT)
        {
            echo ' highlighted';
        }
    }

?>

">

<?php
$this->load->view('page/category/title', array('tytul' => $page['tytul'], 'link' => $page['tytul_frd'], 'dodano' => $page['data_publikacji']));

if (isSet($page['leading_photo']))
    {
        $this->load->view('page/category/tekst_leading_photo', array(
            'tekst' => cuts($page['tekst']),
            'leading_photo' => $page['leading_photo']
        ));
    }
    else
    {
        $this->load->view('page/category/tekst', array('tekst' => cuts($page['tekst'])));
    }
$this->load->view('page/category/more', array('link' => $page['tytul_frd']));
?>
</article>
