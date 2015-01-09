<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Motorcycle_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add($motorcycle_name)
    {
        if($motorcycle_name == '') return 0;

        $motorcycle_name = clean_text($motorcycle_name);

        $this->db->where('motorcycle_name', $motorcycle_name);
        $query = $this->db->get('motorcycles');
        if ($query->num_rows() > 0)
        {
            $row = $query->row_array();
            return $row['motorcycle_id'];
        }

        $this->db->set('motorcycle_name', $motorcycle_name);
        $this->db->insert('motorcycles');
        return $this->db->insert_id();
    }

    public function get_by_id($motorcycle_id)
    {
        $this->db->where('motorcycle_id', $motorcycle_id);
        $query = $this->db->get('motorcycles');
        if ($query->num_rows() > 0)
        {
            $row = $query->row_array();
            return $row;
        }

        return false;
    }
}