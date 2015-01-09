<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('USER_ROLE_HOST', 0);
define('USER_ROLE_GUEST', 1);

define('MOTORCYCLE_TYPE_STREET', 1);
define('MOTORCYCLE_TYPE_ENDURO', 2);
define('MOTORCYCLE_TYPE_CHOPPER', 3);
define('MOTORCYCLE_TYPE_MOTOCROSS', 4);
define('MOTORCYCLE_TYPE_SCOOTER', 5);

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function increase_login_number($user_id)
    {
        $this->db->set('login_count', 'login_count + 1', false);
        $this->db->where('id', $user_id);
        $this->db->update('users');
    }

    public function update($user_id, $data)
    {
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
    }

    public function get_by_id($user_id)
    {
        $this->db->where('id', $user_id);
        $this->db->join('motorcycles', 'users.motorcycle_id = motorcycles.motorcycle_id', 'left');
        $this->db->join('cities', 'users.city_id = cities.city_id', 'left');
        $this->db->join('states', 'users.state_id = states.state_id', 'left');
        $query = $this->db->get('users');
        if ($query->num_rows() > 0)
        {
            $row = $query->row_array();
            return $row;
        }

        return false;
    }

}