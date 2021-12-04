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

class Roles extends BaseController{
    public function __construct(){
        Parent::__construct();
        $this->load->model("Sesiones");
        $this->load->model("RolesModel", "Roles");
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
        $data["roles"] = $this->Roles->getRoles_VW($buscar);
        $data["accesos"] = $this->Roles->getAccesos_VW();
        $data["buscar"] = $buscar;

        $this->loadHeader("Roles");
        $this->load->view("Roles/index", $data);
        $this->load->view("Plantillas/footer");  
    }

    public function Eliminar(){
        $output["Error"] = true;
        $output["Value"] = "Ocurrió un error al eliminar el registro";

        if($this->Roles->eliminarAccesosRol($this->input->post("idRol"))){
            $ok = $this->Roles->eliminarRol($this->input->post("idRol"));
        }

        if ($ok) {
            $output["Error"] = false;
            $output["Value"] = "Rol Eliminado  ";
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output, JSON_UNESCAPED_UNICODE));
    }

    public function guardarRol(){
        $output["Error"] = false;
        $output["Value"] = "Registro guardado";
        $valido = true;
            
        if (!($this->input->post("nomRol") != "") && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Ingrese nombre de rol";
        }
        if($valido){
            $valor = $this->Roles->getAccesos_VW();
            $valido = false;

            foreach ($valor as $r) {
                if($this->input->post("acceso".$r["idAcceso"])){
                    $valido = true;
                }
            }

            if($valido==false){
                $output["Error"] = true;
                $output["Value"] = "Seleccione accesos ha asignar";
            }
        }

        $arr["nomRol"] = $this->input->post("nomRol");

        if ($this->input->post("idRol") == 0) {
            if ($valido) {
                $insertId = $this->Roles->insertRol($arr);
                $output["insertId"] = $insertId;

                if ($insertId > 0) {                    
                    $valor = $this->Roles->getAccesos_VW();

                    foreach ($valor as $r) {
                        if($this->input->post("acceso".$r["idAcceso"])){
                            $this->Roles->insertAccesosRol($insertId,$this->input->post("acceso".$r["idAcceso"]));
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
                $insertId = $this->Roles->updateRol($arr);
                $output["insertId"] = $insertId;
                
                $valor = $this->Roles->getAccesos_VW();
                $this->Roles->eliminarAccesosRol($this->input->post("idRol"));

                foreach ($valor as $r) {
                    if($this->input->post("acceso".$r["idAcceso"])){
                        $this->Roles->insertAccesosRol($this->input->post("idRol"),$this->input->post("acceso".$r["idAcceso"]));
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
        $detalleRol =  $this->Roles->detalles_VW($this->input->post("idRol"));
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($detalleRol, JSON_UNESCAPED_UNICODE));
    }
}