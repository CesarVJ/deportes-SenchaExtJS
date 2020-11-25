<?php
error_reporting(E_ALL);
include_once("Articulo.php");

class Souvenir extends Articulo {
    private $color;
    private $descripcion;


	public function buscar() {
		throw new Exception("Metodo no implementado");
	}

	public function buscarTodos() {
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$arrRet=array();
	$oSouvenir;
		if ($oAccesoDatos->conectar()){
			$sQuery = "SELECT DISTINCT t1.claveArticulo, t1.nombre, t1.precio,
					          t1.imagen, t2.color, t2.descripcion, t3.claveEquipo, t3.nombreEquipo
					   FROM Articulo t1
							JOIN Souvenir t2 ON t2.claveArticulo = t1.claveArticulo
							JOIN Equipo t3 ON t3.claveEquipo = t1.claveEquipo
					   ORDER BY t1.claveArticulo;
					";
			$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
			$oAccesoDatos->desconectar();
			if ($arrRS){
				$arrRet = array();
				foreach($arrRS as $arrLinea){
					$oSouvenir = new Souvenir();
					$oSouvenir->setOEquipo(new Equipo());
					$oSouvenir->setClaveArticulo($arrLinea[0]);
					$oSouvenir->setNombre($arrLinea[1]);
					$oSouvenir->setPrecio($arrLinea[2]);
					$oSouvenir->setImagen($arrLinea[3]);
                    $oSouvenir->setColor($arrLinea[4]);
                    $oSouvenir->setDescripcion($arrLinea[5]);
					$oSouvenir->getOEquipo()->setClaveEquipo($arrLinea[6]);
					$oSouvenir->getOEquipo()->setNombreEquipo($arrLinea[7]);
					$arrRet[] = $oSouvenir;
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
    
    public function getDescripcion(){
		return $this->descripcion;
	}

	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}
    
}
?>