<?php

class Excel_model extends CI_Model{

    public function __construct()
    {
        parent:: __construct();
    }

    public function insert_batch($data)
    {
        $this->db->insert_batch('personas',$data);
        if ($this->db->affected_rows()>0)
        {
            return 1;
        }else {
            return 0;       
        }
    }
    
    public function list_persons()
    {
        $this->db->select('*');
        $this->db->from('personas');
        $query=$this->db->get();
        return $query->result();
    }
}

?>