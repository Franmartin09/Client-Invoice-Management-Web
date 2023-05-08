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
            <button class="btn btn-secondary" type="button" onclick=agregarLinea() style="height:40px; width:90px" ><i class="bi bi-plus-square-dotted"></i></button>
            <button class="btn btn-success" type="submit" onclick=showLoading() name="guardar_factura" value="" id="button_save"style="height:40px;width:90px" ><? if($editar!="") echo "Editar"; else echo "Guardar"?></button>
            <button class="btn btn-danger"  type="submit" onclick=showLoading() name="cancelar_factura" value="<? if(isset($id_cliente)) echo $id_cliente?>" style="width:90px" >Cancelar</button>
            </div>
            </form>
</div>

<div class="mx-auto" style="width:90%; overflow-y: auto; max-height: 520px;">

    <table class="table table-condensed table-striped table-hover text-center" >
        <thead style="background-color:#712cf9; color:white;">
            <tr>
                <th>ID</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody id="lineas-factura">

        </tbody>
</table>

</div>


<!-- TOTAL -->
<div class="row mt-3">
    <div class="col col-md-10 text-end">
        <span class="h3">Importe Total: </span>
    </div>
    <div class="col col-md-2 h3">
        <span class="h5" id="span_total"></span>
    </div>
    
    </div>
</div>

<script>
   const productos = <?php echo json_encode($detalle); ?>;
   write_lines();
   let control=true;
function write_lines(){
  let subtotal = 0;
  var Table = document.getElementById("lineas-factura");
  Table.innerHTML = "";
  var tabla="";
  for (const producto of productos) {
    const totalProducto = producto.quantity * producto.price;
    subtotal += totalProducto;
    tabla += `<tr>
          <td>${producto.id_iteam}</td>
          <td>${producto.overview}</td>
          <td>${producto.price}</td>
          <td>${producto.quantity}</td>
          <td>
              <button onclick="edit_item('${encodeURIComponent(JSON.stringify(producto))}')" class="border-0 bg-transparent me-3" ><i class="bi bi-pencil"></i></button>
              <button onclick="delete_item('${encodeURIComponent(JSON.stringify(producto))}')" class="border-0 bg-transparent"><i class="bi bi-trash3" style="color: #EE4B2B;"></i></button>
          </td>
          </tr>`;
    }
    var lineasFactura = document.getElementById('lineas-factura');
    lineasFactura.innerHTML = tabla + lineasFactura.innerHTML;
    var lineaTotal = document.getElementById('span_total');
    lineaTotal.innerHTML=`${Math.round(subtotal * 100)/100}`;
    document.getElementById("button_save").value = JSON.stringify(productos);

}
function eliminar_añadir(){
    document.getElementById('lineas-factura').deleteRow(0);
    control=true;
}

function agregarLinea() {
  var lineaHtml = 
`
<tr>   
    <td id="id_iteam"></td>
    <td><input type="text" name="descripcion" id="overview"></td>
    <td><input type="number" name="precio" id="price" step="0.01"></td>
    <td><input type="number" name="cantidad" step="1" id="quantity"></td>
    <td>
        <button onclick=save_lines() class="border-0 bg-transparent h6 me-4 mt-1" style="color: #198754;"><i class="fas fa-save"></i></button>
        <button onclick="eliminar_añadir()"  style="color: #EE4B2B;" class="border-0 bg-transparent h6"><i class="bi bi-x-lg"></i></button> 
    </td>
</tr>
`;
    if(control){
        var lineasFactura = document.getElementById('lineas-factura');
        lineasFactura.innerHTML = lineaHtml + lineasFactura.innerHTML;
        control=false;
    }
}
function save_lines(){
  var descripcion = document.getElementById('overview').value;
  var precio = Math.round(document.getElementById('price').value * 100)/100;
  if(descripcion!="" && precio!=0){
    var id = "";
    var cantidad = document.getElementById('quantity').value;
    if(cantidad=="" || cantidad<1) cantidad=1;
    else cantidad=Math.round(cantidad);
    productos.unshift({"id_iteam": id,"overview": descripcion,"price": precio, "quantity": cantidad});
  }
  console.log(productos);
  write_lines();
  control=true;
  agregarLinea();
}

function delete_item(object){
    var obj=JSON.parse(decodeURIComponent(object))
    let index = productos.findIndex((x) => JSON.stringify(x) === JSON.stringify(obj));
    const x = productos.splice(index, 1);
    write_lines()
    control=true;
}
function edit_item(object){
  var obj=JSON.parse(decodeURIComponent(object))
  var tabla="";
  for (const producto of productos) {
    if(JSON.stringify(obj)===JSON.stringify(producto)){
       tabla += `<tr>
            <td><span>${producto.id_iteam}</span></td>
            <td><input type="text" name="descripcion" id="overview" value="${producto.overview}"></td>
            <td><input type="number" step="0.01" name="precio" id="price" value="${producto.price}"></td>
            <td><input type="number" step="1" name="cantidad" id="quantity" value="${producto.quantity}"></td>
            <td>
                <button onclick="edited_item('${encodeURIComponent(JSON.stringify(producto))}')"  class="border-0 bg-transparent h6 me-4 mt-1" style="color: #198754;"><i class="fas fa-save"></i></button>
                <button onclick="write_lines()"style="color: #EE4B2B;" class="border-0 bg-transparent h6"><i class="bi bi-x-lg"></i></button>
            </td>
            </tr>`;
    }
    else{
      tabla += `<tr>
            <td>${producto.id_iteam}</td>
            <td>${producto.overview}</td>
            <td>${producto.price}</td>
            <td>${producto.quantity}</td>
            <td>
              <button onclick="edit_item('${encodeURIComponent(JSON.stringify(producto))}')" class="border-0 bg-transparent me-3" ><i class="bi bi-pencil"></i></button>
              <button onclick="delete_item('${encodeURIComponent(JSON.stringify(producto))}')" class="border-0 bg-transparent"><i class="bi bi-trash3" style="color: #EE4B2B;"></i></button>
            </td>
            </tr>`;
    }
  }
  var lineasFactura = document.getElementById('lineas-factura');
  lineasFactura.innerHTML = tabla;
}

function edited_item(object){
    var obj=JSON.parse(decodeURIComponent(object))
    var descripcion = document.getElementById('overview').value;
    var precio = Math.round(document.getElementById('price').value * 100)/100;
    if(descripcion!="" && precio!=0){
        var cantidad = document.getElementById('quantity').value;
        if(cantidad=="") cantidad=1;
        else cantidad=Math.round(cantidad);
        var id = obj.id_iteam;
        let index = productos.findIndex((x) => JSON.stringify(x) === JSON.stringify(obj));
        productos[index].overview=descripcion;
        productos[index].price=precio;
        productos[index].quantity=cantidad;
    }
  write_lines()
}

</script>