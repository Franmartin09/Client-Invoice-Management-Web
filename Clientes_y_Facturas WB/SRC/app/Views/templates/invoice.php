<?php
//DATOS STP
$nombre_stp="Soluciones Tecnoprofesionales";
$direccion_stp="C/Tegnologia Ed. Canadà";
$poblacion_stp="08840 Viladecans";
$pais_stp="Catalunya, España";
//DATOS CLIENTE
$direccion_cliente = $cliente->addres;
$email_cliente= $cliente->email_cliente;
$nombre_cliente = $cliente->name_surname;
//DATOS FACTURA
$referencia_factura = $factura->reference;
$numero_factura= $factura->numero_factura;
$fecha_factura = $factura->fecha;
$porcentajeImpuestos = $factura->iva;
//APLICACIONES EXTRAS
$mensajePie = "Gracias por su compra";
$descuento = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Factura</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<div class="container-fluid">
    <div class="row">
        <div class="col-4 text-center" style="padding-top:30px;">
            <h1 class="display-1">Factura</h1>
        </div>
        <div class="col-4">
        </div>
        <div class="col-4 text-center" style="padding-bottom: 30px; padding-top: 40px;">
            <img src="https://intranet.stp.es/img/stp.png" alt="Logotipo" style="max-width:250px;">
        </div>
    </div>
    <hr>

    <div class="row" style="margin:20px;">
        <div class="col-1"></div>
        <div class="col-4">
            <h1 class="h3">Remitente</h1>
            <?php echo $nombre_stp ?><br>
            <?php echo $direccion_stp ?><br>
            <?php echo $poblacion_stp ?><br>
            <?php echo $pais_stp ?>
        </div>
        <div class="col-4">
            <h1 class="h3">Cliente</h1>
            <?php echo $nombre_cliente ?><br>
            <?php echo $email_cliente ?><br>
            <?php echo $direccion_cliente ?>
        </div>
        <div class="col-3">
            <strong>Fecha</strong><br>
            <?php echo $fecha_factura ?><br>
            <strong>Referencia</strong><br>
            <?php echo $referencia_factura ?><br>
            <strong>Factura No. : </strong>
            <?php echo $numero_factura ?>
        </div>
    </div>
    <hr>
    
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-condensed table-bordered table-striped">
                <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Precio unitario</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $subtotal = 0;
                foreach ($items as $producto) {
                    $totalProducto = $producto->quantity * $producto->price;
                    $subtotal += $totalProducto;
                    ?>
                    <tr>
                        <td><?php echo $producto->overview?></td>
                        <td><?php echo number_format($producto->price, 2) ?> €</td>
                        <td><?php echo number_format($producto->quantity, 2) ?></td>
                        <td><?php echo number_format($totalProducto, 2) ?> €</td>
                    </tr>
                <?php }
                $subtotalConDescuento = $subtotal - $descuento;
                $impuestos = $subtotalConDescuento * ($porcentajeImpuestos / 100);
                $total = $subtotalConDescuento + $impuestos;
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3" >Subtotal</td>
                    <td><?php echo number_format($subtotal, 2) ?> €</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">Descuento</td>
                    <td><?php echo number_format($descuento, 2) ?> €</td>
                </tr>
                <tr>
                    <td colspan="3" >Subtotal con descuento</td>
                    <td><?php echo number_format($subtotalConDescuento, 2) ?> €</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">Impuestos</td>
                    <td><?php echo number_format($impuestos, 2) ?> €</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">
                        <h4>Total</h4></td>
                    <td>
                        <h4><?php echo number_format($total, 2) ?> €</h4>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center">
            <p class="h5"><?php echo $mensajePie ?></p>
        </div>
    </div>
</div>
</body>
</html>