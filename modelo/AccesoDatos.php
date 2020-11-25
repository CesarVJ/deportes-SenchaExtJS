<?php 
 error_reporting(E_ALL ^ E_NOTICE);
class AccesoDatos{
    private $conexion = null;
    function conectar(){
        $bandera = false;
        try{
            $this->conexion = new PDO("mysql:host=localhost:3307;dbname=deportes2","adminDeportes","deportes1",  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'")); 
            $bandera = true;
        }catch(Exception $error){
            throw $error;
        }
        return $bandera;
    }

    function desconectar(){
        $bandera = true;
        if($this->conexion != null){
            $this->conexion = null;
        }
        return $bandera;
    }

    function ejecutarConsulta($consulta){
        $arregloRes = null;
        $rst = null;
        $oLinea = null;
        $sValCol = "";
        $i = 0;
        $j = 0;
        if($consulta == ""){
            throw new Exception("No se indico ninguna consulta");
        }
        if($this->conexion == null){
            throw new Exception("Falta Establecer la conexion a la BD");
        }
        try{
            $rst = $this->conexion->query($consulta);
        }catch(Exception $error){
            throw $error;
        }
        if($rst){
            foreach($rst as $oLinea){
                foreach($oLinea as $llave=>$sValCol){
                    if(is_string($llave)){
                        $arregloRes[$i][$j] = $sValCol;
                        $j++;
                    }
                }
                $j= 0;
                $i ++;
            }   
        }
        return $arregloRes;
    }

    function ejecutarComando($comando){
        $numAfectados = -1;
        if($comando == ""){
            throw new Exception("Falta indicar el comando");   
        }
        if ($this->conexion == null){
            throw new Exception("Falta conexion a la BD");
        }
        try{
              $numAfectados =$this->conexion->exec($comando);
        }catch(Exception $error){
            throw $error;
        }
        return $numAfectados;

    }
}
?>