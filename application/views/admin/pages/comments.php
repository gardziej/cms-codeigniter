<div class="page_preview">
        <?php foreach ($langs AS $lang_id => $lang)
            {
            if (isSet($p->lang_data[$lang_id]->tytul) && $p->lang_data[$lang_id]->tytul != '')
                {
                    echo '<h5>';
                    echo '<img class="flag" src="'.base_url($lang['flag']).'">';
                    echo $p->lang_data[$lang_id]->tytul;
                    echo '</h5>';
                }
            }
        ?>
</div>

<?php

function printCommentsTree($comments, $element_status, $p)
{
    foreach ($comments AS $id => $dane)
    {
        echo '<li data-id_comment="'.$id.'">';
        echo '<div class="info">';

        echo '<span class="'.$element_status[$dane['status']]['icon'].' switchStatus"
                    title="'.$element_status[$dane['status']]['name'].'"></span>';
        echo '<span class="glyphicon glyphicon-trash delComment confirm"></span>';
        echo '<a href="'.site_url('admin/pages/comments/'.$p->id.'/edit/'.$id).'"
                    class="glyphicon glyphicon-pencil"></a>';

        echo '<span class="autor">'.$dane['username'].' '.$dane['ip'].' '.$dane['email'].'</span> ';
        echo '<span class="data_publikacji">'.datePL('l j f Y G:i:s',strtotime($dane['dodano'])).'</span> ';
        echo '</div>';
        echo '<div class="tresc">';
        echo $dane['tresc'];
        echo '</div>';

        if (isSet($dane['children']) AND count($dane['children']) > 0)
        {
            echo '<ul>';
            printCommentsTree($dane['children'], $element_status, $p);
            echo '</ul>';
        }
        echo '</li>';
    }
}

echo '<div id="comments_list"><ul>';
printCommentsTree($comments, $element_status, $p);
echo '</ul></div>';
