<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NoticiasModel extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function getNoticias_VW($buscar = ""){
        $q = $this->db->select("idNoticia, titulo, descripcion, imagen, if(principal > 0, 'SI', 'NO') as principal")
            ->from("noticias_table")
            ->where("titulo like '%" . $buscar . "%'" . "OR descripcion like '%" . $buscar . "%'");

        return $q->get()->result_array();
    }

    public function eliminarNoticia($idNoticia){        
        $this->db->where("idNoticia", $idNoticia)->delete("noticias_table");

        return $this->db->affected_rows() > 0;
    }

    public function insertNoticia($arr){
        $this->db->insert("noticias_table", $arr);

        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }

    public function detalles_VW($idNoticia){  
        $q = $this->db->select("*")
            ->from("noticias_table")
            ->where("idNoticia", $idNoticia);

        return $q->get()->result_array();
    }

    public function updateNoticia($arr){
        $this->db->where("idNoticia", $this->input->post("idNoticia"));
        $this->db->update("noticias_table", $arr);

        $insert_id = $this->db->affected_rows();
        return $insert_id > 0;
    }
}
