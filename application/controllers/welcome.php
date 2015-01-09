<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
        $data['states'][0] = T_("Choose state");
        $states = $this->state_model->get_all();
        foreach($states as $row)
            $data['states'][$row['state_id']] = $row['state_name'];

        $data['rides'] = $this->ride_model->get_all(array('from_today' => true));

        $this->load->view('ride_listing', $data);
	}
	
	public function test()
	{
		$message = "Zachęcamy do wspólnej przejaźdżki! Link: ".site_url('motorcycle_rides/id/'.$ride_id);
                
                sendHtmlEmail("kamil.rudnicki@gmail.com", "Dodano podróż motocyklową w Twoim województwie", $message);
	}
}