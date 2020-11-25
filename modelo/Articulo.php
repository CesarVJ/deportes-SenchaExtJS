<?php

include_once("Equipo.php");
abstract class Articulo{
    protected $ClaveArticulo;
    protected $nombre;
	protected $precio;
	protected $imagen;
    protected $oEquipo;

    public abstract function buscar();

    public abstract function buscarTodos();

	public abstract function insertar();

	public abstract function modificar();

    public abstract function eliminar();


    public function getClaveArticulo(){
		return $this->ClaveArticulo;
	}

	public function setClaveArticulo($ClaveArticulo){
		$this->ClaveArticulo = $ClaveArticulo;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function getPrecio(){
		return $this->precio;
	}

	public function setPrecio($precio){
		$this->precio = $precio;
	}

	public function getOEquipo(){
		return $this->oEquipo;
	}

	public function setOEquipo($oEquipo){
		$this->oEquipo = $oEquipo;
	}

	public function getImagen(){
		return $this->imagen;
	}

	public function setImagen($imagen){
		$this->imagen = $imagen;
	}



}

?>