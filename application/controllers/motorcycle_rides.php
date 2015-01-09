<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Motorcycle_rides extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function id($ride_id)
    {
        $data['ride'] = $this->ride_model->get_by_id($ride_id);

        $data['states'][0] = T_("None");
        $states = $this->state_model->get_all();
        foreach($states as $row)
            $data['states'][$row['state_id']] = $row['state_name'];

        $data['host'] = array();
        foreach($data['ride']['users'] as $user)
            if($user['role'] == USER_ROLE_HOST)
                $data['host'] = $user;
        $data['years_old'] = age($data['host']['birth_date']);

        $data['motorcycle_types_text'] = '';
        foreach($data['ride']['motorcycle_types'] as $type_id)
        {
            $data['motorcycle_types_text'] .= get_motorcycle_type_name($type_id).'<br />';
        }

        $this->load->view('ride_details', $data);
    }

    public function add()
    {
        $this->ci_authentication->restrict_access();

        $this->form_validation->set_rules('departure_state_id', 'State', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('destination_place', 'Destination place', 'trim|required');
        $this->form_validation->set_rules('distance_km', 'Distance', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('departure_city', 'Departure city', 'trim|required');
        $this->form_validation->set_rules('departure_date', 'Departure date', 'trim|required');
        $this->form_validation->set_rules('duration_days', 'Duration in days', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('maximum_motorcycles', 'Maximum number of motorcycles', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('sleep', 'Sleep', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() == FALSE)
        {
            $data['states'][0] = T_("Choose state");
            $states = $this->state_model->get_all();
            foreach($states as $row)
                $data['states'][$row['state_id']] = $row['state_name'];

            $this->load->view('ride_edit', $data);
        }
        else
        {
            $post = $this->input->post();

            $ride['distance_km'] = $post['distance_km'];
            $ride['departure_city_id'] = $this->city_model->add($post['departure_city']);
            $ride['departure_date'] = date('Y-m-d', strtotime($post['departure_date']));
            $ride['duration_days'] = $post['duration_days'];
            $ride['maximum_motorcycles'] = $post['maximum_motorcycles'];
            $ride['sleep'] = $post['sleep'];
            $ride['description'] = $post['description'];
            $ride['destination_place_id'] = $this->place_model->add($post['destination_place']);
            $ride['departure_state_id'] = $post['departure_state_id'];
            $ride['detour_days'] = $post['detour_days'];

            $motorcycle_types = array();
            if($post['motorcycle_type_street'] == 1) $motorcycle_types[] = MOTORCYCLE_TYPE_STREET;
            if($post['motorcycle_type_enduro'] == 1) $motorcycle_types[] = MOTORCYCLE_TYPE_ENDURO;
            if($post['motorcycle_type_chopper'] == 1) $motorcycle_types[] = MOTORCYCLE_TYPE_CHOPPER;
            if($post['motorcycle_type_motocross'] == 1) $motorcycle_types[] = MOTORCYCLE_TYPE_MOTOCROSS;
            if($post['motorcycle_type_scooter'] == 1) $motorcycle_types[] = MOTORCYCLE_TYPE_SCOOTER;

            $this->ride_model->add($ride, $motorcycle_types, array(array('user_id' => auth_id(), 'role' => USER_ROLE_HOST)));

            $this->ci_alerts->set('success', 'Offer published successfully. Someone will soon join your trip (I hope)!');
            redirect('user/rides');
        }
    }

    public function apply($ride_id)
    {
        $ride = $this->ride_model->get_by_id($ride_id);
        $current_user = $this->user_model->get_by_id(auth_id());

        //send emails
        $message = 'Zgłosiłeś się do uczestnictwa w <a href="%s">przejażdżce motocyklowej</a>.<br /><br />
            Skontaktuj się z gospodarzem przejażdżki poprzez:<br /><br />
            email: %s<br />
            telefon: %s<br /><br />
            <a href="%s">Profil użytkownika</a>';
        sendHtmlEmail(auth_username(), T_('You have applied for a ride'), sprintf($message, site_url('motorcycle_rides/id/'.$ride_id),
            $ride['host']['email_address'], $ride['host']['phone'], site_url('user/profile/'.$ride['host']['id'])));

        $this->ride_model->add_apply(auth_id(), (int)$ride_id);

        redirect('motorcycle_rides/apply2/'.$ride_id);
    }
    public function apply2($ride_id)
    {
        $ride = $this->ride_model->get_by_id($ride_id);
        $current_user = $this->user_model->get_by_id(auth_id());

        $message = 'Użytkownik %s zgłasza chęć uczestnictwa w Twojej <a href="%s">przejażdżce motocyklowej</a>!<br /><br />
            Aby zaakceptować zgłoszenie porozmawiaj z użytkownikiem, a następnie kliknij:<br /><br />
            <a href="%s">Zatwierdź użytkownia</a><br /><br />
            <a href="%s">Wyświetl pełny profil użytkownika</a><br /><br />
            Dane kontaktowe:<br />
            Tel: %s<br />
            Email: %s<br />';
        $message = sprintf($message,
            $current_user['user_name'], site_url('motorcycle_rides/id/'.$ride_id),
            site_url('motorcycle_rides/accept_participant/'.$ride_id.'/'.$current_user['id'].'/'.md5('as33'.$ride_id)), site_url('user/profile/'.$current_user['id']),
            $current_user['phone'], $current_user['email_address']);

        sendHtmlEmail($ride['host']['email_address'], T_('Someone applied for your ride'), $message);

        //show communicat
        $this->ci_alerts->set('success', T_('You have successfully apply for a ride. Host and you received an email with contact details. Please check your email and contact host by phone or email.'));
        redirect('');
    }

    public function accept_participant($ride_id, $user_id, $pass)
    {
        //accept user
        if($pass == md5('as33'.$ride_id))
        {
            $this->ride_model->add_user_to_ride($user_id, $ride_id);

            $user = $this->user_model->get_by_id($user_id);
            sendHtmlEmail($user['email_address'], T_("You have been accepted to join a ride"), sprintf(T_("Someone just has accepted you to joing a <a href='%s'>ride</a>"), site_url('motorcycle_rides/id/'.$ride_id)));
        }

        //show communicat
        $this->ci_alerts->set('success', T_('You have successfully accepted new participant!'));
        redirect('motorcycle_rides/id/'.$ride_id);
    }

    public function del($ride_id)
    {
        $this->ci_authentication->restrict_access();

        //check user rigths to edit
        $can_edit = false;
        $data['rides'] = $this->ride_model->get_all();
        foreach($data['rides'] as $i => $row)
        {
            foreach($row['users'] as $user)
            {
                if($user['role_id'] == USER_ROLE_HOST)
                    $can_edit = true;

            }
        }
        if($can_edit == false)
        {
            echo 'You don not have rights to edit this';
            exit();
        }

        $this->ride_model->del($ride_id);

        $this->ci_alerts->set('success', T_('You have successfully deleted ride.'));
        redirect('user/rides');
    }

    public function edit($ride_id)
    {
        $this->ci_authentication->restrict_access();

        //check user rigths to edit
        $can_edit = false;
        $data['rides'] = $this->ride_model->get_all();
        foreach($data['rides'] as $i => $row)
        {
            foreach($row['users'] as $user)
            {
                if($user['role_id'] == USER_ROLE_HOST)
                    $can_edit = true;

            }
        }
        if($can_edit == false)
        {
            echo 'You don not have rights to edit this';
            exit();
        }

        $this->form_validation->set_rules('departure_state_id', 'State', 'required');
        $this->form_validation->set_rules('destination_place', 'Destination place', 'trim|required');
        $this->form_validation->set_rules('distance_km', 'Distance', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('departure_city', 'Departure city', 'trim|required');
        $this->form_validation->set_rules('departure_date', 'Departure date', 'trim|required');
        $this->form_validation->set_rules('duration_days', 'Duration in days', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('maximum_motorcycles', 'Maximum number of motorcycles', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('sleep', 'Sleep', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() == FALSE)
        {
            $data['ride'] = $this->ride_model->get_by_id($ride_id);

            $data['states'][0] = T_("Choose state");
            $states = $this->state_model->get_all();
            foreach($states as $row)
                $data['states'][$row['state_id']] = $row['state_name'];

            $this->load->view('ride_edit', $data);
        }
        else
        {
            $post = $this->input->post();

            $ride['distance_km'] = $post['distance_km'];
            $ride['departure_city_id'] = $this->city_model->add($post['departure_city']);
            $ride['departure_date'] = date('Y-m-d', strtotime($post['departure_date']));
            $ride['duration_days'] = $post['duration_days'];
            $ride['maximum_motorcycles'] = $post['maximum_motorcycles'];
            $ride['sleep'] = $post['sleep'];
            $ride['description'] = $post['description'];
            $ride['destination_place_id'] = $this->place_model->add($post['destination_place']);
            $ride['departure_state_id'] = $post['departure_state_id'];
            $ride['detour_days'] = $post['detour_days'];

            $motorcycle_types = array();
            if($post['motorcycle_type_street'] == 1) $motorcycle_types[] = MOTORCYCLE_TYPE_STREET;
            if($post['motorcycle_type_enduro'] == 1) $motorcycle_types[] = MOTORCYCLE_TYPE_ENDURO;
            if($post['motorcycle_type_chopper'] == 1) $motorcycle_types[] = MOTORCYCLE_TYPE_CHOPPER;
            if($post['motorcycle_type_motocross'] == 1) $motorcycle_types[] = MOTORCYCLE_TYPE_MOTOCROSS;
            if($post['motorcycle_type_scooter'] == 1) $motorcycle_types[] = MOTORCYCLE_TYPE_SCOOTER;

            $this->ride_model->edit($ride_id, $ride, $motorcycle_types);

            $this->ci_alerts->set('success', 'Updated successfully!');
            redirect('motorcycle_rides/edit/'.$ride_id);
        }
    }
}