<div class="container">

    <form class="form-signin admin-login" method="post">
        <h3 class="form-signin-heading">logowanie do panelu</h3>
        <h4 class="form-signin-heading">login: demo@user.pl, hasło: 12345</h4>
        <label for="email" class="sr-only">Email:</label>
        <input type="email" name="email" value="<?=set_value('email')?>" class="form-control" placeholder="Adres Email" required autofocus>
        <?=form_error('email')?>

        <label for="password" class="sr-only">Hasło:</label>
        <input type="password" name="password" class="form-control" placeholder="Hasło" required>
        <?=form_error('password')?>

        <?php  if (isSet($captcha) && $captcha) { ?>
        <div class="captcha">
            <?='<h4>Przepisz pięć cyfr z obrazka</h4>'?>
            <?=form_error('captcha')?>
            <span id="captchaImage"><?=$captcha_img?></span>
            <span class="glyphicon glyphicon-refresh" id="refreshCaptcha"></span>
            <input type="text" name="captcha" placeholder=" <-- przepisz kod" value="" required/>
        </div>
        <?php } ?>

        <button class="btn btn-primary btn-block" type="submit">zaloguj mnie</button>

        <p class="forgotten_password">
            <a href="<?=site_url('admin/login/forgotten_password')?>">nie pamiętam hasła</a>
        </p>

    </form>

</div>
