<?php 

require_once 'class/respuestas.class.php';
require_once 'class/cuentas_financiamiento.class.php';

$_respuestas = new respuestas;
$_cuentas_financiamiento = new cuentas_financiamiento;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET["all"])){
        $lista_ctas_financiamiento = $_cuentas_financiamiento->lista_ctas_financiamiento();
        header("Content-Type: application/json");
        echo json_encode($lista_ctas_financiamiento);
        http_response_code(200);
    }else if(isset($_GET['ctaf_nro_cuota'])){
        $ctaf_nro_cuota = $_GET['ctaf_nro_cuota'];
        $datos_cta_financiamiento = $_cuentas_financiamiento->obtener_cta_financiamiento($ctaf_nro_cuota);
        header("Content-Type: application/json");
        echo json_encode($datos_cta_financiamiento);
        http_response_code(200);
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){ 
    // RECIBIMOS LOS DATOS ENVIADOS
    $post_body = file_get_contents("php://input");
    // ENVIAMOS LOS DATOS AL MANEJADOR
    $datos_array = $_cuentas_financiamiento->post($post_body);
    // DEVOLVEMOS UNA RESPUESTA 
     header('Content-Type: application/json');
     if(isset($datos_array["result"]["error_id"])){
        $response_code = $datos_array["result"]["error_id"];
        http_response_code($response_code);
     }else{
        http_response_code(200);
     }
     echo json_encode($datos_array);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    // RECIBIMOS LOS DATOS ENVIADOS
    $post_body = file_get_contents("php://input");
    // ENVIAMOS LOS DATOS AL MANEJADOR
    $datos_array = $_cuentas_financiamiento->put($post_body);
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