<?php

include_once("AccesoDatos.php");
class Equipo {
    private $claveEquipo;
    private $nombreEquipo;
    private $arrArticulos;	


    public function buscarTodos(){
		$accesoDatos=new AccesoDatos();
		$consulta="";
		$arrRS=null;
		$arrRet=array();
		$equipo;
			if ($accesoDatos->conectar()){
				$consulta = "SELECT t1.claveEquipo, t1.nombreEquipo
						   FROM Equipo t1
						   ORDER BY t1.claveEquipo;
						";
				$arrRS = $accesoDatos->ejecutarConsulta($consulta);
				$accesoDatos->desconectar();
				if ($arrRS){
					$arrRet = array();
					foreach($arrRS as $arregloDatos){
						$equipo = new Equipo();
						$equipo->setClaveEquipo($arregloDatos[0]);
						$equipo->setNombreEquipo($arregloDatos[1]);
						$arrRet[] = $equipo;
					}
				}
			} 
			return $arrRet;
    }

    public function getClaveEquipo(){
		return $this->claveEquipo;
	}

	public function setClaveEquipo($claveEquipo){
		$this->claveEquipo = $claveEquipo;
	}

	public function getNombreEquipo(){
		return $this->nombreEquipo;
	}

	public function setNombreEquipo($nombreEquipo){
		$this->nombreEquipo = $nombreEquipo;
	}
}


?>