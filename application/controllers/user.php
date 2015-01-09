<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    public function profile($user_id)
    {
        if(!is_numeric($user_id)) return;

        //sendHtmlEmail('k.rudnicki@timecamp.com', 'asdf 22', 'svasdv');
        //echo $this->email->print_debugger();
        //send_email('k.rudnicki@timecamp.com', 'asdf', 'svasdv');

        $data = array();

        $data['user'] = $this->user_model->get_by_id($user_id);
        if($data['user']['birth_date'] != '')
            $data['years_old'] = round( (time()-strtotime($data['user']['birth_date']))/(3600*24*360) ) - 1;

        $data['rides'] = $this->ride_model->get_all();
        foreach($data['rides'] as $i => $row)
        {
            foreach($row['users'] as $user)
            {
                if($user['id'] != auth_id())
                    unset($data['rides'][$i]);
                else if($user['role_id'] == USER_ROLE_HOST)
                    $data['rides'][$i]['is_host'] = true;

            }
        }

        $this->load->view('user_profile', $data);
    }

    public function rides()
    {
        $this->ci_authentication->restrict_access();

        $data = array();

        $data['states'][0] = T_("Choose state");
        $states = $this->state_model->get_all();
        foreach($states as $row)
            $data['states'][$row['state_id']] = $row['state_name'];

        $data['rides'] = $this->ride_model->get_all();

        foreach($data['rides'] as $i => $row)
        {
            $to_delete = true;
            foreach($row['users'] as $user)
            {
                if($user['id'] == auth_id())
                    $to_delete = false;
                if($user['id'] == auth_id() && $user['role_id'] == USER_ROLE_HOST)
                    $data['rides'][$i]['is_host'] = true;
            }

            if($to_delete)
                unset($data['rides'][$i]);
        }

        $this->load->view('user_rides', $data);
    }
}