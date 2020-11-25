<?php

include_once("../modelo/Equipo.php");
//include_once("../modelo/ErroresAplic.php");
$numError = -1;
$equipo;
$arrayEncontrado = array();
$cadenaJSON = "";

try{
    $equipo = new Equipo();
    $arrayEncontrado = $equipo->buscarTodos();
}catch(Exception $error){

    error_log($error->getFile()." ".$error->getLine()." ".$error->getMessage(), 0);
    //$numError = ErroresAplic::ERROR_EN_BD;
}

if($numError == -1){
    $cadenaJSON = '{
        "success": true,
        "status": "ok",
        "data": [';
        foreach($arrayEncontrado as $equipo){            
            $cadenaJSON = $cadenaJSON.'{
                                "claveEquipo": '.$equipo->getClaveEquipo().',
                                "nombreEquipo": "'.$equipo->getNombreEquipo().'"
                            },';            
        }
        $cadenaJSON = substr($cadenaJSON, 0, strlen($cadenaJSON)-1);
        $cadenaJSON = $cadenaJSON.'
        ]
    }';
}else{
    //$oError = new ErroresAplic();
    //$oError->setError($numError);
    $sCadJson = '{
        "success": false,
        "status": "",
        "data":[]
    }';// '.$oError->getTextoError().' va en status
}
header("Content-type: application/json");
echo $cadenaJSON;

?>