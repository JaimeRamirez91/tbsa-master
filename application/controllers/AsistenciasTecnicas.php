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

class AsistenciasTecnicas extends BaseController{
    public function __construct(){
        Parent::__construct();
    }

    public function IrPrincipal(){
        $this->loadHeader("Asistencias Tecnicas");
        $this->load->view("AsistenciasTecnicas/index");
        $this->load->view("Plantillas/footer"); 
    }
}