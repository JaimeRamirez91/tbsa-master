<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BaseController extends CI_Controller{    
    public function __construct(){
        Parent::__construct();
    }

    protected function loadHeader($titulo = ""){        
        $data["userNombre"] = $this->session->userdata("nombre");
        $data["nomPerfil"] = $this->session->userdata("nomPerfil");
        $data["titulo"] = $titulo;
        $this->load->view("Plantillas/header", $data);
    }
}

class Galeria extends BaseController{
    public function __construct(){
        Parent::__construct();
    }

    public function IrPrincipal(){
        $this->loadHeader("Galería");
        $this->load->view("Galeria/index");
        $this->load->view("Plantillas/footer"); 
    }
    
    public function SubirArchivo(){ 
        $tipoPermitido = array('jpg', 'jpge', 'png', 'gif', 'tiff', 'psd', 'bmp', 'avi', 'wmv', 'asf', 'flv', 'rm', 'rmvb', 'mp4', 'mkv', 'mks', '3gpp');  
       
        $dir = 'assets/galeria/';
        $nombre = $_FILES['fotoVideo']['name'];
        $ruta = $dir . $nombre;
        $arreglo = explode(".", $nombre);
        $extension = strtolower(end($arreglo));
            
        if(in_array($extension, $tipoPermitido)){
            move_uploaded_file($_FILES['fotoVideo']['tmp_name'], $ruta);
        } 
        
        $this->loadHeader("Galería");
        $this->load->view("Galeria/index");
        $this->load->view("Plantillas/footer"); 
    }

    public function Eliminar(){
        $output["Error"] = true;
        $output["Value"] = "Ocurrió un error al eliminar el registro";

        $nombre = $this->input->post("nombre");
        $dirCompleta = 'assets/galeria/' . $nombre;

        if(file_exists($dirCompleta)){
            $ok = true;
            unlink($dirCompleta);
        }

        if ($ok){
            $output["Error"] = false;
            $output["Value"] = "Multimedia Eliminada";
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output, JSON_UNESCAPED_UNICODE));
    }
}