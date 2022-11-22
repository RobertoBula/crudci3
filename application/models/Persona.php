<?php

use LDAP\Result;

class Persona extends CI_Model {
    public function agregar($persona){
        $this->db->insert('personas', $persona);
    }

    public function select_all(){
        $this->db->select('*');
        $this->db->from('personas');
        return $this->db->get()->result();
    }

    public function eliminar($id_persona){
        $this->db->where('id', $id_persona);
        $this->db->delete('personas');
        
    }

    public function actualizar($persona, $id_persona){
        $this->db->where('id', $id_persona);
        $this->db->update('personas', $persona);
    }
}

?>