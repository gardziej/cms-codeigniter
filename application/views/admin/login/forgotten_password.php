<div class="container">

    <form class="form-signin admin-login" method="post">
        <h3 class="form-signin-heading">przypomnienie hasła</h3>

        <label for="email" class="sr-only">Email:</label>
        <input type="email" name="email" value="<?=set_value('email')?>" class="form-control" placeholder="Adres Email" required autofocus>
        <?=form_error('email')?>

        <button class="btn btn-primary btn-block" type="submit">wyślij</button>

        <p class="forgotten_password">
            <a href="<?=site_url('admin/login')?>">logowanie</a>
        </p>

    </form>

</div>
