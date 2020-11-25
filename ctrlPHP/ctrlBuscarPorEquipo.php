<?php 
session_start();
include_once("../modelo/Uniforme.php");
include_once("../modelo/Balon.php");
include_once("../modelo/Souvenir.php");
include_once("../modelo/RopaNinios.php");
include_once("../modelo/ErroresAplic.php");

$nErr=-1;
$oArt;
$oUniforme;
$oBalon;
$oSouvenir;
$oRopaNinios;
$arrEncontrado = array();

$arrUniformes = array();
$arrBalones = array();
$arrSouvenirs = array();
$arrRopaNinios = array();
$numLineas = 4;
$sCadJson = "";
$firmado = 0;

if (isset($_REQUEST["equipo"])&&!empty($_REQUEST["equipo"])){
    try{
            $oUniforme = new Uniforme();
            $arrUniformes = $oUniforme->buscarTodos();

            $oBalon = new Balon();
            $arrBalones = $oBalon->buscarTodos();

            $oSouvenir = new Souvenir();
            $arrSouvenirs = $oSouvenir->buscarTodos();

            $oRopaNinios = new RopaNinios();
            $arrRopaNinios = $oRopaNinios->buscarTodos();             
            //$arrEncontrado = array_merge($arrUniformes,$arrBalones, $arrSouvenirs, $arrRopaNinios);        
        if (isset($_SESSION["sTipoFirmado"])){
            $firmado = 1;
        }
    }catch(Exception $e){
        error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
        $nErr = ErroresAplic::ERROR_EN_BD;
    }
}else{
    $nErr = ErroresAplic::FALTAN_DATOS;	
}
if ($nErr==-1){
    $sCadJson = '{
        "success": true,
        "status": "ok",
        "sesion": '.$firmado.',
        "data":[';
    foreach($arrUniformes as $oUnif){
        $claveEquipo = $oUnif->getOEquipo()->getClaveEquipo(); 
        $equipoActual = $oUnif->getOEquipo()->getNombreEquipo();               
        if($claveEquipo == $_REQUEST["equipo"]){
            $arrCaract = "[]";
            $arrCaract = '["Tallas: '. $oUnif->getTalla().'"]';
            $sCadJson = $sCadJson.'{
                        "claveArticulo": '.$oUnif->getClaveArticulo().',
                        "nombreArticulo": "'.$oUnif->getNombre().'",
                        "imagen": "'.$oUnif->getImagen().'",
                        "equipo": "'.$equipoActual.'",
                        "precio": '.$oUnif->getPrecio().',
                        "caracteristicas": '.$arrCaract.'
                    },';
        }
    }
    foreach($arrBalones as $oBalon){
        $claveEquipo = $oBalon->getOEquipo()->getClaveEquipo();    
        $equipoActual = $oBalon->getOEquipo()->getNombreEquipo();            
        if($claveEquipo == $_REQUEST["equipo"]){
        $arrCaract = "[]";
        $arrCaract = '["Color: '. $oBalon->getColor().'"]';
        $sCadJson = $sCadJson.'{
                        "claveArticulo": '.$oBalon->getClaveArticulo().',
                        "nombreArticulo": "'.$oBalon->getNombre().'",
                        "imagen": "'.$oBalon->getImagen().'",
                        "equipo": "'.$equipoActual.'",
                        "precio": '.$oBalon->getPrecio().',
                        "caracteristicas": '.$arrCaract.'
                    },';
        }
    }

    foreach($arrSouvenirs as $oSouvenir){
        $claveEquipo = $oSouvenir->getOEquipo()->getClaveEquipo(); 
        $equipoActual = $oSouvenir->getOEquipo()->getNombreEquipo();        
       
        if($claveEquipo == $_REQUEST["equipo"]){
        $arrCaract = "[]";
        $arrCaract = '["Color:'. $oSouvenir->getColor().'","  Descripción:'.$oSouvenir->getDescripcion().'"]';
        $sCadJson = $sCadJson.'{
                        "claveArticulo": '.$oSouvenir->getClaveArticulo().',
                        "nombreArticulo": "'.$oSouvenir->getNombre().'",
                        "imagen": "'.$oSouvenir->getImagen().'",
                        "equipo": "'.$equipoActual.'",
                        "precio": '.$oSouvenir->getPrecio().',
                        "caracteristicas": '.$arrCaract.'
                    },';
        }
    }

    foreach($arrRopaNinios as $oRopaNinio){
        $claveEquipo = $oRopaNinio->getOEquipo()->getClaveEquipo(); 
        $equipoActual = $oRopaNinio->getOEquipo()->getNombreEquipo();               
        if($claveEquipo == $_REQUEST["equipo"]){
        $arrCaract = "[]";
        $arrCaract = '["Talla:'. $oRopaNinio->getTalla().'","  Color:'.$oRopaNinio->getColor().'"]';
        $sCadJson = $sCadJson.'{
                        "claveArticulo": '.$oRopaNinio->getClaveArticulo().',
                        "nombreArticulo": "'.$oRopaNinio->getNombre().'",
                        "imagen": "'.$oRopaNinio->getImagen().'",
                        "equipo": "'.$equipoActual.'",
                        "precio": '.$oRopaNinio->getPrecio().',
                        "caracteristicas": '.$arrCaract.'
                    },';
        }
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