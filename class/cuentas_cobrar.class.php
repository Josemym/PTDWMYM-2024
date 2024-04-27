<?php 

require_once "conexion/conexion.class.php";
require_once "respuestas.class.php";

class cuentas_cobrar extends conexion {

    private $table = "cuentas_cobrar";
    private $id_cuentas_cobrar = "";
    private $ctac_nro_documento = "";
    private $ctac_tipo_documento = "";
    private $ctac_fecha_emision = "";
    private $ctac_total = "";
    private $ctac_saldo = "";
    private $ctac_id_cliente = "";

    public function lista_ctas_cobrar(){
        $query = "  SELECT  * FROM " . $this->table;
        $datos = parent::obtener_datos($query);
        return ($datos);
    }

    public function obtener_cta_cobrar($ctac_nro_documento){
        $query = "SELECT * FROM " . $this->table . " WHERE `ctac_nro_documento` = '$ctac_nro_documento'";
        return parent::obtener_datos($query);
    }
    
    public function put($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['ctac_nro_documento'])){
            return $_respuestas->error_401();
        }else{
            $this->ctac_nro_documento = $datos['ctac_nro_documento'];
            $this->ctac_saldo = $datos['ctac_saldo'];
            $resp = $this->modificar_ctas_cobrar();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "ctac_nro_documento" => $this->ctac_nro_documento
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }
    }
 
    private function modificar_ctas_cobrar(){
        $query = " UPDATE " . $this->table . " SET `ctac_saldo` ='" . $this->ctac_saldo . "' WHERE `ctac_nro_documento` = '" . $this->ctac_nro_documento . "'"; 
        $resp = parent::non_query($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }
}

?>