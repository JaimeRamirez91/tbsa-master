<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BaseController extends CI_Controller{
    public function __construct(){
        Parent::__construct();
        $this->load->model("Sesiones");

        if (!$this->enSesion()) {
            $this->session->sess_destroy();
            redirect('/Principal');
        }
    }

    //Valida si el usuario se encuentra en sesion activa
    private function enSesion(){
        return $this->Sesiones->inSession();
    }

    protected function loadHeader($titulo = ""){
        $data["userNombre"] = $this->session->userdata("nombre");
        $data["nomPerfil"] = $this->session->userdata("nomPerfil");
        $data["titulo"] = $titulo;
        $this->load->view("Plantillas/header", $data);
    }
}

class Perfiles extends BaseController{
    public function __construct(){
        Parent::__construct();
        $this->load->model("Sesiones");
        $this->load->model("PerfilesModel", "Perfiles");
    }

    public function consultarPerfiles(){
        $vwot = $this->Perfiles->getPerfiles_VW();
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($vwot, JSON_UNESCAPED_UNICODE));
    }

    public function consultar(){           
        $buscar="";
        $pag = 0;

        if (isset($_REQUEST["buscar"])){
            $buscar = $_REQUEST["buscar"];
        }

        if (isset($_REQUEST["valor"])){
            $pag = $_REQUEST["valor"];
        }

        $data["valorPag"] = $pag + 1;
        $data["perfiles"] = $this->Perfiles->getPerfiles_VW($buscar);
        $data["roles"] = $this->Perfiles->getRoles_VW();
        $data["buscar"] = $buscar;

        $this->loadHeader("Perfiles");
        $this->load->view("Perfiles/index", $data);
        $this->load->view("Plantillas/footer");
    }

    public function Eliminar(){
        $output["Error"] = true;
        $output["Value"] = "Ocurrió un error al eliminar el registro";

        if($this->Perfiles->eliminarRolesPerfil($this->input->post("idPerfil"))){
            $ok = $this->Perfiles->eliminarPerfil($this->input->post("idPerfil"));
        }

        if ($ok) {
            $output["Error"] = false;
            $output["Value"] = "Perfil Eliminado  ";
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output, JSON_UNESCAPED_UNICODE));
    }

    public function guardarPerfil(){
        $output["Error"] = false;
        $output["Value"] = "Registro guardado";
        $valido = true;
            
        if (!($this->input->post("nomPerfil") != "") && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Ingrese nombre de perfil";
        }

        if (!($this->input->post("mostrar") != 2) && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Seleccione si desea mostrar público";
        }

        if($valido){
            $valor = $this->Perfiles->getRoles_VW();
            $valido = false;

            foreach ($valor as $r) {
                if($this->input->post("rol".$r["idRol"])){
                    $valido = true;
                }
            }

            if($valido==false){
                $output["Error"] = true;
                $output["Value"] = "Seleccione roles ha asignar";
            }
        }

        $arr["nomPerfil"] = $this->input->post("nomPerfil");
        $arr["mostrar"] = $this->input->post("mostrar");

        if ($this->input->post("idPerfil") == 0) {
            if ($valido) {
                $insertId = $this->Perfiles->insertPerfil($arr);
                $output["insertId"] = $insertId;

                if ($insertId > 0) {                    
                    $valor = $this->Perfiles->getRoles_VW();

                    foreach ($valor as $r) {
                        if($this->input->post("rol".$r["idRol"])){
                            $this->Perfiles->insertRolesPerfil($insertId,$this->input->post("rol".$r["idRol"]));
                        }
                    }                        
                    
                    $output["Error"] = false;
                    $output["Value"] = "Registro guardado correctamente";

                } else {
                    $output["Error"] = true;
                    $output["Value"] = "Ocurrió un error al guardar el registro";
                }
            }
        } else{
            if ($valido) {
                $insertId = $this->Perfiles->updatePerfil($arr);
                $output["insertId"] = $insertId;
                
                $valor = $this->Perfiles->getRoles_VW();
                $this->Perfiles->eliminarRolesPerfil($this->input->post("idPerfil"));

                foreach ($valor as $r) {
                    if($this->input->post("rol".$r["idRol"])){
                    $this->Perfiles->insertRolesPerfil($this->input->post("idPerfil"),$this->input->post("rol".$r["idRol"]));
                    }
                }           

                $output["Error"] = false;
                $output["Value"] = "Registro modificado correctamente";                   
            }
        }
        
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output, JSON_UNESCAPED_UNICODE));
    }

    public function verDetalles(){
        $detallePerfil =  $this->Perfiles->detalles_VW($this->input->post("idPerfil"));
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($detallePerfil, JSON_UNESCAPED_UNICODE));
    }
}