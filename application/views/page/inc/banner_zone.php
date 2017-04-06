<div>
    <ul class="banner_zone banner_zone_<?=$zone_id?>">

<?php

if (isSet($banners[$zone_id]))
    {
	foreach ($banners[$zone_id] AS $f)
		{
            if (empty($f['cat_only']) || count(array_intersect($f['cat_only'], $banners_cats)))
                {
        			echo '<li>';
                    if (filter_var($f['link'], FILTER_VALIDATE_URL))
                        {
                            echo '<a href="'.$f['link'].'"';
        			        if ($f['link_target'] == 1) echo ' class="external"';
        			        echo '>';
                        }
        			if ($f['plik'])
        				{
        					echo '<img src="'.BANNER_UPLOAD_FOLDER.$f['plik'].'" title="'.$f['nazwa'].'">';
        				}
        				else
        				{
        					echo $f['nazwa'];
        				}
                    if (filter_var($f['link'], FILTER_VALIDATE_URL))
                        {
                            echo '</a>';
                        }
        			echo '</li>'."\n";
                }
		}
    }
?>

    </ul>
</div>
