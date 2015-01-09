<?php include('_header.php'); ?>

    <div class="row">
        <div class="col-sm-4">
            <legend><?=T_("Log in")?></legend>
            <form accept-charset="UTF-8" action="" method="post">
                <div class="form-group"><input class="form-control" name="username" placeholder="E-mail" type="text"></div>
                <div class="form-group"><input class="form-control" name="password" placeholder="<?=T_("Password")?>" type="password"></div>
                <button class="btn btn-success btn-block" type="submit"><?=T_("Log in")?></button>
                <a href="<?=site_url('user/forgottenpassword')?>" class="btn-link btn-block"><?=T_("Forgot password")?></a>
            </form>
        </div>
    </div>

<?php include('_footer.php'); ?>