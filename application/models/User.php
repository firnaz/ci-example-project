<?php 

class User extends CI_Model {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function auth($username, $password){
    	$passwd = md5($password);

    	$query = $this->db->get_where('admin', ["username"=>$username, "password"=>$passwd], 0, 1);

    	$user = $query->result();

    	if (isset($user) && $user[0]){
    		$data["ID"] = $user[0]->ID; 
    		$data["username"] = $user[0]->username; 
    		$data["nama"] = $user[0]->nama; 
    		$data["class"] = "User";

    		$this->session->set_userdata("user",$data);
    		return true;
    	}

    	return false;
    }

}
