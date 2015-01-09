<!DOCTYPE html>
<html lang="en" ng-app>
<head>

    <meta charset="utf-8">
    <link rel="stylesheet" href="<?=site_url()?>res/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=site_url()?>res/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=site_url()?>res/style.css">
    <title><?=T_("Motorcycle Rides")?></title>

</head>
<body>



    <div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?=site_url('')?>" title="<?=T_("Go to home page")?>"><?=T_("Motorcycle Rides")?> - podróżuj z innymi</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <!--<li class="active"><a href="#">All</a></li>
                    <li><a href="#about">1 day</a></li>
                    <li><a href="#contact">2 days</a></li>
                    <li><a href="#contact">3+ days</a></li>-->
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if(is_logged_in()){ ?>
                        <li><a href="<?=site_url('user/rides')?>" title="<?=T_("Full list of your rides")?>"><?=T_("My rides")?></a></li>
                        <li><a href="<?=site_url('auth/my_profile')?>" title="<?=T_("Edit your public profile")?>"><?=T_("Hi")?>, <?=substr(auth_username(), 0, strripos(auth_username(), '@'))?></a></li>
                        <li><a href="<?=site_url('auth/logout')?>"><?=T_("Log out")?></a></li>
                    <?php }else{ ?>
                        <li><a href="<?=site_url('auth/login')?>"><?=T_("Log in")?></a></li>
                        <li><a href="<?=site_url('auth/register')?>" title="<?=T_("Create free account")?>"><?=T_("Sign up")?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">

        <?php
        $userLoggedIn = $this->user_model->get_by_id(auth_id());
        if($userLoggedIn['user_name'] == '' && $this->uri->segment(1) != 'auth' && is_logged_in())
            echo "<div class='alert alert-info'><a href='".site_url('auth/my_profile')."'>".T_('Please fill out your profile')."</a></div>";
        ?>
        <?php //if($this->session->flashdata('success')[0] != '') echo '<div class="alert alert-success">'.$this->session->flashdata('success')[0].'</div>'; ?>
        <?php //phpinfo(); ?>

        <?php //print_r($this->session->all_userdata()); echo 'asdf'; ?>