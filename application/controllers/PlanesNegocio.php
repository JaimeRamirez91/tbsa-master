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

class PlanesNegocio extends BaseController{
    public function __construct(){
        Parent::__construct();
        $this->load->model("Sesiones");
    }

    public function IrPrincipal(){
        $this->loadHeader("Gestión empresarial");
        $this->load->view("PlanesNegocio/index");
        $this->load->view("Plantillas/footer"); 
    }
}