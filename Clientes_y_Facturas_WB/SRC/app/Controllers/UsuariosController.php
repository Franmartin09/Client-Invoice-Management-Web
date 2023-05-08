<?php
namespace App\Controllers;
use App\Models\User_Model;

class UsuariosController extends BaseController{
     
    private $db;
    private $session;
    public function __construct() {
        // var_dump(date('d-m-Y H:i:s'));
        $this->db = new User_Model();
        $this->session = \Config\Services::session();
        $this->session->set('user', 'false');
        
    }
     
    public function index(){
        $data['error']=false;
        $page='Login';
        $data['title'] = ucfirst($page);
        // var_dump(date('d-m-Y H:i:s'));
        return view('templates/header', $data)
        . view('pages/login', $data)
        . view('templates/footer');
        
    }

    public function comprovar_user(){
        $data['error']=false;
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $result = $this->db->getByRow("username",$username);
            if(!$result) $data['error']=true; //echo '<p class="error">Username password combination is wrong!</p>';
            else if ($result->username != $username || $result->pass != $password) $data['error']=true; //echo '<p class="error">Username password combination is wrong!</p>';
            else {
                if($username=="admin") $this->session->set('user', 'admin');
                else $this->session->set('user', 'true');
                header("Location: /home");
                return null;
            }
        }
        $page='Login';
        $data['title'] = ucfirst($page);
        return view('templates/header', $data)
        . view('pages/login', $data)
        . view('templates/footer');
    }
}
?>
