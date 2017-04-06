<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if (!function_exists('pagination'))
{
    function pagination ($elements, $current, $zakres)
        {

        if (!$zakres) return false;

        $all = ceil($elements / $zakres);

         if ($current > ($zakres + 2) AND $current < ($all - $zakres - 1)) $zakres = $zakres - 2;

         $zakres = min($zakres, 2);

         $startS = $current - $zakres; if ($startS < 1) {  $startS = 1; }
         $endS   = $current + $zakres; if ($endS > $all) {  $endS = $all; }

         if ($current > 1)    $prevS = $current - 1;
         if ($current < $all) $nextS = $current + 1;

         $next10 = ceil($current / 10) * 10;
         if ($next10 <= $current+$zakres+1) $next10 = $next10 + 10;
         if ($next10 >= $all) unset ($next10);

         $prev10 = floor($current / 10) * 10;
         if ($prev10 >= $current-$zakres-1) $prev10 = $prev10 - 10;
         if ($prev10 <= 1) unset ($prev10);

         $prev100 = floor($current / 100) * 100;
         if ($prev100 >= $current-$zakres) $prev100 = $prev100 - 100;
         if ($prev100 <= 1 OR $prev100 == $prev10) unset ($prev100);

         if ($all > 1)
              {
              echo '<div style="clear:both;height:1px;"><!-- --></div>';
              echo '<p class="linki_kontener">';

              if (isSet($prevS)) echo linku($prevS, '<span class="poprzednia">&laquo;</span>');

              if ($current > ($zakres+1))
                   {
                   echo linku(1);
                   if (isSet($prev100)) { echo '<span class="kropki">...</span>'; echo linku($prev100); }
                   if (isSet($prev10)) { echo '<span class="kropki">...</span>'; echo linku($prev10); }
                   if ($current > ($zakres+2)) echo '<span class="kropki">...</span>';
                   }

              for ($i = $startS; $i < $current; $i++)
                   {
                   echo linku($i);
                   }

              echo '<span class="link">'.$current.'</span>';

              if ($current < $all) for ($i = $nextS; $i <= $endS; $i++)
                   {
                   echo linku($i);
                   }

              if ($current < ($all - $zakres))
                   {
                   if ($current < ($all - $zakres - 1)) echo '<span class="kropki">...</span>';
                   if (isSet($next10)) { echo linku($next10); echo '<span class="kropki">...</span>'; }
                   if (isSet($next100)) { echo linku($next100); echo '<span class="kropki">...</span>'; }
                   echo linku($all);
                   }

              if (isSet($nextS)) echo linku($nextS, '<span class="nastepna">&raquo;</span>');

              echo '</p>';
              echo '<div style="clear:both;height:1px;"><!-- --></div>';
              }
        }
}

if (!function_exists('linku'))
{
    function linku($current, $text = null) //funkcja tworzaca odpowiednie linki
         {
         if ($text == null) {$text = $current; }
         echo '<a href="'.current_url().'?p='.$current.'">'.$text.'</a>';
         }
}
