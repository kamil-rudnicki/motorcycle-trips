<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class State_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add($state_name)
    {
        if($state_name == '') return 0;

        $state_name = clean_text($state_name);

        $this->db->where('state_name', $state_name);
        $query = $this->db->get('states');
        if ($query->num_rows() > 0)
        {
            $row = $query->row_array();
            return $row['state_id'];
        }

        $this->db->set('state_name', $state_name);
        $this->db->insert('states');
        return $this->db->insert_id();
    }

    public function get_by_id($state_id)
    {
        $this->db->where('state_id', $state_id);
        $query = $this->db->get('states');
        if ($query->num_rows() > 0)
        {
            $row = $query->row_array();
            return $row;
        }

        return false;
    }

    public function get_all()
    {
        $query = $this->db->get('states');
        return $query->result_array();
    }
}