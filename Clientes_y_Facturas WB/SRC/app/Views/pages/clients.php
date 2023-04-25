<fieldset style="width:fit-content; margin-left:5%;">
    <form>
    <legend>Please select your filter:</legend>

    <div>
      <input type="radio" name="radio" value="activo" <?php if (isset($radio) && $radio=="activo") echo "checked";?>/>
      <label>Clientes Activos</label><br>

      <input type="radio" name="radio" value="inactivo" <?php if (isset($radio) && $radio=="inactivo") echo "checked";?>/>
      <label style="vertical-align: middle;">Clientes Inactivos</label>
    
      <button type="submit"  onclick=showLoading() style="margin-left:20px">Filtrar</button> <br>

      <input type="radio" name="radio" value="total" <?php if (isset($radio) && $radio=="total") echo "checked";?>/>
      <label style="vertical-align: middle;">Todos los Clientes</label><br><br>
    </div>

    </form>
    <form method="post" action="">
        <input type="text" name="pattern" />
        <button type="submit"  onclick=showLoading() name="buscar">Buscar</button><br>
    </form>
</fieldset>
 <!-- PARA BUSCAR UN CLIENTE -->


<form method="post" action="" >
    <div style="text-align:right; margin-right:5%;margin-left:5%;width:90%;">
        <button type="submit"  onclick=showLoading() name="crear" style="height:30px;width:100px" >+</button>
    </div>
</form>
<div style="display: inline-block; overflow-y: scroll; max-height: 600px; width: 100%;">
    <table style="text-align:center; width: 90%; margin:0 auto;">
        <thead style="background-color:gray; color:white;">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Direccio</th>
                <th>CIF</th>
                <th>Fecha de Alta</th>
                <th>Fecha de Baja</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?
            if($añadir!=""){
            ?>
            <tr>
            <!-- Crear Cliente-->
            <form method="post" action="" id="addclient_id"  name="signup-form">
                <td></td>
                <td>
                <input type="text" name="nombre">
                </td>

                <td>
                <input type="text" name="email">
                </td>

                <td>
                <input type="text" name="phone">
                </td>

                <td>
                <input type="text" name="direccion">
                </td>

                <td>
                <input type="text" name="cif">
                </td>

                <td>
                <input type="text" name="fecha_alta" disabled value='<? echo date("Y-m-d H:i:s");?>'>
                </td>

                <td>
                <input type="text" name="fecha_baja" disabled>
                </td>

                <td>
                <button type="submit"  onclick=showLoading() name="created" >Crear</button>
                <button type="submit"  onclick=showLoading() name="edited_cancel" type="submit">Cancelar</button>    
                </td>

            </form>
            </tr>
            <?
            }
            ?>

            <?php if(isset($users) and $users!=""){foreach ($users as $usuario) { ?>
                <?
                    if($autocomplete=="" or  $autocomplete[0]->id_cliente!=$usuario->id_cliente){?>
            <form method="post" action="">
                <tr style="background-color: lightblue;">
                    <td><?php echo $usuario->id_cliente; ?></td>
                    <td><?php echo $usuario->name_surname; ?></td>
                    <td><?php echo $usuario->email_cliente; ?></td>
                    <td><?php echo $usuario->phone; ?></td>
                    <td><?php echo $usuario->addres; ?></td>
                    <td><?php echo $usuario->cif; ?></td>
                    <td><?php echo $usuario->fecha_alta; ?></td>
                    <td><?php echo $usuario->fecha_baja; ?></td>
                    <td>
                        <button type="submit"  onclick=showLoading() name="facturas" value="<?php echo $usuario->id_cliente; ?>" style="background-color: lightgreen;">Facturas</button>
                        <button type="submit"  onclick=showLoading() name="editar" value="<?php echo $usuario->id_cliente; ?>" type="submit">Editar</button>
                        <?if ($usuario->estado=="A"){?>
                            <button type="submit"  onclick=showLoading() name="archivar" value="<?php echo $usuario->id_cliente; ?>">Archivar</button>
                        <?}else {?>
                            <button type="submit"  onclick=showLoading() name="desarchivar" value="<?php echo $usuario->id_cliente; ?>">Desarchivar</button>
                        <?}?>
                        <button type="submit"  onclick=showLoading() name="eliminar" value="<?php echo $usuario->id_cliente; ?>" style="background-color: #EE4B2B;">Eliminar</button>
                    </td>
                    <!-- Update Cliente-->
                </tr>
            </form>
                <?}else {
                    ?>
                    <tr>
                    <form method="post" action="">
                        <td>
                        <input type="text" name="idcliente" value='<?php echo $autocomplete[0]->id_cliente;?>' disabled>
                        </td>
                        <td>
                        <input type="text" name="nombre" value='<?php echo $autocomplete[0]->name_surname;?>'>
                        </td>
                        <td>
                        <input type="text" name="email" value='<?php echo $autocomplete[0]->email_cliente;?>'>
                        </td>
                        <td>
                        <input type="text" name="phone" value='<?php echo $autocomplete[0]->phone;?>'>
                        </td>
                        <td>
                        <input type="text" name="direccion" value='<?php echo $autocomplete[0]->addres;?>'>
                        </td>
                        <td>
                        <input type="text" name="cif" value='<?php echo $autocomplete[0]->cif;?>'>
                        </td>
                        <td>
                        <input type="text" name="fecha_alta" value='<?php echo $autocomplete[0]->fecha_alta;?>' disabled>
                        </td>
                        <td>
                        <input type="text" name="fecha_baja" value='<?php echo $autocomplete[0]->fecha_baja;?>' disabled>
                        </td>
                        <td>
                            <button type="submit"  onclick=showLoading() name="edited" value="<?php echo $usuario->id_cliente; ?>">Guardar</button>
                            <button type="submit"  onclick=showLoading() name="edited_cancel" value="<?php echo $usuario->id_cliente; ?>">Cancelar</button>
                        </td>
                    </form>
                    </tr>
                    <?
                        }
                    }
                    ?>
            <? } ?>
        </tbody>
    </table>
</div>
    <br>
    <hr>
