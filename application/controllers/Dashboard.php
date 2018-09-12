<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Base_Controller {

	public function index()
	{
		$user = $this->_data["user"];

		$data["msg"] = $this->session->userdata("messages");
		$this->session->unset_userdata("messages");

		if($user->class=="Dosen"){
			$data["DosenPembimbing"] = $this->db->select("*")->from("Bimbingan")->join("DosenPembimbing","DosenPembimbing.BimbinganID=Bimbingan.ID")->where("DosenID='$user->ID'")->get()->result();
			foreach($data["DosenPembimbing"] as $bimbingan){
				$pertemuan = $this->db->select()->from("Pertemuan")->where("BimbinganID='".$bimbingan->BimbinganID."' AND tgl_berikut is not null AND Pertemuan.DosenID=$user->ID")->order_by("tgl_berikut","desc")->get()->row();
				$bimbingan->mahasiswa =  $this->db->get_where("Mahasiswa","ID='".$bimbingan->MahasiswaID."'")->row();
				$bimbingan->bimbingan_selanjutnya =  null;
				if($pertemuan){
					$bimbingan->bimbingan_selanjutnya =  $pertemuan->tgl_berikut;
				}
			}

		}elseif($user->class=="Mahasiswa"){
			$data["DosenPembimbing"] = $this->db->get_where("Bimbingan", "MahasiswaID='$user->ID'")->row();
			$pertemuan = $this->db->select()->from("Pertemuan")->where("BimbinganID='".$data["DosenPembimbing"]->ID."' AND tgl_berikut is not null")->order_by("tgl_berikut","desc")->get()->row();
			$data["DosenPembimbing"]->bimbingan_selanjutnya =  null;
			if($pertemuan){
				$data["DosenPembimbing"]->bimbingan_selanjutnya =  $pertemuan->tgl_berikut;
			}
		}

		$this->load->view("dashboard/index", $data);
	}
	public function change_password()
	{
		$data["msg"] = $this->session->userdata("messages");
		$this->session->unset_userdata("messages");


		$this->load->view("dashboard/changepassword", $data);
	}

	public function set_password(){
		$user = $this->_data["user"];

		$oldpassword = $this->input->post("oldpassword");
		$newpassword1 = $this->input->post("newpassword1");
		$newpassword2 = $this->input->post("newpassword2");

		if(empty($oldpassword) || empty($newpassword1) || empty($newpassword2)){
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Seluruh data harus diisi!"]);
			redirect("/dashboard/change-password","refresh");			
		}elseif($newpassword1 != $newpassword2){
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Password baru tidak sama!"]);
			redirect("/dashboard/change-password","refresh");
		}elseif(md5($oldpassword)!=$user->password){
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Password tidak sesuai!"]);
			redirect("/dashboard/change-password","refresh");
		}else{
			$form["password"] = md5($newpassword1);

			$this->db->where('ID', $user->ID);
			if($this->db->update("User", $form)){
				$this->session->set_userdata("messages",["type"=>"info", "text"=> "Password berhasil diubah!"]);
				redirect("/dashboard/change-password","refresh");
			}else{
				$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
				redirect("/dashboard/change-password","refresh");
			}
		}
	}

	public function pedoman_skripsi()
	{
		$this->load->view("dashboard/pedoman-skripsi");
	}
}
