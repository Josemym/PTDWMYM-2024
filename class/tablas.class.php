<?php
class tablas{
    public function ctas_cobrar(array $array, $ctac_total_general, $ctac_total_saldo)
    {
        echo '<table border>
                    <td>Id</td>
                    <td>Nro.Documento</td>
                    <td>Tipo</td>
                    <td>Fecha</td>
                    <td>Total</td>
                    <td>Saldo</td>
                    <td>Cliente</td>';
            
        foreach ($array as $row){
            echo '  <tr>
                        <td>'.$row['id_cuentas_cobrar'].'</td>
                        <td>'.$row['ctac_nro_documento'].'</td>
                        <td>'.$row['ctac_tipo_documento'].'</td>
                        <td>'.$row['ctac_fecha_emision'].'</td>
                        <td>'.$row['ctac_total'].'</td>
                        <td>'.$row['ctac_saldo'].'</td>
                        <td>'.$row['ctac_id_cliente'].'</td>
                    </tr>';
        }
        echo '  <tr>
                    <td></td>
                    <td>Importe Total</td>
                    <td></td>
                    <td></td>
                    <td>'.$ctac_total_general.'</td>
                    <td>'.$ctac_total_saldo.'</td>
                    <td></td>
                </tr>
        ';
        echo '</table>';
        
        echo '<br>';
    }

    public function ctas_financiamiento(array $array)
    {
        echo '<table border>
                <td>Id</td>
                <td>Id Cliente</td>
                <td>Nro. Cuota</td>
                <td>Valor Cuota</td>
                <td>Fecha de Vencimiento</td>
                <td>Fecha de Pago</td>';
        
        foreach ($array as $row){
            echo '  <tr>
                        <td>'.$row['id_cuentas_financiamiento'].'</td>
                        <td>'.$row['ctaf_id_cliente'].'</td>
                        <td>'.$row['ctaf_nro_cuota'].'</td>
                        <td>'.$row['ctaf_total_cuota'].'</td>
                        <td>'.$row['ctaf_fecha_vencimiento'].'</td>
                        <td>'.$row['ctaf_fecha_pago'].'</td>
                    </tr>';
        }
        echo '</table>';
        echo '<br>';
    }
}
?>