<?php 
session_start();
include_once("../modelo/Uniforme.php");
include_once("../modelo/Balon.php");
include_once("../modelo/Souvenir.php");
include_once("../modelo/RopaNinios.php");


$nErr=-1;
$oArt;
$arrEncontrado = array();
$sCadJson = "";
$firmado = 0;

if (isset($_REQUEST["linea"])&&!empty($_REQUEST["linea"])){
    try{
        if ($_REQUEST["linea"]=='U'){
            $oArt = new Uniforme();
            $arrEncontrado = $oArt->buscarTodos();
        } else if ($_REQUEST["linea"]=='B'){
            $oArt = new Balon();
            $arrEncontrado = $oArt->buscarTodos();
        }else if($_REQUEST["linea"]=='S'){
            $oArt = new Souvenir();
            $arrEncontrado = $oArt->buscarTodos();
        }else if($_REQUEST["linea"]=='R'){
            $oArt = new RopaNinios();
            $arrEncontrado = $oArt->buscarTodos();            
        }else {
            error_log($error->getFile()." ".$error->getLine()." ".$error->getMessage(), 0);
        }
        if (isset($_SESSION["sTipoFirmado"])){
            $firmado = 1;
        }
    }catch(Exception $e){
        error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
        //$nErr = ErroresAplic::ERROR_EN_BD;
    }
}else{
   //Error 
}
    //$nErr = ErroresAplic::FALTAN_DATOS;	
if ($nErr==-1){
    $sCadJson = '{
        "success": true,
        "status": "ok",
        "sesion": '.$firmado.',
        "data":[';
    foreach($arrEncontrado as $oArt){
        $arrCaract = "[]";
        if($_REQUEST["linea"]=='U'){
            $arrCaract = '["Tallas: '. $oArt->getTalla().'"]';
        }else if($_REQUEST["linea"]=='B'){
            $arrCaract = '["Color: '. $oArt->getColor().'"]';
        }else if($_REQUEST["linea"]=='S'){
            $arrCaract = '["Color:'. $oArt->getColor().'","  Descripción:'.$oArt->getDescripcion().'"]';
        }else if($_REQUEST["linea"]=='R'){
            $arrCaract = '["Talla:'. $oArt->getTalla().'","  Color:'.$oArt->getColor().'"]';
        }
        $sCadJson = $sCadJson.'{
                        "claveArticulo": '.$oArt->getClaveArticulo().',
                        "nombreArticulo": "'.$oArt->getNombre().'",
                        "imagen": "'.$oArt->getImagen().'",
                        "equipo": "'.$oArt->getOEquipo()->getNombreEquipo().'",
                        "precio": '.$oArt->getPrecio().',
                        "caracteristicas": '.$arrCaract.'
                    },';
    }
    $sCadJson = substr($sCadJson,0, strlen($sCadJson)-1);
    $sCadJson =$sCadJson.'
        ]
    }';
}
else{
    //$oErr = new ErroresAplic();
    //$oErr->setError($nErr);
    $sCadJson = '{
        "success": false,
        "status": " ",
        "data":[]
    }'; // status: '.$oErr->getTextoError().'
}
header('Content-type: application/json');
echo $sCadJson;


?>