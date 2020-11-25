<?php
error_reporting(E_ALL);
include_once("Usuario.php");

class Cliente extends Usuario {
private $nombreCompleto;
private $telefonoCasa;
private $direccion;
private $correo;
private $arrPedidos;



	public function buscarPorClave() {
	$accesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$bRet = false;
		if ($this->claveUsuario < 1 || empty($this->contrasenia))
			throw new Exception("Faltan datos");
		else{
			if ($accesoDatos->conectar()){
				$sQuery = " SELECT t1.claveUsuario, t2.nombreCompleto, t2.telefonoCasa, 
								   t2.direccion, t2.correo
							FROM usuario t1
							JOIN Cliente t2 ON t2.claveUsuario = t1.claveUsuario
							WHERE t1.claveUsuario = ".$this->claveUsuario."
                            AND t1.contrasenia = '".$this->contrasenia."'";
                            
				$arrRS = $accesoDatos->ejecutarConsulta($sQuery);
				$accesoDatos->desconectar();
				if ($arrRS){
					$this->claveUsuario = $arrRS[0][0];
					$this->nombreCompleto = $arrRS[0][1];
					$this->telefonoCasa = $arrRS[0][2];
                    $this->direccion = $arrRS[0][3];
					$this->correo = $arrRS[0][4];
					$bRet = true;
				}
			}
		}
		return $bRet;
	}


	public function insertar() {
		$accesoDatos=new AccesoDatos();
		$sQuery="";
		$nRet = -1;
			if (empty($this->contrasenia) ||
				empty($this->nombreCompleto)||
				empty($this->telefonoCasa)||
				empty($this->direccion)||
				empty($this->correo))
				throw new Exception("Cliente->insertar: faltan datos");
			else{
				if ($accesoDatos->conectar()){
					$sQuery = parent::getInsertar();
					$sQuery = $sQuery."
						INSERT INTO cliente (
							claveUsuario, nombreCompleto, telefonoCasa, 
							direccion, correo) 
						VALUES (LAST_INSERT_ID(), 
						'".$this->nombreCompleto."', '".$this->telefonoCasa."', 
						'".$this->direccion."', '".$this->correo."');";
						error_log($sQuery,0);
					$nRet = $accesoDatos->ejecutarComando($sQuery);
					$accesoDatos->desconectar();		
				}
			}
			return $nRet;
		}

		public function buscarUltimaClv(){
			$accesoDatos=new AccesoDatos();
			$sQuery="";
			$arrRS=null;
			if ($accesoDatos->conectar()){
				$sQuery = "select MAX(claveUsuario) from cliente";
				$arrRS = $accesoDatos->ejecutarConsulta($sQuery);
				$accesoDatos->desconectar();
			}
			return $arrRS;
		}
		
	public function buscar() {
		throw new Exception("No implementada");
	}

	public function buscarTodos() {
		throw new Exception("No implementada");
	}

	public function modificar() {
		throw new Exception("No implementada");
	}

	public function eliminar() {
		throw new Exception("No implementada");
	}
	
	public function getNombreCompleto(){
		return $this->nombreCompleto;
	}

	public function setNombreCompleto($nombreCompleto){
		$this->nombreCompleto = $nombreCompleto;
	}

	public function getTelefonoCasa(){
		return $this->telefonoCasa;
	}

	public function setTelefonoCasa($telefonoCasa){
		$this->telefonoCasa = $telefonoCasa;
	}

	public function getDireccion(){
		return $this->direccion;
	}

	public function setDireccion($direccion){
		$this->direccion = $direccion;
	}

	public function getCorreo(){
		return $this->correo;
	}

	public function setCorreo($correo){
		$this->correo = $correo;
	}	
	public function getPedidos(){
       return $this->arrPedidos;
    }
	public function setPedidos($valor){
       $this->arrPedidos = $valor;
	}

}
?>