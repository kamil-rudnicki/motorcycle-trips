<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ride_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add($ride_data, $motorcycle_types, $users)
    {
        $this->db->insert('rides', $ride_data);
        $ride_id = $this->db->insert_id();

        $this->db->where('state_id', $ride_data['state_id']);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0)
        {
            $rows = $query->result_array();
            foreach($rows as $row)
            {
                $message = "Zachęcamy do wspólnej przejaźdżki! Link: ".site_url('motorcycle_rides/id/'.$ride_id);
                sendHtmlEmail($row['email_address'], "Dodano podróż motocyklową w Twoim województwie", $message);
                sendHtmlEmail("kamil.rudnicki@gmail.com", "Dodano podróż motocyklową w Twoim województwie", $message);
            }
        }

        foreach($motorcycle_types as $type)
        {
            $this->db->insert('ride_motorcycle_type', array('ride_id' => $ride_id, 'motorcycle_type' => $type));
        }

        foreach($users as $user)
        {
            $this->db->insert('ride_user', array('ride_id' => $ride_id, 'role' => $user['role'], 'user_id' => $user['user_id']));
        }

        return $ride_id;
    }

    public function add_apply($user_id, $ride_id)
    {
        $this->db->insert('applies', array('ride_id' => $ride_id, 'user_id' => $user_id));
    }

    public function add_user_to_ride($user_id, $ride_id)
    {
        $this->db->insert('ride_user', array('ride_id' => $ride_id, 'role' => USER_ROLE_GUEST, 'user_id' => $user_id));
    }

    public function del($ride_id)
    {
        $this->db->delete('ride_user', array('ride_id' => $ride_id));
        $this->db->delete('rides', array('ride_id' => $ride_id));
    }

    public function edit($ride_id, $ride_data, $motorcycle_types)
    {
        $this->db->where('ride_id', $ride_id);
        $this->db->update('rides', $ride_data);

        $this->db->delete('ride_motorcycle_type', array('ride_id' => $ride_id));
        foreach($motorcycle_types as $type)
            $this->db->insert('ride_motorcycle_type', array('ride_id' => $ride_id, 'motorcycle_type' => $type));
    }

    public function get_all($filters = array())
    {
        if(isset($filters['from_today']) && $filters['from_today'] == true)
            $this->db->where('departure_date >= ', date('Y-m-d'));

        $this->db->join('places', 'rides.destination_place_id = places.place_id', 'left');
        $this->db->join('cities', 'rides.departure_city_id = cities.city_id', 'left');
        $this->db->join('states', 'rides.departure_state_id = states.state_id', 'left');
        $this->db->order_by('departure_date ASC');
        $query = $this->db->get('rides');
        $rides = $query->result_array();

        //get people
        $this->db->join('users', 'users.id = ride_user.user_id', 'left');
        $this->db->join('motorcycles', 'users.motorcycle_id = motorcycles.motorcycle_id', 'left');
        $this->db->join('cities', 'users.city_id = cities.city_id', 'left');
        $this->db->join('states', 'users.state_id = states.state_id', 'left');
        $this->db->order_by('role ASC');
        $query = $this->db->get('ride_user');
        $result = $query->result_array();
        $users = $result;

        //get motorcycle types
        $query = $this->db->get('ride_motorcycle_type');
        $result = $query->result_array();
        $motorcycle_types = $result;

        foreach($rides as $m => $ride)
        {
            //join people
            foreach($users as $i => $user)
            {
                if($user['ride_id'] == $ride['ride_id'])
                {
                    $rides[$m]['users'][] = $user;
                    unset($users[$i]);
                }
            }

            //join motorcycle types
            foreach($motorcycle_types as $i => $motorcycle_type)
            {
                if($motorcycle_type['ride_id'] == $ride['ride_id'])
                {
                    $rides[$m]['motorcycle_types'][] = $motorcycle_type['motorcycle_type'];
                    unset($motorcycle_types[$i]);
                }
            }
        }

        return $rides;
    }

    public function get_by_id($ride_id)
    {
        $this->db->where('ride_id', $ride_id);
        $this->db->join('places', 'rides.destination_place_id = places.place_id', 'left');
        $this->db->join('cities', 'rides.departure_city_id = cities.city_id', 'left');
        $this->db->join('states', 'rides.departure_state_id = states.state_id', 'left');
        $query = $this->db->get('rides');
        if ($query->num_rows() > 0)
        {
            $ride = $query->row_array();

            //get people
            $this->db->where('ride_id', $ride_id);
            $this->db->join('users', 'users.id = ride_user.user_id', 'left');
            $this->db->join('motorcycles', 'users.motorcycle_id = motorcycles.motorcycle_id', 'left');
            $this->db->join('cities', 'users.city_id = cities.city_id', 'left');
            $this->db->join('states', 'users.state_id = states.state_id', 'left');;
            $query = $this->db->get('ride_user');
            $result = $query->result_array();
            $ride['users'] = $result;

            foreach($ride['users'] as $user)
            {
                if($user['role'] == USER_ROLE_HOST)
                    $ride['host'] = $user;
            }

            //get motorcycle types
            $this->db->where('ride_id', $ride_id);
            $query = $this->db->get('ride_motorcycle_type');
            $result = $query->result_array();
            $ride['motorcycle_types'] = array();
            foreach($result as $row)
            {
                $ride['motorcycle_types'][$row['motorcycle_type']] = $row['motorcycle_type'];
            }

            return $ride;
        }

        return false;
    }

}