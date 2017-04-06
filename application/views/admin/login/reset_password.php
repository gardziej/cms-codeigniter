<div class="container">

    <form class="form-signin admin-login" method="post">
        <h3 class="form-signin-heading">resetowanie hasła <span class="passwordStrengthMeter"></span></h3>

        <label for="password" class="sr-only">Hasło:</label>
        <input type="password" name="password" value="<?=set_value('password')?>" class="form-control checkStrength" placeholder="Nowe hasło" required autofocus>
        <?=form_error('password')?>

        <label for="password2" class="sr-only">Powtórz hasło:</label>
        <input type="password" name="password2" value="<?=set_value('password2')?>" class="form-control" placeholder="Powtórz hasło" required autofocus>
        <?=form_error('password2')?>

        <button class="btn btn-primary btn-block" type="submit">wyślij</button>

    </form>

</div>
