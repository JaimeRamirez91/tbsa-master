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

class PreciosProductos extends BaseController{
    public function __construct(){
        Parent::__construct();
        $this->load->model("Sesiones");
    }

    public function IrPrincipal(){
        $this->loadHeader("Gestión empresarial");
        $this->load->view("PreciosProductos/index");
        $this->load->view("Plantillas/footer"); 
    }
    
    public function SubirArchivo(){ 
        $tipoPermitido = 'pdf';
        $dirCompleta = 'assets/documents/productPrices/precios_de_productos.pdf';

        $dir = 'assets/documents/productPrices/';
        $nombre = $_FILES['archivoProductos']['name'];      
        $ruta = $dir . $nombre;
        $arreglo = explode(".", $nombre);
        $extension = strtolower(end($arreglo));

        if(!$nombre == "" && file_exists($dirCompleta)){
            unlink($dirCompleta);
        }        
            
        if($extension == $tipoPermitido){
            move_uploaded_file($_FILES['archivoProductos']['tmp_name'], $ruta);
            rename($ruta, $dir . "precios_de_productos.pdf");
        } 

        $this->loadHeader("Precios de productos");
        $this->load->view("PreciosProductos/index");
        $this->load->view("Plantillas/footer"); 
    }
}