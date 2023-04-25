<?php
namespace App\Controllers;
use App\Models\Client_Model;
use App\Models\Detalle_Model;
use App\Models\Invoice_Model;

class DetallesController extends BaseController{
     
    private $db;
    private $db_items;
    private $db_clientes;
    private $session;
    public function __construct() {
        $this->db = new Invoice_Model();
        $this->db_clientes = new Client_Model();
        $this->db_items = new Detalle_Model();
        $this->session = \Config\Services::session();
    }
     
    public function index(){
        if($this->session->get('user')!='admin' and $this->session->get('user')!='true'){
            header("Location: /login");
            exit;
        }else{
            $value['id_cliente'] = "";
            $value['n_factura'] = "";
            $value['reference'] = "";
            $page='Crear Factura';  
            if($this->db->getByRow("id_factura",$_GET["id_factura"])==NULL){
                if(isset($_GET["id_cliente"])){
                    $this->db->create_invoice($_GET["id_cliente"], $_GET["id_factura"]);
                    $datos=$this->db->getByRow("id_factura",$_GET["id_factura"]);
                    $value['id_cliente'] = $datos->id_cliente;
                    $value['reference'] = $datos->reference;
                    $value['n_factura'] = $datos->numero_factura;
                    $page="Crear Factura para Cliente con ID: " . $_GET["id_cliente"];
                }
            }
            else{
                $datos=$this->db->getByRow("id_factura",$_GET["id_factura"]);
                $value['reference']=$datos->reference;
                $value['n_factura'] =$datos->numero_factura;
                $value['id_cliente'] = $datos->id_cliente;
                $page="Crear Factura para Cliente con ID: " . $_GET["id_cliente"];
            }
            $data['title'] = ucfirst($page);
            $value['detalle']=$this->db_items->getBy('id_factura',$_GET["id_factura"]);

            $value['editar']="";
            $value['añadir']="";
            $value['autocomplete'] ="";
            $_SESSION['editar'] = 'false';
            return view('templates/header', $data)
            . view('pages/make_invoice', $value)
            . view('templates/footer');
        }
    }
    public function posts(){
        if(isset($_POST["guardar_factura"])){
            if($this->db_items->getBy('id_factura',$_GET["id_factura"])==NULL) $this->db->deleteBy('id_factura',$_GET["id_factura"]);
            else $this->db->updateimporte($_GET["id_factura"], $this->db_items->importe_neto_total($_GET["id_factura"]));

            if(isset($_GET["id_cliente"])) header("Location: /facturas?id_cliente=".$_GET["id_cliente"]);
            else header("Location: /facturas");
        }
        else if(isset($_POST["cancelar_factura"])){
            if($this->db_items->getBy('id_factura',$_GET["id_factura"])==NULL) $this->db->deleteBy('id_factura',$_GET["id_factura"]);
            else $this->db->updateimporte($_GET["id_factura"], $this->db_items->importe_neto_total($_GET["id_factura"]));
            if(isset($_GET["id_cliente"])) header("Location: /facturas?id_cliente=".$_GET["id_cliente"]);
            else header("Location: /facturas");
        }
        else if(isset($_POST["eliminar_item"])){
            $this->db->deleteBy( 'id_iteam',$_POST["eliminar_item"]);
            if(isset($_GET["id_cliente"])) header("Location: /añadir_item?id_factura=".$_GET["id_factura"]."&id_cliente=".$_GET["id_cliente"]);
            else header("Location: /añadir_item?id_factura=".$_GET["id_factura"]);
        }
        else if(isset($_POST["editar_item"])){
            header("Location: /editar_item?id_factura=".$_GET["id_factura"]."&id_item=".$_POST["editar_item"]);
        }
        else if(isset($_POST["edited_item"])){
            $datos=$this->db->getByRow('id_factura',$_GET["id_factura"]);
            if(isset($_POST["edited_item"])){
                if(isset($_POST["cantidad"])) $cantidad=$_POST["cantidad"];
                else $cantidad="1";
                $this->db_items->edit_item($_POST["edited_item"],$_POST['precio'], $_POST["descripcion"], $cantidad); 
            }
            if(isset($datos->id_cliente)){
                if($_SESSION['editar']=='false')header("Location: /crear_facturas?id_factura=".$_GET["id_factura"]."&id_cliente=$datos->id_cliente");
                else header("Location: /editar_facturas?id_factura=".$_GET["id_factura"]."&id_cliente=$datos->id_cliente");
            }else{
                if($_SESSION['editar']=='false')header("Location: /crear_facturas?id_factura=".$_GET["id_factura"]);
                else header("Location: /editar_facturas?id_factura=".$_GET["id_factura"]);
            }
        }
        else if(isset($_POST["añadir_item"])){
            if(isset($_GET["id_cliente"])) header("Location: /añadir_item?id_factura=".$_GET["id_factura"]."&id_cliente=".$_GET["id_cliente"]);
            else header("Location: /crear_facturas?id_factura=".$_GET["id_factura"]);
        }
        else if(isset($_POST["item_added"])){
            if($_POST["cantidad"]!="") $cantidad=$_POST["cantidad"];
            else $cantidad="1";
            if($this->db_items->commprovar_item($_GET["id_factura"],$_POST["descripcion"],$cantidad,$_POST["precio"])==false) $this->db_items->add_iteam($_GET["id_factura"],$_POST["descripcion"],$_POST["precio"],$cantidad);
            if(isset($_GET["id_cliente"])) header("Location:  /añadir_item?id_factura=".$_GET["id_factura"]."&id_cliente=".$_GET["id_cliente"]);
            else header("Location:  /añadir_item?id_factura=".$_GET["id_factura"]);
        }
        else if(isset($_POST["item_cancel"])){
            if(isset($_GET["id_cliente"])){
                if($_SESSION['editar']=='false')header("Location: /crear_facturas?id_factura=".$_GET["id_factura"]."&id_cliente=".$_GET["id_cliente"]);
                else header("Location: /editar_facturas?id_factura=".$_GET["id_factura"]."&id_cliente=".$_GET["id_cliente"]);
            }else{
                 if($_SESSION['editar']=='false')header("Location: /crear_facturas?id_factura=".$_GET["id_factura"]);
                 else header("Location: /editar_facturas?id_factura=".$_GET["id_factura"]);
            }
        }
        else if(isset($_POST["comprobar_cliente"])){
            if(isset($_POST["cliente"]) and $_POST["cliente"]!=""){
                if($this->db_clientes->getby("id_cliente",$_POST["cliente"])) header("Location: /crear_facturas?id_factura=".$_GET["id_factura"]."&id_cliente=".$_POST["cliente"]);
            }
            else header("Location: /crear_facturas?id_factura=".$_GET["id_factura"]);
        }
        else if(isset($_POST["volver"])){
            if($this->db_items->getBy('id_factura',$_GET["id_factura"])==NULL) $this->db->deleteBy('id_factura',$_GET["id_factura"]);
            else $this->db->updateimporte($_GET["id_factura"], $this->db_items->importe_neto_total($_GET["id_factura"]));
            if(isset($_GET["id_cliente"])) header("Location: /facturas?id_cliente=".$_GET["id_cliente"]);
            else  header("Location: /facturas");
        } 
        exit;
        
    }
    public function editar_factura(){
        if($this->session->get('user')!='admin' and $this->session->get('user')!='true'){
            header("Location: /login");
            exit;
        }else{
            $datos=$this->db->getByRow("id_factura",$_GET["id_factura"]);
            $value['reference']=$datos->reference;
            $value['n_factura'] =$datos->numero_factura;
            $value['id_cliente'] = $datos->id_cliente;
            $page="Editar Factura con ID: ". $_GET["id_factura"] . " para Cliente con ID: " . "$datos->id_cliente";
            $data['title'] = ucfirst($page);
            $value['detalle']=$this->db_items->getBy('id_factura',$_GET["id_factura"]);

            $value['editar']="true";
            $value['añadir']="";
            $value['autocomplete'] ="";
            $_SESSION['editar'] = 'true';
            return view('templates/header', $data)
            . view('pages/make_invoice', $value)
            . view('templates/footer');
        }
    }
    public function añadir_item(){
        if($this->session->get('user')!='admin' and $this->session->get('user')!='true'){
            header("Location: /login");
            exit;
        }else{
            $datos=$this->db->getByRow("id_factura", $_GET["id_factura"]);
            if(isset($_GET["id_cliente"])){
                $idCliente = $_GET["id_cliente"];
                $value['id_cliente'] = $idCliente;
                if($_SESSION['editar']=='false') $page="Crear Factura para Cliente con ID: " . "$datos->id_cliente";
                else $page="Editar Factura para Cliente con ID: " . "$datos->id_cliente";
                $data['title'] = ucfirst($page); 
                $value['n_factura']=intval($this->db->getMaxNfactureBy('numero_factura','id_cliente',$idCliente))+1;
            }
            $value['reference']=$datos->reference;
            $value['n_factura'] =$datos->numero_factura;
            $value['detalle']=$this->db_items->getBy('id_factura',$_GET["id_factura"]);
            $value['editar']="";
            $value['añadir']="añadir";
            $value['autocomplete'] ="";
            
            return view('templates/header', $data)
            . view('pages/make_invoice', $value)
            . view('templates/footer');
        }
    }
    public function editar_item(){
        if($this->session->get('user')!='admin' and $this->session->get('user')!='true'){
            header("Location: /login");
            exit;
        }else{
            $idFactura=$_GET["id_factura"];
            $datos=$this->db->getByRow("id_factura", $idFactura);
            $value['id_cliente'] = $datos->id_cliente;
            if($_SESSION['editar']=='false')$page="Crear Factura para Cliente con ID: " . "$datos->id_cliente";
            else $page="Editar Factura para Cliente con ID: " . "$datos->id_cliente";
            $data['title'] = ucfirst($page); 
            $value['n_factura']=$datos->numero_factura;
            $value['id_cliente'] = $datos->id_cliente;
            $value['reference'] = $datos->reference;
            $value['n_factura'] = $datos->numero_factura;
            $value['detalle']=$this->db_items->getBy('id_factura',$_GET["id_factura"]);
            $value['editar']="";
            $value['añadir']="";
            $value['autocomplete'] = $this->db_items->getBy('id_iteam',$_GET["id_item"]);
    
            return view('templates/header', $data)
            . view('pages/make_invoice', $value)
            . view('templates/footer');
        }
       
    }
}
?>
