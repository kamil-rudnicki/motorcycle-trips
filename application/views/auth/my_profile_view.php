<?php include($this->config->item('views_path').'_header.php'); ?>

    <h1>
        <?=T_("My profile")?>
        <a href="<?=site_url('user/profile/'.auth_id())?>" class="btn btn-link"><?=T_("View public profile")?></a>
    </h1>
    <hr />

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <form role="form" method="post" action="">
        <div class="form-group">
            <label for="exampleInputEmail1"><?=T_("Email")?></label>
            <h4><?=auth_username()?></h4>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"><?=T_("Username")?></label>
            <input type="text" class="form-control" name="user_name" value="<?php echo set_value('user_name', $item_query['user_name']); ?>" placeholder="<?=T_("Like Kamil R.")?>">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"><?=T_("Motorcycle")?></label>
            <input type="text" class="form-control" name="motorcycle_name" value="<?php echo set_value('motorcycle_name', $item_query['motorcycle_name']); ?>" placeholder="<?=T_("Like Yamaha XT 600")?>">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"><?=T_("City")?></label>
            <input type="text" class="form-control" name="city_name" value="<?php echo set_value('city_name', $item_query['city_name']); ?>" placeholder="<?=T_("Like New York")?>">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"><?=T_("State")?></label>
            <?php
            echo form_dropdown('state_name', $states, $item_query['state_id'], 'class="form-control"');
            ?>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"><?=T_("Birth date")?></label>
            <input type="text" class="form-control" name="birth_date" value="<?php echo set_value('birth_date', $item_query['birth_date']); ?>" placeholder="1988-03-08">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"><?=T_("Phone")?></label>
            <input type="text" class="form-control" name="phone" value="<?php echo set_value('phone', $item_query['phone']); ?>" placeholder="">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"><?=T_("Description")?></label>
            <textarea class="form-control" name="user_description" rows="3"><?php echo set_value('user_description', $item_query['user_description']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-default"><?=T_("Save")?></button>
    </form>

<?php include($this->config->item('views_path').'_footer.php');