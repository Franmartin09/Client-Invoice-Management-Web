<?php

namespace App\Controllers;
use App\Models\Invoice_Model;
use App\Models\Client_Model;
use App\Models\Detalle_Model;

use Dompdf\Dompdf;
use Dompdf\Options;
require 'vendor/autoload.php';

class InvoicesController extends BaseController{
     
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
            if(isset($_GET["id_cliente"])){
                $idCliente = $_GET["id_cliente"];
                $page='Facturas de Cliente con ID: ' . $idCliente;
                $value['invo'] = $this->db->getBy('id_cliente',$idCliente);
            }
            else{
                $page='Todas las Facturas';
                $value['invo'] = $this->db->getAllOrderBy('id_factura');
            }
            $data['title'] = ucfirst($page);
            return view('templates/header', $data)
            . view('pages/invoices_client', $value)
            . view('templates/footer');
        }
    }
    public function posts(){
        if(isset($_POST["crear"])){
            if($this->db->getByRow("id_factura",1)==NULL) $idfactura = 1;
            else $idfactura = intval($this->db->getMaxByinRow('id_factura')->id_factura)+1; 

            if(isset($_GET["id_cliente"])) header("Location: /crear_facturas?&id_factura=$idfactura&id_cliente=".$_GET["id_cliente"]);
            else header("Location: /crear_facturas?&id_factura=$idfactura");
        }
        else if(isset($_POST["eliminar"])){
            $this->db->deleteBy('id_factura',$_POST["eliminar"]);
            if(isset($_GET["id_cliente"])) header("Location: /facturas?id_cliente=".$_GET["id_cliente"]);
            else header("Location: /facturas");
        }
        else if(isset($_POST["editar"])){
            if(isset($_GET["id_cliente"])) header("Location: /editar_facturas?id_factura=".$_POST["editar"]."&id_cliente=".$_GET["id_cliente"]);
            else header("Location: /editar_facturas?id_factura=".$_POST["editar"]);
        }
        else if(isset($_POST["volver"])){
            if (isset($_GET["id_cliente"])) header("Location: /clients");
            else header("Location: /home");
        }
        else if(isset($_POST["imprimir"])){
            $value['factura'] = $this->db->getByRow('id_factura', $_POST["imprimir"]);
            $value['items'] = $this->db_items->getBy('id_factura', $_POST["imprimir"]);
            $value['cliente'] = $this->db_clientes->getByRow('id_cliente', $value['factura']->id_cliente);
            $html = view('/templates/invoice', $value);
            
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->render();
            $dompdf->stream("factura_" . $value['factura']->reference . ".pdf");
        }
        exit;
    }

}
?>
