<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Place_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add($place_name)
    {
        if($place_name == '') return 0;

        $place_name = clean_text($place_name);

        $this->db->where('place_name', $place_name);
        $query = $this->db->get('places');
        if ($query->num_rows() > 0)
        {
            $row = $query->row_array();
            return $row['place_id'];
        }

        $this->db->set('place_name', $place_name);
        $this->db->insert('places');
        return $this->db->insert_id();
    }

    public function get_by_id($place_id)
    {
        $this->db->where('place_id', $place_id);
        $query = $this->db->get('places');
        if ($query->num_rows() > 0)
        {
            $row = $query->row_array();
            return $row;
        }

        return false;
    }

}