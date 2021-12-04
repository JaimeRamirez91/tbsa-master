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

class Usuarios extends BaseController{
    public function __construct(){
        Parent::__construct();
        $this->load->model("Sesiones");
        $this->load->model("UsuariosModel", "Usuarios");
    }

    public function consultarUsuarios(){
        $vwot = $this->Usuarios->getUsuarios_VW();
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($vwot, JSON_UNESCAPED_UNICODE));
    }

    public function Editar($idUsuario){
        $vwfv = $this->Usuarios->getUsuario($idUsuario);

        if (sizeof($vwfv) > 0) {
            $data["Usuario"] = $vwfv[0];
        }

        $Usuario = $data["Usuario"];
        $data["editar"] = true;
        $data["departamentos"] = $this->Usuarios->getDepartamentos();
        $data["perfiles"] = $this->Usuarios->getPerfiles();
        $obtMunicipio = $this->Usuarios->MunicipioSelec($Usuario["idMunicipio"]);
        $data["municipioSelec"] = $obtMunicipio[0]; 
        $data["municipiosFiltrados"] = $this->Usuarios->getMunicipios($obtMunicipio[0]["idDepartamento"]);

        $this->loadHeader("Usuarios" ."-". $vwfv[0]["nombre"]);
        $this->load->view("Usuarios/editUsuarios", $data);
        $this->load->view("Plantillas/footer");
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
        $data["Usuarios"] = $this->Usuarios->getUsuarios_VW($buscar);
        $data["buscar"] = $buscar;

        $this->loadHeader("Usuarios");
        $this->load->view("Usuarios/index", $data);
        $this->load->view("Plantillas/footer");
    }

    public function getSingle(){
        $Usuario =  $this->Usuarios->getSingle_VW($this->input->post("idUsuario"));
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($Usuario, JSON_UNESCAPED_UNICODE));
    }
    
    public function Nuevo(){
        $data["editar"] = false;
        $data["data"] = true;

        $data["departamentos"] = $this->Usuarios->getDepartamentos();
        $data["perfiles"] = $this->Usuarios->getPerfiles();
        
        $this->loadHeader("Nuevo Usuario");
        $this->load->view("Usuarios/editUsuarios", $data);
        $this->load->view("Plantillas/footer");
    }

    public function Eliminar(){
        $output["Error"] = true;
        $output["Value"] = "Ocurrió un error al eliminar el registro";
        $ok = $this->Usuarios->eliminarUsuario($this->input->post("idUsuario"));

        if ($ok) {
            $output["Error"] = false;
            $output["Value"] = "Usuario Eliminado  ";
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output, JSON_UNESCAPED_UNICODE));
    }

    public function Guardar(){
        $output["Error"] = false;
        $output["Value"] = "Registro guardado";
        $valido = true;
            
        if (!($this->input->post("nombre") != "") && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Ingrese el nombre del usuario";
        }

        if (!($this->input->post("correo") != "") && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Ingrese el correo del usuario";
        }

        if (!($this->input->post("referencia") != "") && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Ingrese referencia del usuario";
        }

        if (!($this->input->post("telefono") != "") && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Ingrese telefono del usuario";
        }

        if (!($this->input->post("dui") != "") && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Ingrese DUI del usuario";
        }

        if (!($this->input->post("nit") != "") && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Ingrese NIT del usuario";
        }

        if (!($this->input->post("mercaderia") != "") && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Ingrese productos que ofrece el usuario";
        }

        if (!($this->input->post("idDepartamento") != "") && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Seleccione departamento";
        }

        if (!($this->input->post("idMunicipio") != "") && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Seleccione municipio";
        }

        if (!($this->input->post("direccion") != "") && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Ingrese dirección del usuario";
        }

        if($this->input->post("idUsuario") == 0){
            if (!($this->input->post("password") != "") && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Ingrese password del usuario";
            }

            if (!($this->input->post("password2") != "") && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Ingrese confirmación de password usuario";
            }

            if (!($this->input->post("password") == $this->input->post("password2")) && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Contraseña y confirmar contraseña no son iguales";
            }
        }

        if (!($this->input->post("estado") != "Seleccionar") && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Seleccione estado del usuario";
        }

        if (!($this->input->post("idPerfil") > 0) && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Seleccione perfil del usuario";
        }

        $arr = $this->input->post();
        $arr["password"] = sha1($this->input->post("password"));
        unset($arr["idDepartamento"]);
        unset($arr["password2"]);

        if ($this->input->post("idUsuario") == 0) {
            if ($valido) {
                $insertId = $this->Usuarios->insertUsuario($arr);
                $output["insertId"] = $insertId;

                if ($insertId > 0) {
                    $output["Error"] = false;
                    $output["Value"] = "Registro guardado correctamente";
                } else {
                    $output["Error"] = true;
                    $output["Value"] = "Ocurrió un error al guardar el registro";
                }
            }
        } else{
            if ($valido) {
                $insertId = $this->Usuarios->updateUsuario($arr);
                $output["insertId"] = $insertId;

                if ($insertId > 0) {
                    $output["Error"] = false;
                    $output["Value"] = "Registro modificado correctamente";
                } else {
                    $output["Error"] = true;
                    $output["Value"] = "No se encontrarón modificaciones";
                }
            }
        }
        
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output, JSON_UNESCAPED_UNICODE));
    }

    public function guardarPassword(){
        $output["Error"] = false;
        $output["Value"] = "Registro guardado";
        $valido = true;

        if($this->input->post("idUsuario") > 0){
            if (!($this->input->post("password") != "") && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Ingrese nueva password del usuario";
            }

            if (!($this->input->post("password2") != "") && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Ingrese confirmación de password usuario";
            }

            if (!($this->input->post("password") == $this->input->post("password2")) && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Nueva contraseña y confirmar contraseña no son iguales";
            }
            
            $arr["password"] = sha1($this->input->post("password"));
            unset($arr["password2"]);
            unset($arr["usuarioP"]);

            if ($valido) {
                $insertId = $this->Usuarios->updateUsuario($arr);
                $output["insertId"] = $insertId;
                if ($insertId > 0) {
                    $output["Error"] = false;
                    $output["Value"] = "Password modificada correctamente";
                } else {
                    $output["Error"] = true;
                    $output["Value"] = "Ocurrió un error al modificar password";
                }
            }
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output, JSON_UNESCAPED_UNICODE));
    }

    public function Municipios(){
        $getMunicipios =  $this->Usuarios->getMunicipios($this->input->post("idDepartamento"));
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($getMunicipios, JSON_UNESCAPED_UNICODE));
    }
}