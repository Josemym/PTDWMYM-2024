<?php 

require_once 'class/respuestas.class.php';
require_once 'class/cuentas_cobrar.class.php';

$_respuestas = new respuestas;
$_cuentas_cobrar = new cuentas_cobrar;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET["all"])){
        $lista_ctas_cobrar = $_cuentas_cobrar->lista_ctas_cobrar();
        header("Content-Type: application/json");
        echo json_encode($lista_ctas_cobrar);
        http_response_code(200);
    }else if(isset($_GET['ctac_nro_documento'])){
        $ctac_nro_documento = $_GET['ctac_nro_documento'];
        $datos_cta_cobrar = $_cuentas_cobrar->obtener_cta_cobrar($ctac_nro_documento);
        header("Content-Type: application/json");
        echo json_encode($datos_cta_cobrar);
        http_response_code(200);
    }
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    // RECIBIMOS LOS DATOS ENVIADOS
    $post_body = file_get_contents("php://input");
    // ENVIAMOS LOS DATOS AL MANEJADOR
    $datos_array = $_cuentas_cobrar->put($post_body);
    // DEVOLVEMOS UNA RESPUESTA 
    header('Content-Type: application/json');
    if(isset($datos_array["result"]["error_id"])){
        $response_code = $datos_array["result"]["error_id"];
        http_response_code($response_code);
     }else{
        http_response_code(200);
     }
     echo json_encode($datos_array);
}else{
    header('Content-Type: application/json');
    $datos_array = $_respuestas->error_405();
    echo json_encode($datos_array);
}

?>