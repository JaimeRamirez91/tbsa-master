<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RolesModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getRoles_VW($buscar="")
    {
  
                $q = $this->db->select(" a.idRol, a.nomRol")
                    ->from("roles_table a")
                    ->where("a.nomRol like '%".$buscar."%'");

            return $q->get()->result_array();
 
    }

    public function getAccesos_VW()
    {
  
                $q = $this->db->select(" a.*")
                    ->from("accesos_table a");

            return $q->get()->result_array();
 
    }

    public function eliminarRol($idRol)
    {   
        
        $this->db->where("idRol", $idRol)->delete("roles_table");

        return $this->db->affected_rows() > 0;

    }

    public function eliminarAccesosRol($idRol)
    {   
        
        $this->db->where("idRol", $idRol)->delete("accesos_roles_table");

        return $this->db->affected_rows() > 0;

    }


    
    public function insertRol($arr)
    {
        $this->db->insert("roles_table", $arr);

        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }

    public function insertAccesosRol($idRol, $idAcceso)
    {
        $arr["idRol"] = $idRol;
        $arr["idAcceso"]= $idAcceso;
        $this->db->insert("accesos_roles_table", $arr);

        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }

    public function detalles_VW($idRol)
    {
  
                $q = $this->db->select("a.idAcceso, a.idRol, b.nomAcceso, c.nomRol")
                    ->from("accesos_roles_table a")
                    ->join("accesos_table b","a.idAcceso=b.idAcceso")
                    ->join("roles_table c","a.idRol=c.idRol")
                    ->where("a.idRol", $idRol);

            return $q->get()->result_array();
 
    }

    public function updateRol($arr)
    {
        $this->db->where("idRol", $this->input->post("idRol"));
        $this->db->update("roles_table", $arr);

        $insert_id = $this->db->affected_rows();
        return $insert_id > 0;
    }
}
