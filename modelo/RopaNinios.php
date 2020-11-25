<?php
error_reporting(E_ALL);
include_once("Articulo.php");

class RopaNinios extends Articulo {
    private $color;
    private $talla;


	public function buscar() {
		throw new Exception("Metodo no implementado");
	}

	public function buscarTodos() {
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$arrRet=array();
	$oRopaNinios;
		if ($oAccesoDatos->conectar()){
			$sQuery = "SELECT DISTINCT t1.claveArticulo, t1.nombre, t1.precio,
					          t1.imagen, t2.color, t2.talla, t3.claveEquipo, t3.nombreEquipo
					   FROM Articulo t1
							JOIN RopaNinios t2 ON t2.claveArticulo = t1.claveArticulo
							JOIN Equipo t3 ON t3.claveEquipo = t1.claveEquipo
					   ORDER BY t1.claveArticulo;
					";
			$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
			$oAccesoDatos->desconectar();
			if ($arrRS){
				$arrRet = array();
				foreach($arrRS as $arrLinea){
					$oRopaNinios = new RopaNinios();
					$oRopaNinios->setOEquipo(new Equipo());
					$oRopaNinios->setClaveArticulo($arrLinea[0]);
					$oRopaNinios->setNombre($arrLinea[1]);
					$oRopaNinios->setPrecio($arrLinea[2]);
					$oRopaNinios->setImagen($arrLinea[3]);
                    $oRopaNinios->setColor($arrLinea[4]);
                    $oRopaNinios->setTalla($arrLinea[5]);
					$oRopaNinios->getOEquipo()->setClaveEquipo($arrLinea[6]);
					$oRopaNinios->getOEquipo()->setNombreEquipo($arrLinea[7]);
					$arrRet[] = $oRopaNinios;
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
    
    public function getTalla(){
		return $this->talla;
	}

	public function setTalla($talla){
		$this->talla = $talla;
	}
    
}
?>