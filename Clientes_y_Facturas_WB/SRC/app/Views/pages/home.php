<script>
function cancelForm() {
  showLoading()
  const inputs = document.querySelectorAll('input');
  inputs.forEach(input => input.removeAttribute('required'));
}
function checkForm(event) {
  const usernameInput = document.querySelector('input[name="username"]');
  const emailInput = document.querySelector('input[name="email"]');
  const passInput = document.querySelector('input[name="pass"]');
  
  if (usernameInput.value && emailInput.value && passInput.value) {
    showLoading();
  }
}
</script>
<form action="" method="post">
<div class="container mt-5">

    <div class="row text-center">
        <div class="col-md-4 text-end mb-5">
            <button type="submit" onclick="cancelForm()" name="clients" class="btn btn-primary btn-lg mr-2" style="height:100px;">Todos los Clientes</button>
        </div>
        <div class="col-md-4 text-center mb-5">
            <button type="submit" onclick="cancelForm()" name="facturas" class="btn btn-primary btn-lg mr-2" style="height:100px;">Todas las Facturas</button>
        </div>
        <div class="col-md-4 text-start mb-5">
            <button type="submit" onclick="cancelForm()" name="historial" class="btn btn-primary btn-lg mr-2" style="height:100px; width:192px">Historial</button>
        </div>
    </div>
    <?php if ($registrar != "") { ?>
      <h2 class="text-center mt-5">Crear un Usuario Nuevo</h2>

        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <input type="text" name="username" pattern="[a-zA-Z0-9]+" class="form-control" placeholder="Username" required>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <input type="text" name="email" placeholder="Email" class="form-control" required>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <input type="password" placeholder="Password" name="pass" class="form-control" required>
            </div>
        </div>

      <div class="text-center mt-5">
        <button type="submit" onclick="checkForm(event)" name="guardar" class="btn btn-primary">Guardar</button>
        <button type="submit" onclick="cancelForm()" name="cancelar" class="btn btn-secondary">Cancelar</button>
      </div>
    <?php } ?>

</div>
<?if ($admin != "") {?>
    <div class="row">
    <div class="col-md-12 fixed-bottom mt-auto py-5 me-4 mb-2 text-end">
        <button type="submit" onclick="showLoading()" name="registrar" value="register" class="btn btn-outline-warning" style="border-radius: 50%; width:80px; height:80px;"><i style="font-size:35px;"class="bi bi-person-plus-fill"></i></button>
    </div></div>
<?}?>
</form>

