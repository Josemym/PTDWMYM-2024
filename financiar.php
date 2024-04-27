
<div  class="container">
    <h1>Api de M&M</h1>
    <div class="divbody">
        <h3>Facturas - Pendientes</h3>

        <?php
        require_once 'class/curl.class.php';
        require_once 'class/tablas.class.php';

        if(isset($_POST['btn_financiar'])){
            $nro_cuotas = $_POST['nro_cuotas'];
        
            $url = 'http://intranetdev.limabus.com.pe/mym/cuentas_cobrar?all';
            $_curl = new curl($url);
            $_tablas = new tablas;
            $response = $_curl->init()->setOption(CURLOPT_URL,$url)->setOption(CURLOPT_RETURNTRANSFER,true)->execute();
            $_curl->close();
        
            $cuentas_cobrar = json_decode($response,true);
            usort($cuentas_cobrar, function ($a, $b) {
                return strcmp($a["ctac_fecha_emision"], $b["ctac_fecha_emision"]);
            });
            $total_deuda = array_sum(array_column($cuentas_cobrar,'ctac_total'));
        
            $_tablas->ctas_cobrar($cuentas_cobrar);
            echo '<label>Monto Total a Financiar : '.$total_deuda.'</label><br>';
            echo '<label>Numero de Cuotas a Financiar : '.$nro_cuotas.'</label><br><br>';
        
            $ctaf_id_cliente = $cuentas_cobrar[0]['ctac_id_cliente'];
            $valor_cuota = $total_deuda/$nro_cuotas;
            $fecha_vencimiento = date("Y-m-d");
        
            for ($i=1; $i<=$nro_cuotas; $i++) {
                $fecha_vencimiento = date("Y-m-d",strtotime($fecha_vencimiento.' + 1 month'));
                $url = 'http://intranetdev.limabus.com.pe/mym/cuentas_financiamiento';
                $_curl = new curl($url);
                $array = [
                    'ctaf_nro_cuota'=>$i,
                    'ctaf_id_cliente'=>$ctaf_id_cliente,
                    'ctaf_total_cuota'=>$valor_cuota,
                    'ctaf_fecha_vencimiento'=>$fecha_vencimiento
                ];
                $response = $_curl->init()->setOption(CURLOPT_URL,$url)->setOption(CURLOPT_POST, true)->buildQuery($array)->setOption(CURLOPT_RETURNTRANSFER,true)->execute();
                $_curl->close();
            }
        
            $url = 'http://intranetdev.limabus.com.pe/mym/cuentas_financiamiento?all';
            $_curl = new curl($url);
            $response = $_curl->init()->setOption(CURLOPT_URL,$url)->setOption(CURLOPT_RETURNTRANSFER,true)->execute();
            $_curl->close();
        
            $cuentas_financiamiento = json_decode($response,true);
            usort($cuentas_financiamiento, function ($a, $b) {
                return strcmp($a["ctac_fecha_vencimiento"], $b["ctac_fecha_vencimiento"]);
            });
        
            $_tablas->ctas_financiamiento($cuentas_financiamiento);
        
        }
        ?>

        <form action="pagos.php" method="post">
            <label for="nro_cuota_pagar">Numero de Cuota a Pagar:</label>
            <input type="number" name="nro_cuota_pagar" id="nro_cuota_pagar" required>
            <input type="submit" name="btn_pagar" value="Pagar">
        </form>

    </div>      
</div>