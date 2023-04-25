<?php
namespace App\Controllers;
use App\Models\Client_Model;

class ClientsController extends BaseController{
     
    private $db;
    private $session;
    public function __construct() {
        $this->db = new Client_Model();
        $this->session = \Config\Services::session();
    }
     
    public function index(){
        if($this->session->get('user')!='admin' and $this->session->get('user')!='true'){
            header("Location: /login");
            exit;
        }else{  
            $page='Clients';
            $data['title'] = ucfirst($page);
            
            $value['autocomplete']="";
            $value['añadir']="";
            if(isset($_GET['añadir'])) $value['añadir']="true";
            else if(isset($_GET['id_cliente'])) $value['autocomplete'] = $this->db->getBy('id_cliente',$_GET['id_cliente']);

            if(isset($_GET["search"])){
                $value['users'] = $this->validarInput($_GET['search']);
                $value['radio'] = "total";
            }
            else if(isset($_GET["radio"])){
                $value['radio']=$_GET["radio"];
                if($_GET['radio'] == "activo") $value['users'] = $this->db->getAllAOrderBy('id_cliente');
                else if($_GET['radio'] == "inactivo") $value['users'] = $this->db->getAllIOrderBy('id_cliente');
                else if($_GET['radio']=="total") $value['users'] = $this->db->getAllOrderBy('id_cliente');
            }
            else{
                $value['radio']="activo";
                $value['users'] = $this->db->getAllAOrderBy('id_cliente');
            }
            return view('templates/header', $data)
            . view('pages/clients', $value)
            . view('templates/footer');
        }
    }
    public function posts(){
        if(isset($_POST["crear"])){
            if(isset($_GET["radio"])) header("Location: /clients?añadir=true&radio=" . $_GET['radio']);
            else header("Location: /clients?añadir=true");
        }
        else if(isset($_POST["created"])){
            $this->db->create_client($_POST['nombre'], $_POST['email'], $_POST['phone'], $_POST['direccion'], $_POST['cif']);
            if(isset($_GET["radio"])) header("Location: /clients?radio=" . $_GET['radio']);
            else header("Location: /clients");
        }
        else if(isset($_POST["archivar"])){
            $this->db->archivar_client($_POST["archivar"]);
            if(isset($_GET["radio"])) header("Location: /clients?radio=" . $_GET['radio']);
            else header("Location: /clients");
        }
        else if(isset($_POST["desarchivar"])){
            $this->db->archivar_client($_POST["desarchivar"]);
            if(isset($_GET["radio"])) header("Location: /clients?radio=" . $_GET['radio']);
            else header("Location: /clients");
        }
        else if(isset($_POST["eliminar"])){
            $this->db->deleteBy('id_cliente',$_POST["eliminar"]);
            if(isset($_GET["radio"])) header("Location: /clients?radio=" . $_GET['radio']);
            else header("Location: /clients");
        }
        else if(isset($_POST["facturas"])) header("Location: /facturas?id_cliente=".$_POST["facturas"]);
        else if(isset($_POST["editar"])){
            if(isset($_GET["search"])) header("Location: /clients?id_cliente=".$_POST["editar"]."&search=".$_GET["search"]);
            else if(isset($_GET["radio"])) header("Location: /clients?id_cliente=".$_POST["editar"]."&radio=".$_GET['radio']);
            else header("Location: /clients?id_cliente=".$_POST["editar"]);
        }
        else if(isset($_POST["edited"])){
            if(isset($_POST["nombre"])) $this->db->edit_client($_POST['edited'],$_POST['nombre'], $_POST['email'], $_POST['phone'], $_POST['direccion'], $_POST['cif']);
            if(isset($_GET["search"])) header("Location: /clients?search=".$_GET["search"]);
            else if(isset($_GET["radio"])) header("Location: /clients?radio=".$_GET['radio']);
            else header("Location: /clients");
        }
        else if(isset($_POST["edited_cancel"])){
            if(isset($_GET["search"])) header("Location: /clients?search=".$_GET["search"]);
            else if(isset($_GET["radio"])) header("Location: /clients?radio=".$_GET['radio']);
            else header("Location: /clients");
        }
        else if(isset($_POST["buscar"])) header("Location: /clients?search=".$_POST["pattern"]);
        else if(isset($_POST["volver"])) header("Location: /home");
        else if(isset($_GET["radio"])) header("Location: /clients?radio=".$_GET['radio']);

        exit;

    }

    function validarInput($input) {
        $value['users']="";
        if(filter_var($input, FILTER_VALIDATE_EMAIL))$value['users'] = $this->db->getByLike('email_cliente',$input);
        else if(preg_match('/^[0-9]{1,8}$/', $input)) $value['users'] = $this->db->getBy('id_cliente',$input);
        else if(preg_match('/^[0-9]{9}$/', $input)) $value['users'] = $this->db->getByLike('CAST(phone AS TEXT)',$input);
        else if(preg_match('/^[a-zA-Z ]+$/', $input)) $value['users'] = $this->db->getByLike('name_surname',$input);
        else if(preg_match('/^\d{4}-\d{2}-\d{2}$/', $input)) {
          $fecha = date('Y-m-d H:i:s', strtotime($input));
          $value['users'] = $this->db->getBy('DATE(fecha_alta)',$fecha);
        }
        return $value['users'];
    }
}
?>
