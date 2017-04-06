<div class="files">
    <h3>Do pobrania</h3>
    <ul>
        <?php foreach ($files AS $f) {
            echo '<li><a href="';
            echo FILE_UPLOAD_FOLDER.$f['plik'];
            echo '">';
            echo '<img class="icon" src="'.FILE_ICONS_S_FOLDER.$f['rozszerzenie'].'.png"> ';
            echo $f['nazwa'];
            if ($f['waga'] > 0) echo ' ('.$f['waga'].'kb)';
            echo '</a></li>';
        } ?>
    </ul>
</div>
