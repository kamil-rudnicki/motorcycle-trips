<?php include('_header.php'); ?>

    <div class="row">
        <div class="col-sm-4">

            <div class="panel panel-default">
                <div class="panel-body">
                    <h4><?=T_("Member activity")?></h4>
                    <ul>
                        <li><?=T_("Last online")?>: <?=$user['login_time']?></li>
                        <li><?=T_("Member since")?>: <?=$user['register_time']?></li>
                    </ul>

                    <h4><?=T_("Rides")?></h4>
                    <ul>
                        <?php foreach($rides as $ride){ ?>
                        <li><a href="<?=site_url('motorcycle_rides/id/'.$ride['ride_id'])?>"><?=$ride['departure_date']?> <?=$ride['city_name']?> (<?=$ride['state_name']?>)</a></li>
                        <?php }?>
                    </ul>
                </div>
            </div>


        </div>
        <div class="col-sm-8">

            <h2><?=$user['user_name']?> <small><?=$years_old?> <?=T_("years old")?></small></h2>
            <h4><?=$user['motorcycle_name']?></h4>
            <h4><?=$user['city_name']?>, <?=$user['state_name']?></h4>

            <div class="well">
                <?=nl2br($user['user_description'])?>
            </div>
        </div>
    </div>

<?php include('_footer.php'); ?>