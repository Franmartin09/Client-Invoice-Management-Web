<div id="loading" style="text-align:center; position:fixed; width:100%; height:100%;top:0; bottom:0; background-color: rgba(255,255,255,0.85); z-index:9999; display:none;">
        <!-- <h1 style="margin-top:25vh; ">Loading...</h1> -->
        <img src="app/Views/templates/loading.gif" alt="Loading..." style="width:300px;margin-top:25vh;"> 
</div>

<form method="post" action="" name="invoice-form">
    <div style="text-align:right; margin-right:5%;margin-left:5%;width:90%;">
        <button type="submit" onclick=showLoading() name="crear" value="<?php if(isset($id_cliente)) echo $id_cliente; ?>" style="height:30px;width:100px" >+</button>
    </div>
</form>
    <table style="text-align:center;width: 90%; margin:0 auto; overflow-y: auto; max-height: 300px;">
        <thead style="background-color:gray; color:white;">
            <tr>
                <th>ID Factura</th>
                <th>Referencia</th>
                <th>Nº Factura</th>
                <th>Fecha</th>
                <th>Importe Neto</th>
                <th>IVA (%)</th>
                <th>Importe Total</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invo as $invoice) { ?>
                <form method="post" action="">
                    <tr style="background-color: lightblue;">
                        <td><?php echo $invoice->id_factura; ?></td>
                        <td><?php echo $invoice->reference; ?></td>
                        <td><?php echo $invoice->numero_factura; ?></td>
                        <td><?php echo $invoice->fecha; ?></td>
                        <td><?php echo $invoice->importe_neto; ?></td>
                        <td><?php echo $invoice->iva; ?></td>
                        <td><?php echo $invoice->importe_total; ?></td>
                        <td>
                                <button type="submit" name="imprimir" value="<?php echo $invoice->id_factura; ?>">Imprimir</button>
                                <button type="submit" onclick=showLoading() name="editar" value="<?php echo $invoice->id_factura; ?>">Editar</button>
                                <button type="submit" onclick=showLoading() name="eliminar" value="<?php echo $invoice->id_factura; ?>" style="background-color: red;">Eliminar</button>
                        </td>
                    </tr>
                </form>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <hr>
