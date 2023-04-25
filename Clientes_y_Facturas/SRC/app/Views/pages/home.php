<div style="text-align:center;">
<form action="" method="post">
    <br>
    <button type="submit" onclick=showLoading() name="clients" style="margin-bottom:40px; width:160px;height:50px;">Todos los Clientes</button>
    <button type="submit" onclick=showLoading() name="facturas" style="margin-bottom:40px; width:160px;height:50px;">Todas las Facturas</button>
    <button type="submit" onclick=showLoading() name="historial" style="margin-bottom:40px; width:160px;height:50px;">Historial</button> 
    <br>
    
    <? 
    if($admin!="") { 
    ?>
        <button type="submit" onclick=showLoading() name="registrar" value="register" style="margin-bottom:40px; width:160px;height:50px;">Registrar Usuario</button> 
    <?
    }
    if($registrar!=""){
    ?>
        
        <br><h2>Crear un Usuario Nuevo</h2><br>
            <!-- Username -->
            <div class="form-element" style="margin-bottom:20px">
                <label>Username</label>
                <input type="text" name="username" pattern="[a-zA-Z0-9]+"/>
            </div>

            <!-- Email -->
            <div class="form-element" style="margin-bottom:20px">
                <label>Email</label>
                <input type="text" name="email"/>
            </div>

            <!-- Password -->
            <div class="form-element" style="margin-bottom:20px">
                <label>Password</label>
                <input type="password" name="pass"/>
            </div>
            
            <button type="submit" onclick=showLoading() name="guardar" style="margin-bottom:40px; width:100px;height:40px;">Guardar</button>
            <button type="submit" onclick=showLoading() name="cancelar" style="margin-bottom:40px; width:100px;height:40px;">Cancelar</button>
    <?
    }
    ?>


    <br>
</form>
</div> 

