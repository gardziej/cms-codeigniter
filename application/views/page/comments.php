<?php

function printCommentsTree($comments, $comments_answer_available)
{
    foreach ($comments AS $id => $dane)
    {
        echo '<li data-id_comment="'.$id.'">';

        if ($dane['edytowano'])
        {
            $dane['tresc'] .= '<span class="edited">komentarz edytowany przez moderatora</span>';
        }

        if ($dane['status'] != 0)
        {
            $dane['username'] = '<span class="edited">'.$dane['username'][0].'...</span>';
            $dane['tresc'] = '<span class="removed">komentarz usunięty przez moderatora</span>';
        }

        echo '<div class="info">';
        echo '<span class="autor">'.$dane['username'].'</span> ';
        echo '<span class="data_publikacji">'.datePL('l j f Y G:i:s',strtotime($dane['dodano'])).'</span> ';
        if ($dane['status'] == 0 && $comments_answer_available) echo '<span class="answer">odpowiedz</span>';
        echo '</div>';
        echo '<div class="tresc">';
        echo $dane['tresc'];
        echo '</div>';

        if (isSet($dane['children']) AND count($dane['children']) > 0)
        {
            echo '<ul>';
            printCommentsTree($dane['children'], $comments_answer_available);
            echo '</ul>';
        }
        echo '</li>';
    }
}

echo '<ul>';
printCommentsTree($comments, $this->cfg->get('comments_answer_available'));
echo '</ul>';
