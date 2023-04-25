<?php
namespace App\Controllers;
use App\Models\User_Model;


class HomeController extends BaseController{
     
    private $session;
    private $db;

    public function __construct() {
        $this->db = new User_Model();
        $this->session = \Config\Services::session();
    }
     
    public function index(){      
        if($this->session->get('user')=='false'){
                header("Location: /login");
                exit;
        }else{
            $page='Home';
            $data['title'] = ucfirst($page);
            $value['admin']="";
            $value['registrar']="";
            if(isset($_GET["registrar"])) $value['registrar']="true";
            else if($this->session->get('user')=='admin') $value['admin']="true";
            return view('templates/header', $data)
            . view('pages/home', $value)
            . view('templates/footer');
        }
    }
    public function home_posts(){
        if (isset($_POST['clients'])) header("Location: /clients");
        else if (isset($_POST['facturas'])) header("Location: /facturas");
        else if (isset($_POST['historial'])) header("Location: /historial");
        else if (isset($_POST['registrar'])) header("Location: /home?registrar=true");
        else if (isset($_POST['cancelar'])) header("Location: /home");
        else if (isset($_POST['guardar'])) {
            $username=$_POST['username'];
            $email=$_POST['email'];
            $pass=$_POST['pass'];
            $this->db->create_user($username,$email,$pass);
            header("Location: /home");
        }
        exit;
    }

    public function logout(){
        $this->session->destroy();
        header("Location: /login");
        exit;
    }
}
?>
