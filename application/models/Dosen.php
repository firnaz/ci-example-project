<?php 

class Dosen extends CI_Model {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function auth($username, $password){
    	$passwd = md5($password);

    	$query = $this->db->get_where('dosen', ["NIP"=>$username, "password"=>$passwd], 0, 1);

    	$user = $query->result();

    	if (isset($user) && $user[0]){
    		$data["ID"] = $user[0]->ID; 
    		$data["username"] = $user[0]->NIP; 
    		$data["nama"] = $user[0]->nama; 
    		$data["class"] = "Dosen";

    		$this->session->set_userdata("user",$data);
    		return true;
    	}

    	return false;
    }

}
