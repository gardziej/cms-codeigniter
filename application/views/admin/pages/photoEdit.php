<form class="form-horizontal" method="post">

<p class="button_bar">
    <button name="submit" value="true" type="submit" class="btn btn-primary">Zapisz zmiany</button>
    <a href="<?=base_url('admin/pages/photos/'.$page_id)?>" class="btn btn-default">Powrót do listy zdjęć</a>
</p>

<div class="photoCrop">

    <h3>Zdjęcie oryginalne</h3>
    <div class="photoBox photoCropOrg">
        <div class="photo">
            <img src="<?=base_url(PHOTO_UPLOAD_FOLDER.$photo->plik).'?'.md5(uniqid(mt_rand()))?>">
        </div>
        <p class="cords">
        	<label>X1 <input type="text" size="4" class="x" name="org[cords][x]" /></label>
        	<label>Y1 <input type="text" size="4" class="y" name="org[cords][y]" /></label>
        	<label>X2 <input type="text" size="4" class="x2" name="org[cords][x2]" /></label>
        	<label>Y2 <input type="text" size="4" class="y2" name="org[cords][y2]" /></label>
        	<label>SZ <input type="text" size="4" class="w" name="org[cords][w]" /></label>
        	<label>WY <input type="text" size="4" class="h" name="org[cords][h]" /></label>
            <input type="hidden" name="org[plik]" value="<?=$photo->plik?>"/>
        </p>
    </div>

    <hr style="clear: both">

    <h3>Ikona</h3>
    <div class="photoBox photoCropIcon">
        <div class="photo">
            <img src="<?=base_url(PHOTO_UPLOAD_FOLDER.$photo->plik).'?'.md5(uniqid(mt_rand()))?>">
        </div>
        <p class="cords">
        	<label>X1 <input type="text" size="4" class="x" name="icon[cords][x]" /></label>
        	<label>Y1 <input type="text" size="4" class="y" name="icon[cords][y]" /></label>
        	<label>X2 <input type="text" size="4" class="x2" name="icon[cords][x2]" /></label>
        	<label>Y2 <input type="text" size="4" class="y2" name="icon[cords][y2]" /></label>
        	<label>SZ <input type="text" size="4" class="w" name="icon[cords][w]" /></label>
        	<label>WY <input type="text" size="4" class="h" name="icon[cords][h]" /></label>
            <input type="hidden" name="icon[plik]" value="<?=$photo->icon?>"/>
        </p>
    </div>

    <hr>

    <h3>Ikona kwadratowa</h3>
    <div class="photoBox photoCropCrop">
        <div class="photo">
            <img src="<?=base_url(PHOTO_UPLOAD_FOLDER.$photo->plik).'?'.md5(uniqid(mt_rand()))?>">
        </div>
        <p class="cords">
        	<label>X1 <input type="text" size="4" class="x" name="crop[cords][x]" /></label>
        	<label>Y1 <input type="text" size="4" class="y" name="crop[cords][y]" /></label>
        	<label>X2 <input type="text" size="4" class="x2" name="crop[cords][x2]" /></label>
        	<label>Y2 <input type="text" size="4" class="y2" name="crop[cords][y2]" /></label>
        	<label>SZ <input type="text" size="4" class="w" name="crop[cords][w]" /></label>
        	<label>WY <input type="text" size="4" class="h" name="crop[cords][h]" /></label>
            <input type="hidden" name="crop[plik]" value="<?=$photo->crop?>"/>
        </p>
        <?=form_error('crop[cords][w]')?>
    </div>

</div>

<p class="button_bar">
    <button name="submit" value="true" type="submit" class="btn btn-primary">Zapisz zmiany</button>
    <a href="<?=base_url('admin/pages/photos/'.$page_id)?>" class="btn btn-default">Powrót do listy zdjęć</a>
</p>

</form>
