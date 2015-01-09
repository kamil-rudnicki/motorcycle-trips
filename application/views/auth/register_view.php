<?php include($this->config->item('views_path').'_header.php'); ?>

<div class="row">
    <div class="col-sm-4">

        <legend><?=T_("Sign up")?></legend>

        <?=form_open('auth/register', array('id' => 'register_form', 'class' => ''))?>

            <div class="form-group"><input class="form-control" name="email_address" placeholder="E-mail" type="text"> <?=form_error('email_address')?></div>
            <div class="form-group"><input class="form-control" name="password" placeholder="<?=T_("Password")?>" type="password"> <?=form_error('password')?></div>
            <div class="form-group"><input class="form-control" name="confirm_password" placeholder="<?=T_("Confirm password")?>" type="password"> <?=form_error('confirm_password')?></div>





            <button class="btn btn-success btn-block" type="submit"><?=T_("Create free account")?></button>
            <a href="<?=site_url('auth/login')?>" class="btn-link btn-block"><?=T_("I already have an account")?></a>

        </form>
    </div>
</div>

<?php include($this->config->item('views_path').'_footer.php');