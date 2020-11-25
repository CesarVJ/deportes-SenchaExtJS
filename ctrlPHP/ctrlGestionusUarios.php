<?php

include_once("../modelo/Cliente.php");
include_once("../modelo/ErroresAplic.php");
session_start();
$sCadJson="";
$sErr=""; $sOpe = ""; 
$nCve = -1;
$oClte = new Cliente();
$nErr=-1;

	if (isset($_REQUEST["claveUsr"]) && !empty($_REQUEST["claveUsr"])){

		//$sOpe = $_REQUEST["txtOpe"];
		$nCve = $_REQUEST["claveUsr"];
		$oClte->setClaveUsuario($nCve);
		
		$oClte->setNombreCompleto($_REQUEST["nombreCompleto"]);
		$oClte->setTelefonoCasa($_REQUEST["numTelefono"]);
		$oClte->setDireccion($_REQUEST["direccion"]);
		$oClte->setCorreo($_REQUEST["correo"]);
		$oClte->setContrasenia($_REQUEST["clave1"]);
		
		//error_log($oClte->getNombreCompleto(),0);
		///error_log($oClte->getTelefonoCasa(),0);
		//error_log($oClte->getDireccion(),0);
		//error_log($oClte->getCorreo(),0);
		//error_log($oClte->getContrasenia(),0);

		try{
			$nResultado = $oClte->insertar();
			if ($nResultado < 1){
				$nErr = ErroresAplic::ERROR_GUARDAR;
			}
			$clave = $oClte->buscarUltimaClv()[0][0];			
		}catch(Exception $e){
			error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
			$nErr = ErroresAplic::ERROR_EN_BD;
		}
	}
	else{
		$nErr = ErroresAplic::FALTAN_DATOS;
	}
	
	if ($nErr == -1)
		$sCadJson = 
		'{
			"success":true,
			"status": "ok",
			"data": {
				"claveUsr":"'.$clave.'"
			}
		}';
	else{
		$oErr = new ErroresAplic();
		$oErr->setError($nErr);
		$sCadJson = 
		'{
			"success":false,
			"status": "'.$oErr->getTextoError().'",
			"data": {}
		}';
	}
	header('Content-type: application/json');
	echo $sCadJson;
?>