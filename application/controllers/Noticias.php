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

class Noticias extends BaseController{
    public function __construct(){
        Parent::__construct();
        $this->load->model("NoticiasModel", "Noticias");
    }

    public function consultar(){           
        $buscar="";
        $pag = 0;

        if(isset($_REQUEST["buscar"])){
            $buscar = $_REQUEST["buscar"];
        }

        if(isset($_REQUEST["valor"])){
            $pag = $_REQUEST["valor"];
        }

        $data["valorPag"] = $pag + 1;
        $data["noticias"] = $this->Noticias->getNoticias_VW($buscar);
        $data["buscar"] = $buscar;
        $this->loadHeader("Noticias");
        $this->load->view("Noticias/index", $data);
        $this->load->view("Plantillas/footer"); 
    }

    public function Eliminar(){
        $output["Error"] = true;
        $output["Value"] = "Ocurrió un error al eliminar el registro";
        
        $this->EliminarFoto($this->input->post("imagen"));

        $ok = $this->Noticias->eliminarNoticia($this->input->post("idNoticia"));
        
        if($ok){
            $output["Error"] = false;
            $output["Value"] = "Noticia eliminada  ";
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output, JSON_UNESCAPED_UNICODE));
    }

    public function guardarNoticia(){
        $output["Error"] = false;
        $output["Value"] = "Registro guardado";
        $valido = true;

        if(!($this->input->post("titulo") != "") && $valido){
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Ingrese titulo de noticia";
        }

        if(!($this->input->post("principal") != 2) && $valido){
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Seleccione si desea mostrar como principal";
        }

        if(!($this->input->post("descripcion") != "") && $valido){
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Ingrese descripción de noticia";
        }       

        $arr["titulo"] = $this->input->post("titulo");
        $arr["descripcion"] = $this->input->post("descripcion");
        $arr["principal"] = $this->input->post("principal");
        $arr["imagen"] = $this->input->post("nomImagen");

        $tipoPermitido = array('jpg', 'jpge', 'png', 'gif', 'tiff', 'psd', 'bmp'); 
        $arreglo = explode(".", $arr["imagen"]);
        $extension = strtolower(end($arreglo));

        if($this->input->post("idNoticia") == 0){            
            if(!($arr["imagen"] != "") && $valido){
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Es necesario subir la foto de la noticia";
            }   

            if(!(in_array($extension, $tipoPermitido)) && $valido){
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Tipo de imagen no admitido";
            }  

            if($valido){
                $insertId = $this->Noticias->insertNoticia($arr);
                $output["insertId"] = $insertId;
                if($insertId > 0){  
                    $output["Error"] = false;
                    $output["Value"] = "Registro guardado correctamente";
                } else{
                    $output["Error"] = true;
                    $output["Value"] = "Ocurrió un error al guardar el registro";
                }
            }
        } else{        
            if(($arr["imagen"] != "") && $valido){
                if(!(in_array($extension, $tipoPermitido)) && $valido){
                    $valido = false;
                    $output["Error"] = true;
                    $output["Value"] = "Tipo de imagen no admitido";
                }  
            }   

            if($valido){                
                if($arr["imagen"] != ""){
                    $this->EliminarFoto($this->input->post("nomImagenVieja"));
                } else{
                    $arr["imagen"] = $this->input->post("nomImagenVieja");
                }
                
                if($this->Noticias->updateNoticia($arr)){
                    $output["Error"] = false;
                    $output["Value"] = "Registro modificado correctamente";
                } else{
                    $output["Error"] = true;
                    $output["Value"] = "Error modificando registro"; 
                }                
            }
        }           
        
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output, JSON_UNESCAPED_UNICODE));
    }

    public function SubirArchivo(){ 
        $tipoPermitido = array('jpg', 'jpge', 'png', 'gif', 'tiff', 'psd', 'bmp');  
       
        $dir = 'assets/fotosNoticias/';
        $nombre = $_FILES['photoNoti']['name'];
        $ruta = $dir . $nombre;
        $arreglo = explode(".", $nombre);
        $extension = strtolower(end($arreglo));
            
        if(in_array($extension, $tipoPermitido)){
            move_uploaded_file($_FILES['photoNoti']['tmp_name'], $ruta);
        } 

        $buscar="";
        $pag = 0;

        if(isset($_REQUEST["buscar"])){
            $buscar = $_REQUEST["buscar"];
        }

        if(isset($_REQUEST["valor"])){
            $pag = $_REQUEST["valor"];
        }

        $data["valorPag"] = $pag + 1;
        $data["noticias"] = $this->Noticias->getNoticias_VW($buscar);
        $data["buscar"] = $buscar;
        
        $this->loadHeader("Noticias");
        $this->load->view("Noticias/index", $data);
        $this->load->view("Plantillas/footer"); 
    }
    
    public function EliminarFoto($imagen){
        $dirCompleta = 'assets/fotosNoticias/' . $imagen;

        if(file_exists($dirCompleta)){
            unlink($dirCompleta);
        }
    }
    
    public function verDetalles(){
        $detalleNoticia =  $this->Noticias->detalles_VW($this->input->post("idNoticia"));
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($detalleNoticia, JSON_UNESCAPED_UNICODE));
    }
}