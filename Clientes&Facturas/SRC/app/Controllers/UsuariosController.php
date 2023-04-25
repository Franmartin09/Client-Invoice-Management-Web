<?php
namespace App\Controllers;
use App\Models\User_Model;

class UsuariosController extends BaseController{
     
    private $db;
    private $session;
    public function __construct() {
        $this->db = new User_Model();
        $this->session = \Config\Services::session();
        $this->session->set('user', 'false');
    }
     
    public function index(){
        $page='Login';
        $data['title'] = ucfirst($page);
        return view('templates/header', $data)
        . view('pages/login', $data)
        . view('templates/footer');
    }

    public function comprovar_user(){
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $result = $this->db->getByRow("username",$username);
            $name = $result->username;
            $contraseña = $result->pass;
            if(!$result) echo '<p class="error">Username password combination is wrong!</p>';
            else if ($name != $username || $contraseña != $password) echo '<p class="error">Username password combination is wrong!</p>';
            else {
                if($username=="admin") $this->session->set('user', 'admin');
                else $this->session->set('user', 'true');
                header("Location: /home");
            }
        }
        $page='Login';
        $data['title'] = ucfirst($page);
        return view('templates/header', $data)
        . view('pages/login', $data)
        . view('templates/footer');
    }

    public function logout(){
        $this->session->destroy();
        header("Location: /login");
    }
}
?>
