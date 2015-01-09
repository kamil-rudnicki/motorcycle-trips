<?php include($this->config->item('views_path').'_header.php'); ?>

<div class="row">
    <div class="col-sm-4">
        <legend><?=T_("Log in")?></legend>
        <form accept-charset="UTF-8" action="" method="post">
            <div class="form-group"><input class="form-control" name="email_address" placeholder="E-mail" type="text"> <?=form_error('email_address')?></div>
            <div class="form-group"><input class="form-control" name="password" placeholder="<?=T_("Password")?>" type="password"> <?=form_error('password')?></div>
            <div class="form-group">
                <?php
                // checked or not
                if ($this->input->post('remember_me') !== false) {$checked = $this->input->post('remember_me');}
                else {$checked = get_cookie('remember_me');}
                ?>
                <?php
                $checkbox = form_checkbox(array('name' => 'remember_me', 'id' => 'remember_me_field', 'value' => '1', 'checked' => (boolean)$checked));
                ?>
                <?=form_label($checkbox . ' <span>'.T_("Remember Me").'</span>', 'remember_me_field', array('class' => 'checkbox'))?>
            </div>
            <button class="btn btn-success btn-block" type="submit"><?=T_("Log in")?></button>
            <a href="<?=site_url('auth/request_reset_password')?>" class="btn-link btn-block"><?=T_("Forgot password")?></a>
            <a href="<?=site_url('auth/register')?>" class="btn-link btn-block"><?=T_("Don't have account?")?></a>
        </form>
    </div>
</div>

<?php include($this->config->item('views_path').'_footer.php');