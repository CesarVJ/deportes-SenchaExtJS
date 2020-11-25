<?php
error_reporting(E_ALL);
include_once("Usuario.php");

class Administrador extends Usuario {
private $nombreAdmin;


	public function buscarPorClave() {
	$accesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$bRet = false;
		if ($this->claveUsuario < 1 || empty($this->contrasenia))
			throw new Exception("Faltan datos");
		else{
			if ($accesoDatos->conectar()){
				$sQuery = " SELECT t1.claveUsuario, t2.nombreAdmin
							FROM usuario t1
							JOIN Administrador t2 ON t2.claveUsuario = t1.claveUsuario
							WHERE t1.claveUsuario = ".$this->claveUsuario."
                            AND t1.contrasenia = '".$this->contrasenia."'";
                            
				$arrRS = $accesoDatos->ejecutarConsulta($sQuery);
				$accesoDatos->desconectar();
				if ($arrRS){
					$this->claveUsuario = $arrRS[0][0];
					$this->nombreAdmin = $arrRS[0][1];
					$bRet = true;
				}
			}
		}
		return $bRet;
	}
	public function buscar() {
		throw new Exception("No implementada");
	}

	public function buscarTodos() {
		throw new Exception("No implementada");
	}

	public function insertar() {
		throw new Exception("No implementada");
	}

	public function modificar() {
		throw new Exception("No implementada");
	}

	public function eliminar() {
		throw new Exception("No implementada");
	}
	
	public function getNombreAdmin(){
		return $this->nombreAdmin;
	}

	public function setNombreAdmin($nombreAdmin){
		$this->nombreAdmin = $nombreAdmin;
	}
}
?>