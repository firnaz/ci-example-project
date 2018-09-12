<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen_pembimbing extends Base_Controller {
    public $_allowedUserClass = array('User'); 

	public function index()
	{
		redirect("/dosen-pembimbing/lists");
	}

	public function lists()
	{
		$data["msg"] = $this->session->userdata("messages");
		$this->session->unset_userdata("messages");

		$page = $this->input->get("page");
		$page = $page>0?($page-1):0;

		$limit = 25;
		$offset = $limit*$page;

    	$query = $this->db->get("dosen",$offset, $limit);
    	$data["results"] = $query->result();

    	$totalresults = $this->db->count_all('dosen');
    	$data["pagination"] = createPagination($offset, count($data["results"]), $totalresults, $limit, $page);

		$this->load->view("dosen-pembimbing/lists", $data);
	}

	public function create(){

		$data["action"] = "add";

		$data["msg"] = $this->session->userdata("messages");
		$this->session->unset_userdata("messages");

		$data["form"] = $this->session->userdata("formDosen");
		$this->session->unset_userdata("formDosen");

		$data["Kepangkatan"] = $this->db->get("Kepangkatan")->result_array();


		$this->load->view("dosen-pembimbing/forms",$data);
	}

	public function add(){
		$form["NIP"] = $this->input->post("NIP");
		$form["nama"] = $this->input->post("nama");
		$form["KepangkatanID"] = $this->input->post("KepangkatanID");
		$form["password"] = md5($this->input->post("password"));


		if(empty($form["NIP"]) || empty($form["nama"]) || empty($form["KepangkatanID"]) || empty($form["password"])){
			$this->session->set_userdata("formDosen",$form);
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Seluruh data harus diisi!"]);
			redirect("/dosen-pembimbing/create","refresh");			
		}

		$form["username"] = $this->input->post("NIP");
		$form["RolesID"] = 2;
		unset($form["NIP"]);
		if($this->db->insert("User", $form)){
			$this->session->set_userdata("messages",["type"=>"info", "text"=> "Dosen berhasil ditambahkan!"]);
			redirect("/dosen-pembimbing/lists","refresh");
		}else{
			$this->session->set_userdata("formDosen",$form);
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
			redirect("/dosen-pembimbing/create","refresh");
		}
	}

	public function edit(){
		$ID = $this->input->get("id");

		$data["action"] = "update";

		$data["msg"] = $this->session->userdata("messages");
		$this->session->unset_userdata("messages");


		$data["form"] = $this->session->userdata("formDosen");
		$this->session->unset_userdata("formDosen");

		if(!count($data["form"])){
			$form = $this->db->get_where("Dosen",["ID"=>$ID])->row_array();
			unset($form["password"]);
			$data["form"] = $form;
		}


		$data["Kepangkatan"] = $this->db->get("Kepangkatan")->result_array();

		$this->load->view("dosen-pembimbing/forms",$data);
	}

	public function update(){
		$form["ID"] = $this->input->post("ID");
		$form["NIP"] = $this->input->post("NIP");
		$form["nama"] = $this->input->post("nama");
		$form["KepangkatanID"] = $this->input->post("KepangkatanID");
		$password = $this->input->post("password");

		if(!empty($password)) {
			$form["password"] = md5($password);
		}

		if(empty($form["NIP"]) || empty($form["nama"]) || empty($form["KepangkatanID"])) {
			$this->session->set_userdata("formDosen",$form);
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Seluruh data harus diisi!"]);
			redirect("/dosen-pembimbing/edit","refresh");			
		}

		$form["username"] = $this->input->post("NIP");
		$form["RolesID"] = 2;
		unset($form["NIP"]);
		$this->db->where('ID', $form["ID"]);
		if($this->db->update("User", $form)){
			$this->session->set_userdata("messages",["type"=>"info", "text"=> "Dosen berhasil diubah!"]);
			redirect("/dosen-pembimbing/lists","refresh");
		}else{
			$this->session->set_userdata("formDosen",$form);
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
			redirect("/dosen-pembimbing/edit","refresh");
		}
	}

	public function delete(){
		$ID = $this->input->get("id");

		if($this->db->delete("User", ["ID"=>$ID])){
			$this->session->set_userdata("messages",["type"=>"info", "text"=> "Dosen berhasil dihapus!"]);
			redirect("/dosen-pembimbing/lists","refresh");
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
			redirect("/dosen-pembimbing/lists","refresh");
		}
	}


}
