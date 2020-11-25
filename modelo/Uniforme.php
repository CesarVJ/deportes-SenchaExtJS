<?php
error_reporting(E_ALL);
include_once("Articulo.php");

class Uniforme extends Articulo {
	private $talla;

	public function buscar() {
		throw new Exception("Metodo no implementado");
	}

	public function buscarTodos() {
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$arrRet=array();
	$oUniforme;
		if ($oAccesoDatos->conectar()){
			$sQuery = "SELECT DISTINCT t1.claveArticulo, t1.nombre, t1.precio,
					          t1.imagen, t2.talla, t3.claveEquipo, t3.nombreEquipo
					   FROM Articulo t1
							JOIN Uniforme t2 ON t2.claveArticulo = t1.claveArticulo
							JOIN Equipo t3 ON t3.claveEquipo = t1.claveEquipo
					   ORDER BY t1.claveArticulo;
					";
			$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
			$oAccesoDatos->desconectar();
			if ($arrRS){
				$arrRet = array();
				foreach($arrRS as $arrLinea){
					$oUniforme = new Uniforme();
					$oUniforme->setOEquipo(new Equipo());
					$oUniforme->setClaveArticulo($arrLinea[0]);
					$oUniforme->setNombre($arrLinea[1]);
					$oUniforme->setPrecio($arrLinea[2]);
					$oUniforme->setImagen($arrLinea[3]);
					$oUniforme->setTalla($arrLinea[4]);
					$oUniforme->getOEquipo()->setClaveEquipo($arrLinea[5]);
					$oUniforme->getOEquipo()->setNombreEquipo($arrLinea[6]);
					$arrRet[] = $oUniforme;
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

	public function getTalla(){
		return $this->talla;
	}

	public function setTalla($talla){
		$this->talla = $talla;
	}
    
}
?>