<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller{
	public function __construct() {
		Parent::__construct();
    }

	public function index(){
		$data["correo"] = "";

		$this->load->model("Sesiones");
		$this->load->model("Parametros");

		if ($this->input->post("correo") != null) {
			$user = $this->Sesiones->auth1();
			
			if ($user["Key"]) {
				if(!($user["Value"][0]->estado == "BLOQUEADO" || $user["Value"][0]->estado == "INACTIVO")){
					if ($user["Value"][0]->password == sha1($this->input->post("password"))) {

						//inicia sesion normalmente
						$sesObj["idUsuario"] = $user["Value"][0]->idUsuario;
						$sesObj["token"] = $this->Sesiones->GUID();

						//duracion de sesion en minutos
						$SesDura = intval($this->Parametros->getCod("SesTime")[0]["valor"]);
						$now = time();
						$vencimiento = $now + ($SesDura * 60);
						$startDate = date('Y-m-d H:i:s', $now);
						$endDate = date('Y-m-d H:i:s', $vencimiento);
						$sesObj["inicio"] = $startDate;
						$sesObj["vencimiento"] = $endDate;
						$accesos = $this->Sesiones->getAccesos_VW($sesObj["idUsuario"]);

						if($this->Sesiones->auth2($sesObj)){
							//crear cookie de sesion
							$data["userNombre"] = $user["Value"][0]->nombre;
							$newdata["idUsuario"]=$sesObj["idUsuario"];
							$newdata["correo"]=$this->input->post("correo");
							$newdata["token"]=$sesObj["token"];
							$newdata["nombre"]=$user["Value"][0]->nombre;
							$newdata["mercaderia"]=$user["Value"][0]->mercaderia;
							$newdata["nomPerfil"]=$user["Value"][0]->nomPerfil;

							foreach($accesos as $a){
								$newdata["acceso".$a["idAcceso"]]=1;
							}

							$this->session->set_userdata($newdata);
						}
					} else {
						//contraseña incorrecta
						$data["errorLogin"] = true;
						$data["errormsg"] = "Contraseña incorrecta";
					}
				} else {
					//usuario erroneo
					$data["errorLogin"] = true;
					$data["errormsg"] = "Usuario no habilitado";
				}
			} else {
				$data["errorLogin"] = true;
				$data["errormsg"] = "Usuario no encontrado";
			} 
		} else {
			//Correo no digitado
			$data["errorLogin"] = true;
			$data["errormsg"] = "Correo no digitado";
		}

		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($data, JSON_UNESCAPED_UNICODE));
	}

	public function Logout(){
		$this->load->model("Sesiones");
		$this->Sesiones->destroySession();
	}	

	public function inSesion(){
		$valor = false;
		$this->load->model("Sesiones");

		if($this->Sesiones->inSession()){
			$valor = true;
		}
		else{
			$this->Sesiones->destroySession();
		}

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($valor, JSON_UNESCAPED_UNICODE));
	}		
}