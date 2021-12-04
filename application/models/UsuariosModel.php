<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UsuariosModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getUsuarios_VW($buscar="")
    {
  
                $q = $this->db->select(" a.idUsuario, a.nombre, a.correo, a.telefono, a.dui, a.nit, a.direccion, 
                                        a.referencia, a.estado, a.mercaderia, a.idPerfil, a.idMunicipio, b.nomPerfil, c.nomMunicipio, d.nomDepartamento ")
                    ->from("usuarios_table a")
                    ->join("perfiles_table b","a.idPerfil=b.idPerfil")
                    ->join("municipios_table c","a.idMunicipio=c.idMunicipio")
                    ->join("departamentos_table d","c.idDepartamento=d.idDepartamento")
                    ->where("a.nombre like '%".$buscar."%'"."OR a.Correo like '%".$buscar."%'"."OR b.nomPerfil like '%".$buscar."%'"."OR a.estado like '%".$buscar."%'");

            return $q->get()->result_array();
 
    }

    public function getSingle_VW($idUsuario)
    {
  
                $q = $this->db->select(" a.idUsuario, a.nombre, a.correo, a.telefono, a.dui, a.nit, a.direccion, 
                                        a.referencia, a.estado, a.mercaderia, a.idPerfil, a.idMunicipio, b.nomPerfil, c.nomMunicipio, d.nomDepartamento ")
                    ->from("usuarios_table a")
                    ->join("perfiles_table b","a.idPerfil=b.idPerfil")
                    ->join("municipios_table c","a.idMunicipio=c.idMunicipio")
                    ->join("departamentos_table d","c.idDepartamento=d.idDepartamento")
                    ->where("idUsuario", $idUsuario);

            return $q->get()->result_array();
 
    }


    public function eliminarUsuario($idUsuario)
    {   
        $this->db->where("idUsuario", $idUsuario)->delete("usuarios_table");

        return $this->db->affected_rows() > 0;

    }

    
    public function insertUsuario($arr)
    {
        $this->db->insert("usuarios_table", $arr);

        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }

    public function updateUsuario($arr)
    {
        $this->db->where("idUsuario", $this->input->post("idUsuario"));
        $this->db->update("usuarios_table", $arr);

        $insert_id = $this->db->affected_rows();
        return $insert_id > 0;
    }

    public function getDepartamentos(){
        $q = $this->db->select("a.idDepartamento, a.nomDepartamento")
            ->from("departamentos_table a");

            return $q->get()->result_array();
    }   

    public function municipioSelec($idMunicipio){
        $q = $this->db->select("a.idDepartamento, b.nomDepartamento, a.nomMunicipio, a.idMunicipio")
            ->from("municipios_table a")
            ->join("departamentos_table b","a.idDepartamento=b.idDepartamento")
            ->where("a.idMunicipio = $idMunicipio");

            return $q->get()->result_array();
    }  

    public function getMunicipios($idDepartamento){
        $q = $this->db->select("a.idMunicipio, a.nomMunicipio, a.idDepartamento")
            ->from("municipios_table a")
            ->where("a.idDepartamento = $idDepartamento");

            return $q->get()->result_array();
    }


    public function getUsuario($idUsuario){
        $q = $this->db->select("a.*")
            ->from("usuarios_table a")
            ->where("a.idUsuario = $idUsuario");

            return $q->get()->result_array();
    }


    public function getPerfiles(){
        $q = $this->db->select("a.idPerfil, a.nomPerfil")
            ->from("perfiles_table a");

            return $q->get()->result_array();
    }   
}
