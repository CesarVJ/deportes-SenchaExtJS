<?php
include_once("../modelo/Administrador.php");
include_once("../modelo/Cliente.php");
include_once("../modelo/ErroresAplic.php");

session_start();
$nErr="";
$oUsuario=new Cliente();
$sCadJson = "";
$nombre="";

if (isset($_REQUEST["claveUsr"]) && !empty($_REQUEST["claveUsr"]) &&
		isset($_REQUEST["txtPwd"]) && !empty($_REQUEST["txtPwd"])){
		try{
            $oUsuario->setClaveUsuario($_REQUEST["claveUsr"]);
            $oUsuario->setContrasenia($_REQUEST["txtPwd"]);
            if($oUsuario->buscarPorClave()){
                $_SESSION["sNomFirmado"] = $oUsuario->getNombreCompleto();
				$_SESSION["sTipoFirmado"] = "Cliente";
            }else{
                $oUsuario = new Administrador();
				$oUsuario->setClaveUsuario($_REQUEST["claveUsr"]);
				$oUsuario->setContrasenia($_REQUEST["txtPwd"]);
				if ($oUsuario->buscarPorClave()){
					$_SESSION["sNomFirmado"] = $oUsuario->getNombreAdmin();
					$_SESSION["sTipoFirmado"] = "Administrador";
				}else 
                $nErr = ErroresAplic::USR_DESCONOCIDO;
            }
        }catch(Exception $error){
            error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
            $nErr = ErroresAplic::ERROR_EN_BD;
        }
}else{
    $nErr = ErroresAplic::FALTAN_DATOS;
}

if ($nErr==""){
    $sCadJson = '{
        "success": true,
        "status": "ok",
        "data":{
            "nombre":"'.$_SESSION["sNomFirmado"].'",
            "tipo":"'.$_SESSION["sTipoFirmado"].'"
        }
    }';
}else{
    $oErr = new ErroresAplic();
    $oErr->setError($nErr);
    $sCadJson = '{
        "success": false,
        "status": "'.$oErr->getTextoError().'",
        "data":{}
    }';
}
header('Content-type: application/json');
echo $sCadJson;



?>