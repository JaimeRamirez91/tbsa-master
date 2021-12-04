<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SolicitudesModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getSolicitudes_VW($buscar="",$idUsuario="")
    {
                $q = $this->db->select("a.*,b.nombre, b.telefono,c.nomMunicipio, d.idDepartamento, d.nomDepartamento")
                    ->from("solicitudes_table a")
                    ->join("usuarios_table b","a.idUsuario=b.idUsuario")
                    ->join("municipios_table c","a.idMunicipioEvento=c.idMunicipio")
                    ->join("departamentos_table d","c.idDepartamento=d.idDepartamento")
                    ->where("a.idUsuario", $idUsuario)
                    ->where("(b.nombre like '%".$buscar."%'"."OR a.tipoSolicitud like '%".$buscar."%'"."OR a.estado like '%".$buscar."%')")
                    ->order_by("a.fechaSolicitud", "ASC");

            return $q->get()->result_array();
 
    }

    public function getSolicitudes2_VW($buscar="",$idUsuario="")
    {
                $q = $this->db->select("a.*,b.nombre, b.telefono,c.nomMunicipio, d.idDepartamento, d.nomDepartamento")
                    ->from("solicitudes_table a")
                    ->join("usuarios_table b","a.idUsuario=b.idUsuario")
                    ->join("municipios_table c","a.idMunicipioEvento=c.idMunicipio")
                    ->join("departamentos_table d","c.idDepartamento=d.idDepartamento")
                    ->where("(b.nombre like '%".$buscar."%'"."OR a.tipoSolicitud like '%".$buscar."%'"."OR a.estado like '%".$buscar."%')")
                    ->order_by("a.fechaSolicitud", "ASC");

            return $q->get()->result_array();
 
    }

    public function getSingle_VW($idSolicitud)
    {
  
                $q = $this->db->select("a.*,b.nombre, b.mercaderia, b.telefono,c.nomMunicipio, d.idDepartamento, d.nomDepartamento")
                    ->from("solicitudes_table a")
                    ->join("usuarios_table b","a.idUsuario=b.idUsuario")
                    ->join("municipios_table c","a.idMunicipioEvento=c.idMunicipio")
                    ->join("departamentos_table d","c.idDepartamento=d.idDepartamento")
                    ->where("idSolicitud", $idSolicitud);

            return $q->get()->result_array();
 
    }


    public function eliminarSolicitud($idSolicitud)
    {   
        $this->db->where("idSolicitud", $idSolicitud)->delete("solicitudes_table");

        return $this->db->affected_rows() > 0;

    }

    
    public function insertSolicitud($arr)
    {
        $this->db->insert("solicitudes_table", $arr);

        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }

    public function updateSolicitud($arr)
    {
        $this->db->where("idSolicitud", $this->input->post("idSolicitud"));
        $this->db->update("solicitudes_table", $arr);

        $insert_id = $this->db->affected_rows();
        return $insert_id > 0;
    }

    public function aprobarSolicitud($idSolicitud, $observacionCA="")
    {   
        $arr["estado"]="APROBADA";
        $arr["observacionCA"]=$observacionCA;

        $this->db->where("idSolicitud", $idSolicitud);
        $this->db->update("solicitudes_table", $arr);

        $insert_id = $this->db->affected_rows();
        return $insert_id > 0;
    }

    public function denegarSolicitud($idSolicitud, $observacionCA="")
    {
        $arr["estado"]="DENEGADA";
        $arr["observacionCA"]=$observacionCA;
        
        $this->db->where("idSolicitud", $idSolicitud);
        $this->db->update("solicitudes_table", $arr);

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

    public function getMunicipios($idDepartamento=""){
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
