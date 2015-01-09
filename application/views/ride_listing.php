<?php include('_header.php'); ?>

<div class="row">
    <div class="col-sm-2" title="<?=T_("Filters are not implemented yet, but will be very soon")?>" style="opacity: 0.2;">

        <img src="<?=site_url()?>/res/pic.png" style="width: 100%;" />

        <!--<h5>Departure date</h5>
        <input type="date" class="form-control">
        <input type="date" class="form-control">-->

        <br /><h5><?=T_("Departure city")?></h5>
        <input type="text" class="form-control" value="<?php echo set_value('departure_city', $ride['city_name']); ?>" name="departure_city">

        <!--<br /><h5><?=T_("Departure state")?></h5>-->
        <?php
        echo form_dropdown('departure_state_id', $states, $ride['departure_state_id'], 'class="form-control" style="margin-top: 5px;" ');
        ?>

        <br /><h5><?=T_("Duration")?></h5>
        <div class="checkbox"><label><input type="checkbox"> <?=T_("One day")?></label></div>
        <div class="checkbox"><label><input type="checkbox"> <?=T_("Two days")?></label></div>
        <div class="checkbox"><label><input type="checkbox"> <?=T_("3+ days")?></label></div>

        <br /><h5><?=T_("Preferred motorcycle types")?></h5>
        <div class="checkbox"><label><input type="checkbox"> <?=get_motorcycle_type_name(MOTORCYCLE_TYPE_STREET)?></label></div>
        <div class="checkbox"><label><input type="checkbox"> <?=get_motorcycle_type_name(MOTORCYCLE_TYPE_ENDURO)?></label></div>
        <div class="checkbox"><label><input type="checkbox"> <?=get_motorcycle_type_name(MOTORCYCLE_TYPE_CHOPPER)?></label></div>
        <div class="checkbox"><label><input type="checkbox"> <?=get_motorcycle_type_name(MOTORCYCLE_TYPE_MOTOCROSS)?></label></div>
        <div class="checkbox"><label><input type="checkbox"> <?=get_motorcycle_type_name(MOTORCYCLE_TYPE_SCOOTER)?></label></div>


    </div>
    <div class="col-sm-9 col-sm-offset-1">

        <a href="<?php echo (is_logged_in() ? site_url('motorcycle_rides/add') : site_url('auth/register')) ?>" class="btn btn-success pull-right"><i class="glyphicon glyphicon-map-marker"></i> <?=T_("Add Ride")?></a>
        <div class="clearfix"></div>

        <?php
        foreach($rides as $ride)
        {
        ?>

            <div class="trip">
                <div class="trip-name" title="<?=T_("Click to see the details")?>"><a href="<?=site_url('motorcycle_rides/id/'.$ride['ride_id'])?>"><?=translateDate(translateFullMonths(date("F j, Y, D", strtotime($ride['departure_date']))))?> <small style="text-transform: lowercase">(+/- <?=get_detour_text($ride['detour_days'])?>)</small>, <?=$ride['duration_days']?> <?=T_("days long trip")?></a></div>
                <div class="trip-max-people"><?=$ride['maximum_motorcycles']-count($ride['users'])?><span>/<?=$ride['maximum_motorcycles']?></span> <?=T_("free seats")?></div>
                <div class="trip-destination" title="<?=T_("Departure & destination place")?>"><i class="glyphicon glyphicon-map-marker"></i> <?=$ride['city_name']?> (<?=$ride['state_name']?>) <i class="glyphicon glyphicon-arrow-right"></i> <i class="glyphicon glyphicon-map-marker"></i> <?=$ride['place_name']?> <b>~ <?=$ride['distance_km']?> km</b></div>
                <div class="trip-rider" title="<?=T_("Host rides on")?>"><?=$ride['users'][0]['motorcycle_name']?>, <?=$ride['users'][0]['user_name']?></div>
                <div class="clearfix"></div>
            </div>

        <?php
        }
        ?>

        <!--<ul class="pagination">
            <li class="active"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">Next</a></li>
        </ul>-->
        <br /><br />

    </div>
</div>

<?php include('_footer.php'); ?>