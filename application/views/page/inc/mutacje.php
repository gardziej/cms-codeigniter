<?php
if (isSet($mutacje['mutacja']))
	{
        echo '<div class="container" id="mutacje">';
		foreach ($mutacje['mutacja'] AS $k => $m)
			{
				if (!empty($m))
					{
						echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">';
	    					echo '<div class="mutacja" style="background-color: #'.$m['kolor'].'">';

	                        echo '<h4 style="color: #'.$m['font'].'">'.$m['nazwa'].'</h4>';

							if ($m['tekst'] != '')
								{
									echo '<p class="mutacja-opis">'.$m['tekst'].'</p>';
								}

	                        $id = $m['list'][0]['id'];
	                        echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
	                        if (isSet($m['list'], $m['list'][0], $m['list'][0]['tytul']))
	                            {
	                                echo '<h5 style="color: #'.$m['font'].'">'.$m['list'][0]['tytul'].'</h5>';
	                            }
							if (isSet($mutacje['files'], $mutacje['files'][$id], $mutacje['files'][$id]['plik']))
								{
	                        		echo '<a class="mutacje-pobierz" href="'.FILE_UPLOAD_FOLDER.$mutacje['files'][$id]['plik'].'">';
									echo '<strong>pobierz</strong><br><span>rozmiar: '.decorate_file_size($mutacje['files'][$id]['waga']).'</span></a>';
								}

	                        echo '<a style="color: #'.$m['font'].'; text-decoration: underline;" href="'.base_url().$m['nazwa_frd'].'">Numery archiwalne</a>';

	                        echo '</div>';

	                        echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
							if (isSet($mutacje['files'], $mutacje['files'][$id], $mutacje['files'][$id]['plik'], $mutacje['photos'], $mutacje['photos'][$id], $mutacje['photos'][$id]['icon']))
								{
	                        		echo '<a href="'.FILE_UPLOAD_FOLDER.$mutacje['files'][$id]['plik'].'" ><img src="'.PHOTO_UPLOAD_FOLDER.$mutacje['photos'][$id]['icon'].'"></a>';
								}
	                        echo '</div>';

	                    echo '</div>';
					echo '</div>';
					}
			}
        echo '</div>';
	}
?>

<hr class="mutacje-line">
