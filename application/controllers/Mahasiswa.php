<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends Base_Controller {
    public $_allowedUserClass = array('User'); 

	public function index()
	{
		redirect("/mahasiswa/lists");
	}

	public function lists()
	{
		$data["msg"] = $this->session->userdata("messages");
		$this->session->unset_userdata("messages");

		$page = $this->input->get("page");
		$page = $page>0?($page-1):0;

		$limit = 25;
		$offset = $limit*$page;

    	$query = $this->db->get("mahasiswa",$offset, $limit);
    	$data["results"] = $query->result();

    	$totalresults = $this->db->count_all('mahasiswa');
    	$data["pagination"] = createPagination($offset, count($data["results"]), $totalresults, $limit, $page);

		$this->load->view("mahasiswa/lists", $data);
	}

	public function create(){

		$data["action"] = "add";

		$data["msg"] = $this->session->userdata("messages");
		$this->session->unset_userdata("messages");

		$data["form"] = $this->session->userdata("formMahasiswa");
		$this->session->unset_userdata("formMahasiswa");


		$this->load->view("mahasiswa/forms",$data);
	}

	public function add(){
		$form["NIM"] = $this->input->post("NIM");
		$form["nama"] = $this->input->post("nama");
		$form["tahun_masuk"] = $this->input->post("tahun_masuk");
		$form["password"] = md5($this->input->post("password"));


		if(empty($form["NIM"]) || empty($form["nama"]) || empty($form["tahun_masuk"]) || empty($form["password"])){
			$this->session->set_userdata("formMahasiswa",$form);
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Seluruh data harus diisi!"]);
			redirect("/mahasiswa/create","refresh");			
		}

		$form["username"] = $this->input->post("NIM");
		$form["RolesID"] = 3;
		unset($form["NIM"]);
		if($this->db->insert("User", $form)){
			$this->session->set_userdata("messages",["type"=>"info", "text"=> "Mahasiswa berhasil ditambahkan!"]);
			redirect("/mahasiswa/lists","refresh");
		}else{
			$this->session->set_userdata("formMahasiswa",$form);
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
			redirect("/mahasiswa/create","refresh");
		}
	}

	public function edit(){
		$ID = $this->input->get("id");

		$data["action"] = "update";

		$data["msg"] = $this->session->userdata("messages");
		$this->session->unset_userdata("messages");


		$data["form"] = $this->session->userdata("formMahasiswa");
		$this->session->unset_userdata("formMahasiswa");

		if(!count($data["form"])){
			$form = $this->db->get_where("Mahasiswa",["ID"=>$ID])->row_array();
			unset($form["password"]);
			$data["form"] = $form;
		}

		$this->load->view("mahasiswa/forms",$data);
	}

	public function update(){
		$form["ID"] = $this->input->post("ID");
		$form["NIM"] = $this->input->post("NIM");
		$form["nama"] = $this->input->post("nama");
		$form["tahun_masuk"] = $this->input->post("tahun_masuk");
		$password = $this->input->post("password");

		if(!empty($password)) {
			$form["password"] = md5($password);
		}

		if(empty($form["NIM"]) || empty($form["nama"]) || empty($form["tahun_masuk"])) {
			$this->session->set_userdata("formMahasiswa",$form);
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Seluruh data harus diisi!"]);
			redirect("/mahasiswa/edit","refresh");			
		}

		$form["username"] = $this->input->post("NIM");
		$form["RolesID"] = 3;
		unset($form["NIM"]);
		$this->db->where('ID', $form["ID"]);
		if($this->db->update("User", $form)){
			$this->session->set_userdata("messages",["type"=>"info", "text"=> "Mahasiswa berhasil diubah!"]);
			redirect("/mahasiswa/lists","refresh");
		}else{
			$this->session->set_userdata("formMahasiswa",$form);
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
			redirect("/mahasiswa/edit","refresh");
		}
	}

	public function delete(){
		$ID = $this->input->get("id");

		if($this->db->delete("User", ["ID"=>$ID])){
			$this->session->set_userdata("messages",["type"=>"info", "text"=> "Mahasiswa berhasil dihapus!"]);
			redirect("/mahasiswa/lists","refresh");
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
			redirect("/mahasiswa/lists","refresh");
		}
	}


}
