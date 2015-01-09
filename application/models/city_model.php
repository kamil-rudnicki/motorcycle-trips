<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add($city_name)
    {
        if($city_name == '') return 0;

        $city_name = clean_text($city_name);

        $this->db->where('city_name', $city_name);
        $query = $this->db->get('cities');
        if ($query->num_rows() > 0)
        {
            $row = $query->row_array();
            return $row['city_id'];
        }

        $this->db->set('city_name', $city_name);
        $this->db->insert('cities');
        return $this->db->insert_id();
    }

    public function get_by_id($city_id)
    {
        $this->db->where('city_id', $city_id);
        $query = $this->db->get('cities');
        if ($query->num_rows() > 0)
        {
            $row = $query->row_array();
            return $row;
        }

        return false;
    }
}