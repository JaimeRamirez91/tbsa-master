<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BaseController extends CI_Controller{
    public function __construct(){
        Parent::__construct()   ;
        $this->load->model("Sesiones");      
    }
}

class Principal extends BaseController{
    public function __construct(){
        Parent::__construct();
        $this->load->model("NoticiasModel", "Noticias");
    }

	public function index(){
        $buscar = "";     

        if (isset($_REQUEST["buscar"])){
            $buscar = $_REQUEST["buscar"];
        }

        $data["noticias"] = $this->Noticias->getNoticias_VW($buscar);
        $data["userNombre"] = $this->session->userdata("nombre");
        $data["nomPerfil"] = $this->session->userdata("nomPerfil");

        $this->load->view('Plantillas/header', $data);
        $this->load->view('Principal/index', $data);
        $this->load->view('Plantillas/footer');
	}
}