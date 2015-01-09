<?php include('_header.php'); ?>

    <h2><?=$ride['city_name']?> - <?=$ride['place_name']?>: <?=$host['user_name']?> <?=T_("is offering a ride")?></h2>

    <?php

    $attend_link = '';
    if(!is_logged_in())
        $attend_link = site_url('auth/login');
    else
        $attend_link = site_url('motorcycle_rides/apply/'.$ride['ride_id']);

    ?>

    <div class="row">

        <div class="col-sm-8">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <?=$ride['city_name']?> - <?=$ride['place_name']?>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tr><td><?=T_("Departure point")?></td><td><?=$ride['city_name']?> / <?=$ride['state_name']?></td></tr>
                        <tr><td><?=T_("Destination place")?></td><td><?=$ride['place_name']?></td></tr>
                        <tr><td><?=T_("Distance both ways (~ km)")?></td><td><?=$ride['distance_km']?> km</td></tr>
                        <tr><td><?=T_("Departure date")?></td><td><?=$ride['departure_date']?></td></tr>
                        <tr><td><?=T_("I can make a detour")?></td><td><?=get_detour_text($ride['detour_days'])?></td></tr>
                        <tr><td><?=T_("Ride duration in days")?></td><td><?=$ride['duration_days']?> <?=T_("days")?></td></tr>
                        <tr><td><?=T_("Preferred motorcycle types")?></td><td><?=$motorcycle_types_text?></td></tr>
                        <tr><td><?=T_("Description")?></td><td><?=nl2br($ride['description'])?></td></tr>
                    </table>
                    <div class="pull-right text-muted"><?=T_("Offer published")?>: <?=$ride['publish_time']?></div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <?=T_("Who is going?")?>
                </div>
                <div class="panel-body">
                    <ol>
                        <?php
                            for($i = 0; $i < $ride['maximum_motorcycles']; $i++)
                            {
                                if(isset($ride['users'][$i]))
                                {
                                    $name = $ride['users'][$i]['user_name'];
                                    $motorcycle = $ride['users'][$i]['motorcycle_name'];
                                    $url = site_url('user/profile/'.$ride['users'][$i]['user_id']);
                                    $age = age($ride['users'][$i]['birth_date']);
                                    echo "<li><a href='$url' class='text-muted'>$name, $motorcycle, $age</a></li>";
                                }
                                else
                                {
                                    echo "<li><a href='$attend_link'>"._("Book this seat")."</a></li>";
                                }
                            }
                        ?>
                    </ol>
                </div>
            </div>

        </div>

        <div class="col-sm-4">

            <div class="text-muted"><?=T_("Click to book your seat")?></div>
            <a class="btn btn-success btn-block" href="<?=$attend_link?>"><?=T_("Contact host")?></a>
            <br /><br />

            <div class="panel panel-default">
                <div class="panel-heading">
                    <?=T_("Host")?>
                </div>
                <div class="panel-body">
                    <h4><?=$host['user_name']?> <small><?=$years_old?></small></h4>
                    <h4><?=$host['motorcycle_name']?></h4>

                    <div class="well">
                        <?=nl2br($host['user_description'])?>
                    </div>

                    <ul>
                        <li><?=T_("Last online")?>: <?=$host['login_time']?></li>
                        <li><?=T_("Member since")?>: <?=$host['register_time']?></li>
                    </ul>

                    <a href="<?=site_url('user/profile/'.$host['id'])?>" class="btn btn-link"><?=T_("See my public profile")?></a>
                </div>
            </div>


        </div>

    </div>

<?php include('_footer.php'); ?>