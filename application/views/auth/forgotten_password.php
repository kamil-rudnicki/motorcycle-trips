<?php include($this->config->item('views_path').'_header.php'); ?>

    <div class="row">
        <div class="col-sm-4">
            <legend><?=T_("Forgot password")?></legend>
            <form accept-charset="UTF-8" action="" method="post">
                <div class="form-group"><input class="form-control" name="email_address" placeholder="E-mail" type="text"> <?=form_error('email_address')?></div>
                <button class="btn btn-success btn-block" type="submit"><?=T_("Forgot password")?></button>
            </form>
        </div>
    </div>

<?php include($this->config->item('views_path').'_footer.php');