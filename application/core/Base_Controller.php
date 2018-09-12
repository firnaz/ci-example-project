<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_Controller extends CI_Controller {

    
    public $_data;
    public $_settings;
    public $_allowedUserClass = array('User','Dosen','Mahasiswa'); 

    /**
     * Constructor
     */
    public function __construct() 
    {
        parent::__construct();

        $this->load->helper('app_helper');
        $this->load->helper('url');

        $settings = $this->db->get("settings")->result();

        foreach($settings as $setting){
            $alias = str_replace(" ","_",strtolower($setting->name));
            $alias = str_replace("-","_",$alias);
            $this->_settings[$alias]=$setting->value; 
        }

        $this->noAuth = $this->config->item('no_auth');

        $loginState = $this->isLogin();
        if($loginState === false)
            redirect('/login','refresh');
        if($loginState !== true){
            $user = $this->db->get_where($loginState["class"], ["ID"=>$loginState["ID"]])->row();
            $user->class = $loginState["class"];
            $this->_data['user'] = $user;

            if(!in_array($this->_data["user"]->class, $this->_allowedUserClass)){
                $this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses!"]);
                redirect("dashboard/index", "refresh");
            }
        }
    }

    public function isLogin()
    {

        $segment = $this->router->class."/".$this->router->method;
        $user = $this->session->userdata('user');

        if($segment=== 'login/index' && $user){
            redirect('/dashboard', 'refresh');
        }

        if(!$user && !in_array($segment, $this->noAuth)){
            return false;
        }elseif($user){
            return $user;
        }else{
            return true;
        }
    }
}