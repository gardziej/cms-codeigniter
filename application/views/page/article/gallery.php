
<div class="gallery" id="galeria">
    <?php
    foreach ($photos AS $f) {
        if (!isSet($f['noshow']))
            {
                echo '<a data-lightbox="';
                echo $f['id_page'];
                echo '" href="';
                echo PHOTO_UPLOAD_FOLDER.$f['plik'];
                echo '" title="';
                if (isSet($f['nazwa'])) echo $f['nazwa'];
                echo '"><img src="';
                echo PHOTO_UPLOAD_FOLDER.$f['crop'];
                echo '" class="img-responsive hov" alt="';
                if (isSet($f['nazwa'])) echo $f['nazwa'];
                echo '"></a>';
            }
    }
    ?>
</div>
