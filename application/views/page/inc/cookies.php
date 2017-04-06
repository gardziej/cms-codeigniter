<?php
$this->load->helper('cookie');

if (!get_cookie('cookiesInfo')) { ?>
<div class="container-fluid" id="cookies">
    <div class="container">
        <p>Strona korzysta z plików cookie w celu realizacji usług zgodnie z <a href="<?=base_url('Polityka-Cookies')?>">polityką dotyczącą cookies</a>. <span class="btn btn-default btn-xs" id="closeCookies">Zamknij</span>
        </p>
    </div>
</div>
<?php } ?>

</body>
</html>
