<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Base_Controller {
    public $_allowedUserClass = array('User'); 

	public function edit()
	{
		$data["msg"] = $this->session->userdata("messages");
		$this->session->unset_userdata("messages");

    	$query = $this->db->get("Settings");
    	$data["results"] = $query->result();

		$this->load->view("settings/edit", $data);		
	}

	public function update()
	{
		$settings = $this->input->post("settings");
		$success = true;

		foreach($settings as $id=>$value){
			$form["ID"]    = $id;
			$form["value"] = $value;

			$this->db->where('ID', $form["ID"]);
			if(!$this->db->update("Settings", $form)){
				$success = false;
				break;
			}
		}

		if($success){
			$this->session->set_userdata("messages",["type"=>"info", "text"=> "Settings berhasil disimpan!"]);
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Settings tidak berhasil disimpan!"]);
		}
		redirect("/settings/edit","refresh");
	}

}