<div id="loading" style="text-align:center; position:fixed; width:100%; height:100%;top:0; bottom:0; background-color: rgba(255,255,255,0.85); z-index:9999; display:none;">
        <img src="app/Views/templates/loading.gif" alt="Loading..." style="width:300px;margin-top:25vh;"> 
</div>
<!--header-->
<form method="post" action="" name="signup-form">

    <!-- Cliente -->
    <div>
        <label>Cliente ID</label>
        <input type="text" name="cliente" pattern="[a-zA-Z0-9]+" value="<?echo $id_cliente?>" <?if ($id_cliente!="") echo "disabled"; ?>/>
        <!-- Boton comprobar Cliente -->
        <?if ($id_cliente==""){?> <button type="submit" onclick=showLoading() name="comprobar_cliente">Validar Cliente</button><?}?>
    </div>
    <div style="margin-top:10px">
    <!-- N Factura -->
        <label>Nº Factura </label>
        <input type="text" name="email" value='<?echo $n_factura;?>' disabled required/>

    <!-- Referencia -->
        <label>Referencia</label>
        <input type="text" name="phone" value="<?echo $reference;?>" disabled required />
    
    <!-- Fecha -->
        <label>Fecha</label>
        <input type="text" name="date" value='<? echo date("Y-m-d H:i:s");?>' disabled />
    </div>
    <!-- Botones -->
        <div style="text-align:right; margin-right:5%;margin-left:5%;width:90%;">
            <button type="submit" onclick=showLoading() name="añadir_item" style="height:40px;width:90px" >Añadir</button>
            <button type="submit" onclick=showLoading() name="guardar_factura" style="height:40px;width:90px" ><? if($editar!="") echo "Editar"; else echo "Guardar"?></button>
            <button type="submit" onclick=showLoading() name="cancelar_factura" value="<? if(isset($id_cliente)) echo $id_cliente?>" style="height:40px;width:90px" >Cancelar</button>
            <hr>
        </div>
</form>
<!--Detalles-->

<table style="text-align:center; width: 90%; margin:0 auto; overflow-y: auto; max-height: 300px;">
        <thead style="background-color:gray; color:white;">
            <tr>
                <th>ID_Iteam</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
        <?
            if($añadir!=""){
            ?>
            <tr>
            <!-- Crear Iteam-->
            <form method="post" action="">
                <td></td>
                <td>
                <input type="text" name="descripcion">
                </td>

                <td>
                <input type="text" name="precio">
                </td>

                <td>
                <input type="text" name="cantidad">
                </td>

                <td>
                <button type="submit" onclick=showLoading() name="item_added" type="submit">Crear</button>
                <button type="submit" onclick=showLoading() name="item_cancel" type="submit">Cancelar</button>    
                </td>

            </form>
            </tr>
            <?
            }
            ?>

            <?php if(isset($detalle)){
                 $total=0;
                foreach ($detalle as $detalles) { 
                    if($autocomplete=="" or  $autocomplete[0]->id_iteam!=$detalles->id_iteam){?>
            <form method="post" action="">
                <tr style="background-color: lightblue;">
                    <td><?php echo $detalles->id_iteam; ?></td>
                    <td><?php echo $detalles->overview; ?></td>
                    <td><?php echo $detalles->price; ?></td>
                    <td><?php echo $detalles->quantity; ?></td>
                    <td>
                        <button type="submit" name="editar_item" value="<?php echo $detalles->id_iteam; ?>" type="submit">Editar</button>
                        <button type="submit" name="eliminar_item" value="<?php echo $detalles->id_iteam; ?>" style="background-color: #EE4B2B;">Eliminar</button>
                    </td>
                </tr>
            </form>
            <?}else{
                    ?>
                    <tr>
                    <form method="post" action="">
                        <td>
                        <input type="text" name="iditem" value='<?php echo $autocomplete[0]->id_iteam;?>' disabled>
                        </td>
                        <td>
                        <input type="text" name="descripcion" value='<?php echo $autocomplete[0]->overview;?>'>
                        </td>
                        <td>
                        <input type="text" name="precio" value='<?php echo $autocomplete[0]->price;?>'>
                        </td>
                        <td>
                        <input type="text" name="cantidad" value='<?php echo $autocomplete[0]->quantity;?>'>
                        </td>
                        <td>
                            <button type="submit" name="edited_item" value="<?php echo $detalles->id_iteam; ?>">Guardar</button>
                            <button type="submit" name="edited_cancel" value="<?php echo $detalles->id_iteam; ?>">Cancelar</button>
                        </td>
                    </form>
                    </tr>
                    <?
                        }
                        $total=$total+($detalles->price*$detalles->quantity);}}
                    ?>
        </tbody>
</table>
<div style="text-align:center; width: 90%; margin:0 auto; overflow-y: auto; max-height: 300px;">
    <br>
    <hr>
</div>

<!-- TOTAL -->
<div style="text-align:right; margin-right:5%;margin-left:5%;width:90%;">
<?  if(isset($detalle)) echo  "Importe Total = " . $total . " €";
    else echo  "Importe Total = 0";
?>
   
</div>

