<?php

class conexion {
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $opciones;
    private $conexion;

    function __construct(){
        $lista_datos = $this->datos_conexion();
        foreach ($lista_datos as $key => $value) {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }
        $this->opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');			
        
        try{
            $this->conexion = new PDO("mysql:host=".$this->server."; port=".$this->port."; dbname=".$this->database, $this->user, $this->password, $this->opciones);			
            return $this->conexion;
        }catch(Exception $e){
            die("El error de Conexión es: ". $e->getMessage());
        }
    }

    private function datos_conexion(){
        $direccion = dirname(__FILE__);
        $json_data = file_get_contents($direccion . "/" . "config");
        return json_decode($json_data, true);
    }

    public function obtener_datos($sql_str){
        $results = $this->conexion->prepare($sql_str);
        $results->execute();        
        $data = $results->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function non_query($sql_str){
        $results = $this->conexion->prepare($sql_str);
        $results->execute();
        $count = $results->rowCount();
        return $count;
    }

    // INSERT 
    public function non_query_id($sql_str){
        $results = $this->conexion->prepare($sql_str);
        $results->execute();
        $filas = $results->rowCount();
        if($filas >= 1){
            $last_id = $this->conexion->lastInsertId();
            return $last_id;
        }else{
            return 0;
        }
    }

}

?>