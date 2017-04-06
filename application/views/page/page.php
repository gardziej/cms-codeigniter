<article>
<?php
if (isSet($tags) && count($tags) > 0) $this->load->view('page/article/tags', array('tags' => $tags));
$this->load->view('page/article/title', array(
    'tytul' => $page['tytul'],
    'dodano' => $page['dodano'],
    'comments_text' => commentsText($page['comments_count'])
));
if (isSet($photos) && count($photos) == 1) $this->load->view('page/article/gallery_one_photo', array('photos' => $photos));
$this->load->view('page/article/tekst', array('tekst' => $page['tekst']));
if ($this->cfg->get('facebook_likeit'))
    {
        $this->load->view('page/article/likeit');
    }
if (isSet($files) && count($files) > 0) $this->load->view('page/article/files', array('files' => $files));
if (isSet($photos) && count($photos) > 1) $this->load->view('page/article/gallery', array('photos' => $photos));
if (isSet($page['cons']))
    {
        $test = false;

        foreach ($page['cons'] AS $cons)
            {
                if ($cons['type'] == TYPE_PAGE) $test = true;
            }

        if ($test) $this->load->view('page/article/subs', array('subs' => $page['cons']));
    }
?>
</article>

<?php $this->load->view('page/article/prev_next'); ?>

<?php if ($page['comments_show'] == 0) {?>
<div id="comments">
    <?php if ($page['comments_allow'] == 0) {?>
    <div id="comments_form_box">
        <h2>A co Ty o tym myślisz?</h2>
        <form class="form-horizontal" method="POST" id="comments_form">
            <input type="hidden" name="parent_id" value="0">
            <div class="form-group">
                <label for="tresc" class="control-label col-sm-2">Komentarz:</label>
                <div class="col-sm-10">
                    <textarea name="tresc" class="form-control" required></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="control-label col-sm-2">Imię:</label>
                <div class="col-sm-10">
                    <input name="username" type="text" class="form-control" value="" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="control-label col-sm-2">Email*:</label>
                <div class="col-sm-10">
                    <input name="email" type="email" class="form-control" value="" required>
                    <p class="form-info">* Twój adres nie będzie nigdzie wyświetlany</p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-warning">Skomentuj</button>
                    <span class="abort">anuluj odpowiadanie</span>
                </div>
            </div>
       </form>
    </div>
    <?php } else { echo '<p class="label label-warning">Możliwość komentowania na tej podstronie została wyłączona.</p>';} ?>
    <div id="comments_list" data-id_page="<?=$page['id']?>">
    </div>
</div>
<?php } else { echo '<p class="label label-warning">Komentarze na tej podstronie zostały ukryte.</p>';}?>
