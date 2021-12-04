<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PerfilesModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getPerfiles_VW($buscar="")
    {
  
                $q = $this->db->select(" a.idPerfil, a.nomPerfil, if(a.mostrar>0,'SI','NO') as mostrar")
                    ->from("perfiles_table a")
                    ->where("a.nomPerfil like '%".$buscar."%'");

            return $q->get()->result_array();
 
    }

    public function getRoles_VW()
    {
  
                $q = $this->db->select(" a.*")
                    ->from("roles_table a");

            return $q->get()->result_array();
 
    }

    public function eliminarPerfil($idPerfil)
    {   
        
        $this->db->where("idPerfil", $idPerfil)->delete("perfiles_table");

        return $this->db->affected_rows() > 0;

    }

    public function eliminarRolesPerfil($idPerfil)
    {   
        
        $this->db->where("idPerfil", $idPerfil)->delete("perfiles_roles_table");

        return $this->db->affected_rows() > 0;

    }


    
    public function insertPerfil($arr)
    {
        $this->db->insert("perfiles_table", $arr);

        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }

    public function insertRolesPerfil($idPerfil, $idRol)
    {
        $arr["idPerfil"] = $idPerfil;
        $arr["idRol"]= $idRol;
        $this->db->insert("perfiles_roles_table", $arr);

        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }

    public function detalles_VW($idPerfil)
    {
  
                $q = $this->db->select("a.idPerfil, a.idRol, b.nomPerfil, b.mostrar, c.nomRol")
                    ->from("perfiles_roles_table a")
                    ->join("perfiles_table b","a.idPerfil=b.idPerfil")
                    ->join("roles_table c","a.idRol=c.idRol")
                    ->where("a.idPerfil", $idPerfil);

            return $q->get()->result_array();
 
    }

    public function updatePerfil($arr)
    {
        $this->db->where("idPerfil", $this->input->post("idPerfil"));
        $this->db->update("perfiles_table", $arr);

        $insert_id = $this->db->affected_rows();
        return $insert_id > 0;
    }
}
