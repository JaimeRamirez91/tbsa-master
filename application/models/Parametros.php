<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Parametros extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getId($Id = 0)
    {
        $output["Key"] = true;
        $q = $this->db->select("*")->from("parametros_table")->where("idParametro", $Id);
        
        return $q->get()->result_array();
    }

    public function getCod($Codigo = "")
    {
        $output["Key"] = true;
        $q = $this->db->select("*")->from("parametros_table")->where("codigo", $Codigo);
        
        return $q->get()->result_array();
    }

}
