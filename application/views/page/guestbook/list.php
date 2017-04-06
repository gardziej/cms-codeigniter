<div class="guestbook">
<?php foreach ($posts AS $f) { ?>
    <div>
        <p class="post"><?=$f['tekst']?></p>
        <p class="author"><?=$f['autor']?></p>
    </div>
<?php } ?>
</div>
