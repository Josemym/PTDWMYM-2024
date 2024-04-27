<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API - M&M</title>
    <link rel="stylesheet" href="assets/estilo.css" type="text/css">
</head>
<body>

<div  class="container">
    <h1>Api de M&M</h1>
    <div class="divbody">
        <h3>Facturas - Pendientes</h3>

        <?php
        
        require_once 'class/curl.class.php';
        require_once 'class/tablas.class.php';
        
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
        
        ?>

        <form action="financiar.php" method="post">
            <label for="nro_cuotas">Numero de Cuotas a Financiar:</label>
            <input type="number" name="nro_cuotas" id="ctac_nro_cuotas" required>
            <input type="submit" name="btn_financiar" value="Financiar">
        </form>
    </div>      
</div>
    
</body>
</html>