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

class GuiasTecnicas extends BaseController{
    public function __construct(){
        Parent::__construct();
        $this->load->model("Sesiones");
    }

    public function IrPrincipal(){
        $this->loadHeader("Guías técnicas");
        $this->load->view("GuiasTecnicas/index");
        $this->load->view("Plantillas/footer"); 
    }
    
    public function SubirArchivo(){ 
        $tipoPermitido = 'pdf';  
       
        $dir = 'assets/documents/technicalGuides/';
        $nombre = $_FILES['archivosPDF']['name'];      
        $ruta = $dir . $nombre;
        $arreglo = explode(".", $nombre);
        $extension = strtolower(end($arreglo));
            
        if($extension == $tipoPermitido){
            move_uploaded_file($_FILES['archivosPDF']['tmp_name'], $ruta);
        } 
        
        $this->loadHeader("Guías técnicas");
        $this->load->view("GuiasTecnicas/index");
        $this->load->view("Plantillas/footer"); 
    }

    public function Eliminar(){
        $output["Error"] = true;
        $output["Value"] = "Ocurrió un error al eliminar el registro";
        $ok = false;

        $nombre = $this->input->post("nombre");
        $dirCompleta = 'assets/documents/technicalGuides/' . $nombre;

        if(file_exists($dirCompleta)){
            $ok = true;
            unlink($dirCompleta);
        }

        if ($ok){
            $output["Error"] = false;
            $output["Value"] = "Documento eliminado";
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output, JSON_UNESCAPED_UNICODE));
    }
}