<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sesiones extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function auth1()
    {
        $output["Key"] = false;

        $q = $this->db->select("a.*, b.nomPerfil")->from("usuarios_table as a")
        ->join("perfiles_table b","a.idPerfil=b.idPerfil")
        ->where("correo", $this->input->post("correo"));
        $result = $q->get()->result();


        
        if (sizeof($result) == 1) {
            $output["Key"] = true;
            $output["Value"] = $result;
        }
        return $output;
    }

    public function auth2($sesion)
    {
        $this->db->insert('sesiones_activas_table', $sesion);
        return $this->db->affected_rows() > 0;
    }

    function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function inSession()
    {
        $this->load->model("Parametros");
        $token = $this->session->userdata('token');
        $user = $this->session->userdata('idUsuario');
        // var_dump($token);
        
        $q = $this->db->select("COUNT(1) sesiones")->from("sesiones_activas_table")->where("idUsuario", $user)->where("token", $token)->where("'" . date('Y-m-d H:i:s', time()) . "' < vencimiento");
        $result = $q->get()->result();
        $sesiones = intval($result[0]->sesiones);

        //Refresca la Sesion
        $SesDura = intval($this->Parametros->getCod("SesTime")[0]["valor"]);
        $now = time();
        $vencimiento = $now + ($SesDura * 60);
        $startDate = date('Y-m-d H:i:s', $now);
        $endDate = date('Y-m-d H:i:s', $vencimiento);

        $this->db->query("UPDATE sesiones_activas_table SET inicio='$startDate', vencimiento='$endDate' WHERE idUsuario='$user' and token='$token'");


        //borrar sesiones viejas
        //die(var_dump($token));
        $this->db->query("DELETE FROM sesiones_activas_table WHERE '" . date('Y-m-d H:i:s', time()) . "' > vencimiento");
        return $sesiones > 0;
    }

    public function destroySession(){
        $token = $this->session->userdata('token');
        $this->db->query("DELETE FROM sesiones_activas_table WHERE token = '$token'");
        session_destroy();
    }


    public function getAccesos_VW($idUsuario="")
    {
  
                $q = $this->db->select(" e.idAcceso, e.nomAcceso")
                    ->from("usuarios_table a")
                    ->join("perfiles_table as b", "b.idPerfil = a.idPerfil")
                    ->join("perfiles_roles_table as c", "c.idPerfil = b.idPerfil")
                    ->join("accesos_roles_table as d", "d.idRol = c.idRol")
                    ->join("accesos_table as e", "e.idAcceso = d.idAcceso")
                    ->where("a.idUsuario = $idUsuario")
                    ->group_by("e.idAcceso");

            return $q->get()->result_array();
 
    }
}
