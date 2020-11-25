<?php

include_once("modelo/ErroresAplic.php");
session_start(); 
$numeroError=-1;
$tipo=null;
$nombre="";

	/*Verificar que exista el objeto de sesión*/
	if (isset($_SESSION["sNomFirmado"])){
		$nombre = $_SESSION["sNomFirmado"];
		$tipo = $_SESSION["sTipoFirmado"];
		$claseRegistro = "menu_inhab";
		$claseLogin = "menu_inhab";
		if ($_SESSION["sTipoFirmado"]=="Administrador"){
			$clasePanelAdmin = "menu";
		}
	}else{
		$numeroError = ErroresAplic::SIN_SESION;;
	}
	if ($numeroError != -1){
		header("Location: error.php?error=".$numeroError);
		exit();
	}
	include_once("cabecera.html");
?>
		<script type="text/javascript" src="js/ctrlBienvenido.js"></script>
    </head>
    <body>
    </body>
</html>
