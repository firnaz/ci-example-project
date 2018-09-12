<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Base_Controller {

	public function index()
	{
		$data["msg"] = $this->session->userdata("messages");
		$this->session->unset_userdata("messages");

		$this->load->view("global/header");
		$this->load->view("login/index",$data);
		$this->load->view("global/footer");
	}


	public function otentikasi()
	{

		$username = $this->input->post("username");
		$password = $this->input->post("password");

		// $class = $this->input->post("user_type");
		// $this->load->model($class, "user");

		if(empty($username) || empty($password)){
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Tipe user, username dan password tidak boleh kosong!"]);
			redirect("/login/index");
		}else{
			$this->load->model("User");
			$this->load->model("Mahasiswa");
			$this->load->model("Dosen");

			if($this->User->auth($username,$password) || $this->Dosen->auth($username,$password) || $this->Mahasiswa->auth($username,$password)){
				redirect("/dashboard");
			}else{
				$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Username atau password salah!"]);
				redirect("/login/index");				
			}
		}
	}


	public function logout()
	{
		$this->session->set_userdata("messages",["type"=>"success", "text"=> "Anda sudah berhasil logout!"]);
		$this->session->unset_userdata('user');
		$this->session->unset_userdata('DosenPembimbingID');
		redirect('login/index');
	}
}
