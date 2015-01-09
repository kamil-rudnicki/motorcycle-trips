<?php include('_header.php'); ?>

    <form role="form" method="post" action="">

        <div class="row">
            <div class="col-sm-5 col-sm-offset-3">

                <h2>
                    <?=T_("Offer a ride for free")?>
                </h2>

                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=T_("Route")?></h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1"><?=T_("Destination place")?></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                <input type="text" class="form-control" name="destination_place" value="<?php echo set_value('destination_place', $ride['place_name']); ?>" placeholder="(<?=T_("city, country, place")?>)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"><?=T_("Distance both ways (~ km)")?></label>
                            <input type="text" class="form-control" value="<?php echo set_value('distance_km', $ride['distance_km']); ?>" name="distance_km" placeholder="200">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"><?=T_("Departure point")?></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                <input type="text" class="form-control" value="<?php echo set_value('departure_city', $ride['city_name']); ?>" name="departure_city" placeholder="<?=T_("City")?>">
                            </div>
                            <?php
                            echo form_dropdown('departure_state_id', $states, $ride['departure_state_id'], 'class="form-control" style="margin-top: 5px;" ');
                            ?>
                        </div>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=T_("Dates")?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?=T_("Departure date")?></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input type="date" value="<?php echo set_value('departure_date', $ride['departure_date']); ?>" class="form-control" name="departure_date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?=T_("I can make a detour")?></label>
                            <select class="form-control" name="detour_days">
                                <option value="0" <?php if($this->input->post('detour_days') == 0 || (isset($ride['detour_days']) && $ride['detour_days'] == 0)) echo "selected"; ?>><?=get_detour_text(0)?></option>
                                <option value="1" <?php if($this->input->post('detour_days') == 1 || (isset($ride['detour_days']) && $ride['detour_days'] == 1)) echo "selected"; ?>><?=get_detour_text(1)?></option>
                                <option value="2" <?php if($this->input->post('detour_days') == 2 || (isset($ride['detour_days']) && $ride['detour_days'] == 2)) echo "selected"; ?>><?=get_detour_text(2)?></option>
                                <option value="3" <?php if($this->input->post('detour_days') == 3 || (isset($ride['detour_days']) && $ride['detour_days'] == 3)) echo "selected"; ?>><?=get_detour_text(3)?></option>
                                <option value="6" <?php if($this->input->post('detour_days') == 6 || (isset($ride['detour_days']) && $ride['detour_days'] == 6)) echo "selected"; ?>><?=get_detour_text(6)?></option>
                                <option value="14" <?php if($this->input->post('detour_days') == 14 || (isset($ride['detour_days']) && $ride['detour_days'] == 14)) echo "selected"; ?>><?=get_detour_text(14)?></option>
                                <option value="100" <?php if($this->input->post('detour_days') == 100 || (isset($ride['detour_days']) && $ride['detour_days'] == 100)) echo "selected"; ?>><?=get_detour_text(100)?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?=T_("Ride duration in days (one day can be also half day)")?></label>
                            <input type="number" class="form-control" value="<?php echo set_value('duration_days', $ride['duration_days']); ?>" name="duration_days" value="1" min="1" max="30">
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=T_("Parameters")?></h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1"><?=T_("Preferred motorcycle types")?></label>
                            <div class="checkbox"><label><input type="checkbox" value="1" <?php if($this->input->post('motorcycle_type_street') == 1 || isset($ride['motorcycle_types'][MOTORCYCLE_TYPE_STREET]) ) echo "checked='checked'"; ?> name="motorcycle_type_street" /> <?=get_motorcycle_type_name(MOTORCYCLE_TYPE_STREET)?></label></div>
                            <div class="checkbox"><label><input type="checkbox" value="1" <?php if($this->input->post('motorcycle_type_enduro') == 1 || isset($ride['motorcycle_types'][MOTORCYCLE_TYPE_ENDURO])) echo "checked='checked'"; ?> name="motorcycle_type_enduro" /> <?=get_motorcycle_type_name(MOTORCYCLE_TYPE_ENDURO)?></label></div>
                            <div class="checkbox"><label><input type="checkbox" value="1" <?php if($this->input->post('motorcycle_type_chopper') == 1 || isset($ride['motorcycle_types'][MOTORCYCLE_TYPE_CHOPPER])) echo "checked='checked'"; ?> name="motorcycle_type_chopper" /> <?=get_motorcycle_type_name(MOTORCYCLE_TYPE_CHOPPER)?></label></div>
                            <div class="checkbox"><label><input type="checkbox" value="1" <?php if($this->input->post('motorcycle_type_motocross') == 1 || isset($ride['motorcycle_types'][MOTORCYCLE_TYPE_MOTOCROSS])) echo "checked='checked'"; ?> name="motorcycle_type_motocross" /> <?=get_motorcycle_type_name(MOTORCYCLE_TYPE_MOTOCROSS)?></label></div>
                            <div class="checkbox"><label><input type="checkbox" value="1" <?php if($this->input->post('motorcycle_type_scooter') == 1 || isset($ride['motorcycle_types'][MOTORCYCLE_TYPE_SCOOTER])) echo "checked='checked'"; ?> name="motorcycle_type_scooter" /> <?=get_motorcycle_type_name(MOTORCYCLE_TYPE_SCOOTER)?></label></div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"><?=T_("Maximum number of motorcycles (including you)")?></label>
                            <input type="number" class="form-control" value="<?php echo set_value('maximum_motorcycles', $ride['maximum_motorcycles']); ?>" name="maximum_motorcycles" min="2" max="10">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"><?=T_("Sleep")?></label>
                            <select class="form-control" name="sleep">
                                <option value="0" <?php if($this->input->post('sleep') == 0 || (isset($ride['sleep']) && $ride['sleep'] == 0)) echo "selected"; ?>><?=T_("Do not matter")?></option>
                                <option value="1" <?php if($this->input->post('sleep') == 1 || (isset($ride['sleep']) && $ride['sleep'] == 1)) echo "selected"; ?>><?=T_("Hotel")?></option>
                                <option value="2" <?php if($this->input->post('sleep') == 2 || (isset($ride['sleep']) && $ride['sleep'] == 2)) echo "selected"; ?>><?=T_("Tent")?></option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=T_("Description")?></h3>
                    </div>
                    <div class="panel-body">
                        <textarea class="form-control" name="description" placeholder="<?=T_("Provide extra information about your trip. More details about the meeting point, why you are travelling or anything else other riders should know.")?>" rows="7"><?php echo set_value('description', $ride['description']); ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <input type="checkbox" checked />
                    <?=T_("I hereby certify that I hold a driving licence and valid motorcycle insurance")?>
                </div>

                <button type="submit" class="btn btn-success"><?=T_("Publish offer")?></button>

            </div>
        </div>




    </form>


<?php include('_footer.php'); ?>