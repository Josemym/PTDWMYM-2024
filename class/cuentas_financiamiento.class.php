<?php 

require_once "conexion/conexion.class.php";
require_once "respuestas.class.php";

class cuentas_financiamiento extends conexion {

    private $table = "cuentas_financiamiento";
    private $id_cuentas_financiamiento = "";
    private $ctaf_fecha_pago = "";
    private $ctaf_fecha_vencimiento = "";
    private $ctaf_total_cuota = "";
    private $ctaf_nro_cuota = "";
    private $ctaf_id_cliente = "";

    public function lista_ctas_financiamiento(){
        $query = "  SELECT  * FROM " . $this->table;
        $datos = parent::obtener_datos($query);
        return ($datos);
    }

    public function obtener_cta_financiamiento($ctaf_nro_cuota){
        $query = "SELECT * FROM " . $this->table . " WHERE `ctaf_nro_cuota` = '$ctaf_nro_cuota'";
        return parent::obtener_datos($query);
    }
    
    public function post($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['ctaf_nro_cuota'])){
            return $_respuestas->error_401();
        }else{
            $this->ctaf_nro_cuota = $datos['ctaf_nro_cuota'];
            $this->ctaf_id_cliente = $datos['ctaf_id_cliente'];
            $this->ctaf_total_cuota = $datos['ctaf_total_cuota'];
            $this->ctaf_fecha_vencimiento = $datos['ctaf_fecha_vencimiento'];
            $resp = $this->insertar_ctas_financiamiento();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_cuentas_financiamiento" => $resp
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }
    }

    private function insertar_ctas_financiamiento(){
        $query = " INSERT INTO " . $this->table . " ( `ctaf_id_cliente`, `ctaf_nro_cuota`, `ctaf_total_cuota`, `ctaf_fecha_vencimiento` ) VALUES ('" . $this->ctaf_id_cliente . "','" . $this->ctaf_nro_cuota ."','" . $this->ctaf_total_cuota . "','"  . $this->ctaf_fecha_vencimiento . "')";
        $resp = parent::non_query_id($query);
        if($resp){
             return $resp;
        }else{
            return 0;
        }
    }

    public function put($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['ctaf_nro_cuota'])){
            return $_respuestas->error_401();
        }else{
            $this->ctaf_nro_cuota = $datos['ctaf_nro_cuota'];
            $this->ctaf_fecha_pago = $datos['ctaf_fecha_pago'];
            $resp = $this->modificar_ctas_financiamiento();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "ctaf_nro_cuota" => $this->ctaf_nro_cuota
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }
    }
 
    private function modificar_ctas_financiamiento(){
        $query = " UPDATE " . $this->table . " SET `ctaf_fecha_pago` ='" . $this->ctaf_fecha_pago . "' WHERE `ctaf_nro_cuota` = '" . $this->ctaf_nro_cuota . "'"; 
        $resp = parent::non_query($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }
}

?>