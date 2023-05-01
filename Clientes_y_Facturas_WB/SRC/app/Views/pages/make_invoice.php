<div id="loading" style="text-align:center; position:fixed; width:100%; height:100%;top:0; bottom:0; background-color: rgba(255,255,255,0.85); z-index:9999; display:none;">
        <img src="app/Views/templates/loading.gif" alt="Loading..." style="width:300px;margin-top:25vh;"> 
</div>
<!--header-->
<div  style="margin-right:5%;margin-left:5%;">
<form method="post" action="" name="signup-form">
    <div class="" style="margin-top:10px">
    <!-- N Factura -->
        <label>Nº Factura:&emsp;</label>
        <span><?echo $n_factura;?></span><br>
    <!-- Referencia -->
        <label>Referencia:&emsp;</label>
        <span><?echo $reference;?></span><br>
    <!-- Fecha -->
        <label>Fecha:&emsp;&emsp;&emsp;</label>
        <span><?echo date("Y-m-d H:i:s")?></span>
    </div>
        <!-- Cliente -->
    <div class="">
        <label>ID Cliente:&emsp;&nbsp;</label>
        <?if($id_cliente!=""){?>
            <span><?echo $id_cliente?></span>
        <?}else{?>
            <input type="text" name="cliente" pattern="[a-zA-Z0-9]+" value="<?echo $id_cliente?>" <?if ($id_cliente!="") echo "disabled"; ?>/>
        <?}?>
        <!-- Boton comprobar Cliente -->
        <?if ($id_cliente==""){?> <button  class="btn btn-outline-warning" style="width:fit-content;"type="submit" onclick=showLoading() name="comprobar_cliente"><i class="bi bi-check2-circle"></i></button><?}?>
    </div>
    <!-- Botones -->
        <div class="mb-1 mt-0 text-end w-90">
            <button class="btn btn-secondary" type="submit" onclick=showLoading() name="añadir_item" style="height:40px; width:90px" ><i class="bi bi-plus-square-dotted"></i></button>
            <button class="btn btn-success" type="submit" onclick=showLoading() name="guardar_factura" style="height:40px;width:90px" ><? if($editar!="") echo "Editar"; else echo "Guardar"?></button>
            <button class="btn btn-danger"  type="submit" onclick=showLoading() name="cancelar_factura" value="<? if(isset($id_cliente)) echo $id_cliente?>" style="width:90px" >Cancelar</button>
        </div>
</form>
</div>
<!--Detalles-->

<div class="mx-auto" style="width:90%; overflow-y: auto; max-height: 520px;">
    <table class="table table-condensed table-striped table-hover text-center" >
        <thead style="background-color:#712cf9; color:white;">
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
                <td><input type="text" name="descripcion"></td>
                <td><input type="text" name="precio"></td>
                <td><input type="text" name="cantidad"></td>
                <td>
                    <button type="submit"  class="border-0 bg-transparent h6 me-3 mt-1"  onclick=showLoading() name="item_added" style="color: #198754;"><i class="fas fa-save"></i></button>
                    <button type="submit"  class="border-0 bg-transparent h6" onclick=showLoading() name="item_cancel" type="submit" style="color: #EE4B2B;"><i class="bi bi-x-lg"></i></button>    
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
                <tr>
                    <td><?php echo $detalles->id_iteam; ?></td>
                    <td><?php echo $detalles->overview; ?></td>
                    <td><?php echo $detalles->price; ?></td>
                    <td><?php echo $detalles->quantity; ?></td>
                    <td>
                        <button type="submit"   class="border-0 bg-transparent me-3" onclick=showLoading() name="editar_item" value="<?php echo $detalles->id_iteam; ?>" type="submit"><i class="bi bi-pencil"></i></button>
                        <button type="submit"  class="border-0 bg-transparent" onclick=showLoading() name="eliminar_item" value="<?php echo $detalles->id_iteam; ?>" style="color: #EE4B2B;"><i class="bi bi-trash3"></i></button>
                    </td>
                </tr>
            </form>
            <?}else{
                    ?>
                    <tr>
                    <form method="post" action="">
                        <td><span style="max-width: 50px;"><? echo $autocomplete[0]->id_iteam;?></span></td>
                        <td><input type="text" name="descripcion" value='<?php echo $autocomplete[0]->overview;?>'></td>
                        <td><input type="text" name="precio" value='<?php echo $autocomplete[0]->price;?>'></td>
                        <td><input type="text" name="cantidad" value='<?php echo $autocomplete[0]->quantity;?>'></td>
                        <td>
                            <button type="submit"  class="border-0 bg-transparent h6 me-4 mt-1" onclick=showLoading()  value="<?php echo $detalles->id_iteam; ?>" name="edited_item" style="color: #198754;"><i class="fas fa-save"></i></button>
                            <button type="submit"  class="border-0 bg-transparent h6" onclick=showLoading() value="<?php echo $detalles->id_iteam; ?>" name="edited_cancel" style="color: #EE4B2B;"><i class="bi bi-x-lg"></i></button> 
                        </td>
                    </form>
                    </tr>
                    <?
                        }
                        $total=$total+($detalles->price*$detalles->quantity);}}
                    ?>
        </tbody>
</table>
</div>


<!-- TOTAL -->
<div class="row mt-3">
    <div class="col col-md-10 text-end">
        <span class="h3">Importe Total: </span>
    </div>
    <div class="col col-md-2 h3">
        <?if(isset($detalle)) echo  $total . " €";
        else echo  "0 €";
        ?>
    </div>
    
    </div>
</div>

