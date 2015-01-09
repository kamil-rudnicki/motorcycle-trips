<?php include('_header.php'); ?>

    <h1><?=T_("My rides")?></h1>

    <div class="row">
        <div class="col-sm-10">

            <a href="<?php echo (is_logged_in() ? site_url('motorcycle_rides/add') : site_url('auth/register')) ?>" class="btn btn-success"><i class="glyphicon glyphicon-map-marker"></i> <?=T_("Add Ride")?></a>

            <br /><br />

            <?php
            foreach($rides as $ride)
            {
                ?>
                <div class="trip">
                    <div class="trip-name"><a href="<?=site_url('motorcycle_rides/id/'.$ride['ride_id'])?>"><?=$ride['departure_date']?> (+/- <?=get_detour_text($ride['detour_days'])?>), <?=$ride['duration_days']?> <?=T_("days long trip")?></a></div>
                    <div class="trip-max-people"><?=count($ride['users'])?><span>/<?=$ride['maximum_motorcycles']?></span> <?=T_("free seats")?></div>
                    <div class="trip-destination"><i class="glyphicon glyphicon-map-marker"></i> <?=$ride['city_name']?> (<?=$ride['state_name']?>) <i class="glyphicon glyphicon-arrow-right"></i> <i class="glyphicon glyphicon-map-marker"></i> <?=$ride['place_name']?> <b>~ <?=$ride['distance_km']?> km</b></div>
                    <div class="trip-rider"><?=$ride['users'][0]['motorcycle_name']?>, <?=$ride['users'][0]['user_name']?></div>
                    <div>
                        <?php if($ride['is_host'] === true){?>
                            <a class="btn btn-sm btn-default" href="<?=site_url('motorcycle_rides/edit/'.$ride['ride_id'])?>"><?=T_("Edit")?></a>
                            <a class="btn btn-sm btn-link" onclick="if (!confirm('Are you sure?')) return false;" href="<?=site_url('motorcycle_rides/del/'.$ride['ride_id'])?>"><?=T_("Delete")?></a>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php
            }
            ?>

            <br /><br />

        </div>
    </div>

<?php include('_footer.php'); ?>