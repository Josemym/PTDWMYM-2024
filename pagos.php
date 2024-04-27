<div  class="container">
    <h1>Api de M&M</h1>
    <div class="divbody">
        <h3>Facturas - Pendientes</h3>

        <?php
        require_once 'class/curl.class.php';
        require_once 'class/tablas.class.php';

        if(isset($_POST['btn_pagar'])){
            $nro_cuota_pagar = $_POST['nro_cuota_pagar'];
        
            $url = 'http://intranetdev.limabus.com.pe/mym/cuentas_financiamiento?ctaf_nro_cuota='.$nro_cuota_pagar;
            $_curl = new curl($url);
            $_tablas = new tablas;
            $response = $_curl->init()->setOption(CURLOPT_URL,$url)->setOption(CURLOPT_RETURNTRANSFER,true)->execute();
            $_curl->close();
        
            $cuentas_financiamiento = json_decode($response,true);
            $ctaf_nro_cuota = $cuentas_financiamiento[0]['ctaf_nro_cuota'];
            $ctaf_total_cuota = $cuentas_financiamiento[0]['ctaf_total_cuota'];
            
            $url = 'http://intranetdev.limabus.com.pe/mym/cuentas_cobrar?all';
            $_curl = new curl($url);
            $response = $_curl->init()->setOption(CURLOPT_URL,$url)->setOption(CURLOPT_RETURNTRANSFER,true)->execute();
            $_curl->close();

            $cuentas_cobrar = json_decode($response,true);
            usort($cuentas_cobrar, function ($a, $b) {
                return strcmp($a["ctac_fecha_emision"], $b["ctac_fecha_emision"]);
            });
                    
            foreach ($cuentas_cobrar as $row){
                if ($row["ctac_saldo"]>0 && $ctaf_total_cuota>0){
                    if ($row["ctac_saldo"]<=$ctaf_total_cuota){
                        $ctac_saldo = 0;
                        $ctaf_total_cuota = $ctaf_total_cuota - $row["ctac_saldo"];
                    }else{
                        $ctac_saldo = $row['ctac_saldo'] - $ctaf_total_cuota;
                        $ctaf_total_cuota = 0;
                    }
                    $url = 'http://intranetdev.limabus.com.pe/mym/cuentas_cobrar';
                    $array = [
                        'ctac_nro_documento'=>$row['ctac_nro_documento'],
                        'ctac_saldo'=>$ctac_saldo,
                    ];
                    $response = $_curl->init()->setOption(CURLOPT_URL,$url)->setOption(CURLOPT_CUSTOMREQUEST, 'PUT')->buildQuery($array)->setOption(CURLOPT_RETURNTRANSFER,true)->execute();
                    $_curl->close();
                }
            }
                
            $ctaf_fecha_pago = date('Y-m-d');
            $url = 'http://intranetdev.limabus.com.pe/mym/cuentas_financiamiento';
            $array = [
                'ctaf_nro_cuota'=>$nro_cuota_pagar,
                'ctaf_fecha_pago'=>$ctaf_fecha_pago,
            ];
            $response = $_curl->init()->setOption(CURLOPT_URL,$url)->setOption(CURLOPT_CUSTOMREQUEST, 'PUT')->buildQuery($array)->setOption(CURLOPT_RETURNTRANSFER,true)->execute();
            $_curl->close();

            $url = 'http://intranetdev.limabus.com.pe/mym/cuentas_cobrar?all';
            $response = $_curl->init()->setOption(CURLOPT_URL,$url)->setOption(CURLOPT_RETURNTRANSFER,true)->execute();
            $_curl->close();
        
            $cuentas_cobrar = json_decode($response,true);
            usort($cuentas_cobrar, function ($a, $b) {
                return strcmp($a["ctac_fecha_emision"], $b["ctac_fecha_emision"]);
            });
            $_tablas->ctas_cobrar($cuentas_cobrar);

            $url = 'http://intranetdev.limabus.com.pe/mym/cuentas_financiamiento?all';
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