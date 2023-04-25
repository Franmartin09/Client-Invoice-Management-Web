<!doctype html>
<html>
<head>
    <title>Clientes & Facturas</title>
    <script type="text/javascript">
      function showLoading() {
        document.getElementById('loading').style.display='block';
      }
    </script>
    
</head>

<body>
    <!-- IMAGEN LOADING LOGO STP -->
<div id="loading" style="text-align:center; position:fixed; width:100%; height:100%;top:0; bottom:0; background-color: rgba(255,255,255,0.85); z-index:9999; display:none;">
        <img src="app/Views/templates/loading.gif" alt="Loading..." style="width:300px;margin-top:25vh;"> 
</div>

<?php 
if($title=='Clients'){
    $title='Clientes';
}
else if ($title=='Login'){?>
    <h1 style="text-align:center;"><?= esc($title) ?></h1>
    <?}

?>
    <?
    if ($title!='Login'){?> 
            <div style="text-align:right;">
            <?if($title!='Home' and $title!='Crear Factura' and $title!='Editar Factura'){?><form method="post" action=""><button name="volver"  onclick=showLoading() value="" style="height:50px;width:50px; position: fixed; top: 7px; right: 130px; margin-top: 0; margin-right: 0;" ><</button></form><?}?>
            <button onclick="location.href='/logout'" style="height:50px;width:120px; position: fixed; top: 7px; right: 7px; margin-top: 0; margin-right: 0;" >Logout</button>
            <h1 style="text-align:center;"><?= esc($title) ?></h1>
        </div>
    <?}?>
    <hr><br>

