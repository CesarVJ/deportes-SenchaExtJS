<?php
error_reporting(E_ALL);
include_once("Articulo.php");

class Balon extends Articulo {
	private $color;

	public function buscar() {
		throw new Exception("Metodo no implementado");
	}

	public function buscarTodos() {
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$arrRet=array();
	$oBalon;
		if ($oAccesoDatos->conectar()){
			$sQuery = "SELECT t1.claveArticulo, t1.nombre, t1.precio,
					          t1.imagen, t2.color
					   FROM Articulo t1
							JOIN Balon t2 ON t2.claveArticulo = t1.claveArticulo
					   ORDER BY t1.claveArticulo;
					";
			$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
			$oAccesoDatos->desconectar();
			if ($arrRS){
				$arrRet = array();
				foreach($arrRS as $arrLinea){
					$oBalon = new Balon();
					$oBalon->setOEquipo(new Equipo());
					$oBalon->setClaveArticulo($arrLinea[0]);
					$oBalon->setNombre($arrLinea[1]);
					$oBalon->setPrecio($arrLinea[2]);
					$oBalon->setImagen($arrLinea[3]);
					$oBalon->setColor($arrLinea[4]);
					$oBalon->getOEquipo()->setClaveEquipo(0);
					$oBalon->getOEquipo()->setNombreEquipo("Sin equipo");
					$arrRet[] = $oBalon;
				}
			}
		} 
		return $arrRet;
	}

	public function insertar() {
		throw new Exception("No implementado");
	}

	public function modificar() {
		throw new Exception("No implementado");
	}

	public function eliminar() {
		throw new Exception("No implementado");
	}

	public function getColor(){
		return $this->color;
	}

	public function setColor($color){
		$this->color = $color;
	}
    
}
?>