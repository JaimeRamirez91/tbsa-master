<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BaseController extends CI_Controller{
    public function __construct() {
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

class Solicitudes extends BaseController{
    public function __construct()
    {
        Parent::__construct();
        $this->load->model("Sesiones");
        $this->load->model("SolicitudesModel", "Solicitudes");
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

    public function consultar()
    {           $buscar="";
                $pag = 0;
            if (isset($_REQUEST["buscar"])){
                $buscar = $_REQUEST["buscar"];
            }
            if (isset($_REQUEST["valor"])){
                $pag = $_REQUEST["valor"];
            }
                $data["departamentos"] = $this->Solicitudes->getDepartamentos();
                $data["valorPag"] = $pag + 1;
                $data["Solicitudes"]="";
            if($this->session->userdata("nomPerfil") == "Director CA" || $this->session->userdata("nomPerfil") == "Técnico CA"){
                $data["Solicitudes"] = $this->Solicitudes->getSolicitudes2_VW($buscar);
            }else{
                $data["Solicitudes"] = $this->Solicitudes->getSolicitudes_VW($buscar,$this->session->userdata("idUsuario"));
            }
                $data["buscar"] = $buscar;
                $this->loadHeader("Solicitudes");
                $this->load->view("Solicitudes/index", $data);
                $this->load->view("Plantillas/footer");
   

    }

    public function NuevaSolicitud()
    {
        $tipoSolicitud =  intVal($this->input->post("tipoSolicitudAgregar"),0);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($tipoSolicitud, JSON_UNESCAPED_UNICODE));
   

    }
    
    public function getSingle()
    {
        $Solicitud =  $this->Solicitudes->getSingle_VW($this->input->post("idSolicitud"));
        
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($Solicitud, JSON_UNESCAPED_UNICODE));
   

    }

    public function EliminarSolicitud()
    {
        $output["Error"] = true;
        $output["Value"] = "Ocurrió un error al eliminar el registro";
        $ok = $this->Solicitudes->eliminarSolicitud($this->input->post("idSolicitud"));
        if ($ok) {
            $output["Error"] = false;
            $output["Value"] = "Solicitud Eliminada  ";
        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output, JSON_UNESCAPED_UNICODE));
    }

    public function guardarSolicitud()
    {
        $output["Error"] = false;
        $output["Value"] = "Registro guardado";
        $valido = true;
        $tipoSolicitud =  $this->input->post("tipoSolicitud");
                    
        if($tipoSolicitud == 3){
            if (!($this->input->post("area") != 0) && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Seleccione el Área";
            }

            if (!($this->input->post("areaProductiva") != "") && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Digite la cantidad de área productiva";
            }

            switch($this->input->post("area")){
                case 1:
                    $arr["area"] = "AGRICOLA";
                break;
                case 2:
                    $arr["area"] ="PECUARIA";
                break;
                case 3:
                    $arr["area"] = "OTRO";
                break;
                default:
                break;
            }
        }
        
        if($tipoSolicitud == 2 || $tipoSolicitud==3){
            switch($tipoSolicitud){
                case 2:
                    if (!($this->input->post("temaCapacitacion") != "") && $valido) {
                        $valido = false;
                        $output["Error"] = true;
                        $output["Value"] = "Digite el tema de la capacitación";
                    }
                break;
                case 3:
                    if (!($this->input->post("temaCapacitacion") != "") && $valido) {
                        $valido = false;
                        $output["Error"] = true;
                        $output["Value"] = "Digite el problema especifico";
                    }
                break;
                default:
                break;
            }            
        }

        if($tipoSolicitud == 4 || $tipoSolicitud==5 || $tipoSolicitud==6)
            if (!($this->input->post("servicioSolicitado") != "") && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Ingrese el servicio a solicitar";
            }

        if($tipoSolicitud != 1){    
            if (!($this->input->post("fecha") != "") && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Seleccione fecha";
            }

            if (!($this->input->post("hora") != "") && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Seleccione hora";
            }

            if (!($this->input->post("nPersonas") != 0) && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Digite el número de personas";
            }

            if (!($this->input->post("otroContacto") != "") && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Digite el número de teléfono";
            }

            $arr["fechaHoraEvento"] = $this->input->post("fecha")." ".$this->input->post("hora");
            $arr["otroContacto"] = $this->input->post("otroContacto");
            $arr["nPersonas"] = $this->input->post("nPersonas");
        }
                
                
        if($tipoSolicitud == 1){
            if (!($this->input->post("cantidadProduccion") != 0) && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Digite la cantidad de producción";
            }

            if (!($this->input->post("tiempoProduccion") != 0) && $valido) {
                $valido = false;
                $output["Error"] = true;
                $output["Value"] = "Digite el tiempo de producción";
            }

            $arr["tiempoProduccion"] = $this->input->post("tiempoProduccion");            
        }
                
        if (!($this->input->post("idDepartamento") != 0) && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Seleccione departamento";
        }

        if (!($this->input->post("idMunicipio") != 0) && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Seleccione municipio";
        }

        if (!($this->input->post("direccionEvento") != "") && $valido) {
            $valido = false;
            $output["Error"] = true;
            $output["Value"] = "Ingrese dirección del usuario";
        }

        switch($tipoSolicitud){
            case 1:
                $arr["tipoSolicitud"] = "Agro-mercado";
            break;
            case 2:
                $arr["tipoSolicitud"] = "Capacitación";
            break;
            case 3:
                $arr["tipoSolicitud"] = "Asistencia Técnica";
            break;
            case 4:
                $arr["tipoSolicitud"] = "Gestión Ambiental";
            break;
            case 5:
                $arr["tipoSolicitud"] = "Gestión Empresarial";
            break;
            case 6:
                $arr["tipoSolicitud"] = "Planes de Negocio";
            break;
            default:
            break;
        }

        $arr["estado"] = "PENDIENTE";
        $arr["comentario"] = $this->input->post("comentario");
        $arr["idUsuario"] = $this->input->post("idUsuario");

        if ($this->input->post("idSolicitud") == 0) {
            $arr["fechaSolicitud"] = date("Y")."-".date("m")."-".date("d");
        }
        
        if ($tipoSolicitud == 3){
            $arr["cantidadProduccion"] = $this->input->post("areaProductiva");
        } else{
            $arr["cantidadProduccion"] = $this->input->post("cantidadProduccion");
        }

        $arr["idMunicipioEvento"] = $this->input->post("idMunicipio");
        $arr["direccionEvento"] = $this->input->post("direccionEvento");
        $arr["temaCapacitacion"] = $this->input->post("temaCapacitacion");
        $arr["servicioSolicitado"] = $this->input->post("servicioSolicitado");
        $arr["observacionCA"] = "";

        if ($this->input->post("idSolicitud") == 0) {
            if ($valido) {
                $insertId = $this->Solicitudes->insertSolicitud($arr);
                $output["insertId"] = $insertId;

                if ($insertId > 0) {
                    $output["Error"] = false;
                    $output["Value"] = "Registro guardado correctamente";
                } else {
                    $output["Error"] = true;
                    $output["Value"] = "Ocurrió un error al guardar el registro";
                }
            }
        }else{
            if ($valido) {
                $insertId = $this->Solicitudes->updateSolicitud($arr);
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

    public function guardarObservacion(){
        $output["Error"] = false;
        $output["Value"] = "Registro guardado";

        switch($this->input->post("valor")){
            case 1:
                $insertId = $this->Solicitudes->aprobarSolicitud($this->input->post("idSolicitudO"), $this->input->post("observacionCA2"));
                    $output["insertId"] = $insertId;
                    if ($insertId > 0) {
                        $output["Error"] = false;
                        $output["Value"] = "Solicitud aprobada correctamente";
                    } else {
                        $output["Error"] = true;
                        $output["Value"] = "Ocurrió un error al aprobar solicitud";
                    }
            break;
            case 2:
                $insertId = $this->Solicitudes->denegarSolicitud($this->input->post("idSolicitudO"), $this->input->post("observacionCA2"));
                    $output["insertId"] = $insertId;
                    if ($insertId > 0) {
                        $output["Error"] = false;
                        $output["Value"] = "Solicitud denegada correctamente";
                    } else {
                        $output["Error"] = true;
                        $output["Value"] = "Ocurrió un error al denegar solicitud";
                    }
            break;
            default:
            break;
        }
        
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output, JSON_UNESCAPED_UNICODE));
    }

    public function Municipios(){
        $getMunicipios =  $this->Solicitudes->getMunicipios($this->input->post("idDepartamento"));
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($getMunicipios, JSON_UNESCAPED_UNICODE));
    }
}