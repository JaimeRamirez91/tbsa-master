<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RegistroModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    
    public function insertUsuario($arr)
    {
        $this->db->insert("usuarios_table", $arr);

        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }

    public function getDepartamentos(){
        $q = $this->db->select("a.idDepartamento, a.nomDepartamento")
            ->from("departamentos_table a");

            return $q->get()->result_array();
    }   



    public function getMunicipios($idDepartamento){
        $q = $this->db->select("a.idMunicipio, a.nomMunicipio, a.idDepartamento")
            ->from("municipios_table a")
            ->where("a.idDepartamento = $idDepartamento");

            return $q->get()->result_array();
    }




    public function getPerfiles(){
        $q = $this->db->select("a.idPerfil, a.nomPerfil")
            ->from("perfiles_table a")
            ->where("a.mostrar ='1'");

            return $q->get()->result_array();
    }   
}
