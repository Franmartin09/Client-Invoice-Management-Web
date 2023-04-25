<?php
namespace App\Controllers;
use App\Models\EntidadBase;
use App\Models\Invoice_Model;

class HistorialController extends BaseController{
     
    private $db;

    private $session;
    public function __construct() {
        $this->db = new Invoice_Model();
        $this->session = \Config\Services::session();      
    }
     
    public function index(){
        if($this->session->get('user')!='admin' and $this->session->get('user')!='true'){
            header("Location: /login");
            exit;
        }else{   
            $page='Historial';
            $data['title'] = ucfirst($page);
            if(empty($_GET["fecha"])){
                $value['week']=date('Y')."-W".date('W');
                $date = date('Y-m-d', strtotime($value['week']));
            }
            else{
                $date =  date('Y-m-d', strtotime($_GET["fecha"]));
                $week_number = date('W', strtotime($date));
                $value['week']=date('Y')."-W".$week_number;
            }
            $value['mensual']=$this->db->getinvoiceMensual($date);
            $value['semanal']=$this->db->getinvoiceSemanal($date);
            $value['anual']=$this->db->getinvoiceAnual($date);
            return view('templates/header', $data)
            . view('pages/history', $value)
            . view('templates/footer');
        }
    }
    public function posts(){
        if(isset($_POST["week"])) header("Location: /historial?fecha=".date('Y-m-d', strtotime($_POST["week"])));
        else if(isset($_POST["volver"])) header("Location: /home");
        exit;
    }
   

}
?>
