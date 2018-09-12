<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catatan extends Base_Controller {

	public function index()
	{
		redirect("/catatan/lists");
	}

	public function lists(){
		$page = $this->input->get("page");
		$page = $page>0?($page-1):0;

		$limit = 10;
		$offset = $limit*$page;

		$data["msg"] = $this->session->userdata("messages");
		$this->session->unset_userdata("messages");

		$ID = $this->input->get("id");
		if($ID){
			$this->session->set_userdata("BimbinganID",$ID);
		}else{
			$ID = $this->session->userdata("BimbinganID");			
		}
		$user = $this->_data["user"];

		if($user->class=="Dosen"){
			// print_r($user);exit;
			$Bimbingan = $this->db->select("Bimbingan.*")->from("Bimbingan")->join("DosenPembimbing","Bimbingan.ID=DosenPembimbing.BimbinganID")->where(["Bimbingan.ID"=>$ID, "DosenID"=>$user->ID])->get()->row();
			// print_r($Bimbingan);exit;
		}elseif($user->class=="Mahasiswa"){
			$Bimbingan = $this->db->get_where("Bimbingan","MahasiswaID='".$user->ID."'")->row();
		}else{
			$Bimbingan = $this->db->get_where("Bimbingan","ID='$ID'")->row();
		}


		if($Bimbingan){
			$this->session->set_userdata("BimbinganID",$Bimbingan->ID);
			$data["Mahasiswa"] = $this->db->get_where("mahasiswa", "ID='".$Bimbingan->MahasiswaID."'")->row();
			$data["Dosen1"] = $this->db->select('*')->from("dosen")->join("DosenPembimbing","DosenPembimbing.DosenID = dosen.ID")->where("DosenPembimbing.BimbinganID=$Bimbingan->ID AND no_pembimbing=1")->get()->row();
			$data["Dosen2"] = $this->db->select('*')->from("dosen")->join("DosenPembimbing","DosenPembimbing.DosenID = dosen.ID")->where("DosenPembimbing.BimbinganID=$Bimbingan->ID AND no_pembimbing=2")->get()->row();

			$data["Pertemuan"] = $this->db->select()->from("Pertemuan")->where("BimbinganID='".$Bimbingan->ID."'")->order_by("tgl_bimbingan", "DESC")->limit($limit,$offset)->get()->result();
			foreach($data["Pertemuan"] as $pertemuan){
				$pertemuan->dosen = null;
				$pertemuan->balasan = array();
				if($pertemuan->DosenID){
					$pertemuan->dosen = $this->db->get_where("dosen","ID='".$pertemuan->DosenID."'")->row();
				}

				$pertemuan->file = $this->db->get_where("FileBimbingan","PertemuanID='".$pertemuan->ID."'")->row();

				$pertemuan->balasan = $this->db->get_where("Pertemuan", "RefID='".$pertemuan->ID."'")->result();
				foreach($pertemuan->balasan as $t){
					$t->dosen = null;
					if($t->DosenID){
						$t->dosen = $this->db->get_where("dosen","ID='".$t->DosenID."'")->row();
					}
					$t->file = $this->db->get_where("FileBimbingan","PertemuanID='".$t->ID."'")->row();
				}
			}

	    	$totalresults = $this->db->where("BimbinganID='".$Bimbingan->ID."'")->count_all_results('Pertemuan');

	    	$data["pagination"] = createPagination($offset, count($data["Pertemuan"]), $totalresults, $limit, $page);


			$data["Bimbingan"] = $Bimbingan;

			$this->load->view("catatan/lists",$data);
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses!"]);
			redirect("/dashboard/index","refresh");
		}		
	}

	public function add(){
		$user = $this->_data["user"];
				// print_r($_POST);exit;

		if($this->is_allowed_show()){
			$form["tgl_bimbingan"]     = date("Y-m-d H:i:s");
			$ID = $this->session->userdata("BimbinganID");
			if($user->class=="Dosen"){
				$tgl_berikut = $this->input->post("tgl_berikut");
				$form["tgl_berikut"]       = empty($tgl_berikut)?null:$tgl_berikut;
				$form["judul"]             = $this->input->post("judul");
				$form["arahan"]            = $this->input->post("arahan");
				$form["BimbinganID"] 		= $ID;
				$form["DosenID"]           = $user->ID;
				$form["readonly"]          = $this->input->post("readonly")?$this->input->post("readonly"):0;
			}else{
				$form["tanggapan"]         = $this->input->post("tanggapan");
			}

			if(!$this->db->insert("Pertemuan", $form)){
				$form["tanggal"]     = $this->input->post("tanggal");
				$this->session->set_userdata("formCatatan",$form);
				$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
			}

			$lampiran = $_FILES["lampiran"];
			if($lampiran["size"]>0){
				uploadLampiranCatatan($this, $lampiran, $this->db->insert_id());
			}

			$this->session->set_userdata("messages",["type"=>"info", "text"=> "Catatan berhasil ditambahkan!"]);
			redirect("/catatan/lists","refresh");
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk menambah catatan!"]);
			redirect("/dashboard/index","refresh");
		}		
	}

	public function tanggapan(){
		$user = $this->_data["user"];

		if($this->is_allowed_show()){
			if($user->class=="Dosen"){
				$form["DosenID"] = $user->ID;
			}
			$form["tgl_bimbingan"]     = date("Y-m-d H:i:s");
			$form["BimbinganID"] = 0;
			$form["tanggapan"]         = $this->input->post("tanggapan");
			$form["RefID"]             = $this->input->post("RefID");

			if(!$this->db->insert("Pertemuan", $form)){
				$form["tanggal"]     = $this->input->post("tanggal");
				$this->session->set_userdata("formCatatan",$form);
				$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
			}
			$this->session->set_userdata("messages",["type"=>"info", "text"=> "Tanggapan berhasil ditambahkan!"]);
			$lampiran = $_FILES["lampiran"];
			if($lampiran["size"]>0){
				uploadLampiranCatatan($this, $lampiran, $this->db->insert_id());
			}

			redirect("/catatan/lists","refresh");
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk memberikan tanggapan!"]);
			redirect("/dashboard/index","refresh");
		}		
	}

	public function delete(){
		$user = $this->_data["user"];

		if($this->is_allowed_show()){
			$id_pertemuan = $this->input->get("id");
			$pertemuan = $this->db->get_where("Pertemuan", "DosenID='".$user->ID."' AND ID='".$id_pertemuan."'")->row();
			if($pertemuan){
				if(!$this->db->delete("Pertemuan", ["ID"=>$id_pertemuan])){
					$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
				}
				$this->db->delete("Pertemuan", ["RefID"=>$id_pertemuan]);
			}else{
				$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk menghapus catatan ini!"]);
			}
			$this->session->set_userdata("messages",["type"=>"info", "text"=> "Catatan berhasil dihapus!"]);
			redirect("/catatan/lists","refresh");
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk menghapus catatan ini!"]);
			redirect("/dashboard/index","refresh");
		}		
	}

	public function lock(){
		$user = $this->_data["user"];

		if($this->is_allowed_show()){
			$id_pertemuan = $this->input->get("id");
			$pertemuan = $this->db->get_where("Pertemuan", "DosenID='".$user->ID."' AND ID='".$id_pertemuan."'")->row();
			if($pertemuan){
				$form["readonly"] = 1;
				$this->db->where('ID', $id_pertemuan);
				if(!$this->db->update("Pertemuan", $form)){
					$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
				}
			}else{
				$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk mengubah status catatan ini!"]);
			}
			redirect("/catatan/lists","refresh");
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk mengubah status catatan ini!"]);
			redirect("/dashboard/index","refresh");
		}		
	}

	public function unlock(){
		$user = $this->_data["user"];

		if($this->is_allowed_show()){
			$id_pertemuan = $this->input->get("id");
			$pertemuan = $this->db->get_where("Pertemuan", "DosenID='".$user->ID."' AND ID='".$id_pertemuan."'")->row();
			if($pertemuan){
				$form["readonly"] = 0;
				$this->db->where('ID', $id_pertemuan);
				if(!$this->db->update("Pertemuan", $form)){
					$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
				}
			}else{
				$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk mengubah status catatan ini!"]);
			}
			redirect("/catatan/lists","refresh");
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk mengubah status catatan ini!"]);
			redirect("/dashboard/index","refresh");
		}		
	}


	private function is_allowed_show(){
		$ID = $this->session->userdata("BimbinganID");
		$user = $this->_data["user"];

		if($user->class=="Dosen"){
			$Bimbingan = $this->db->select()->from("Bimbingan")->join("DosenPembimbing","Bimbingan.ID=DosenPembimbing.BimbinganID")->where(["Bimbingan.ID"=>$ID,"DosenID"=>$user->ID])->get()->row();		
		}elseif($user->class=="Mahasiswa"){
			$Bimbingan = $this->db->get_where("Bimbingan","ID='$ID' AND (MahasiswaID='".$user->ID."')")->row();
		}

		if($Bimbingan) {
			return true;
		}
		return false;
	} 

	public function proposal(){
		$ID = $this->session->userdata("BimbinganID");
		$user = $this->_data["user"];

		if($this->is_allowed_show()){
			if($user->class=="Dosen"){
				$DosenPembimbing = $this->db->get_where("DosenPembimbing","BimbinganID='$ID' AND DosenID='$user->ID'")->row();
				$form["tgl_proposal"]= date("Y-m-d"); 
				$this->db->where('ID', $DosenPembimbing->ID);
				if(!$this->db->update("DosenPembimbing", $form)){
					$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
				}
				redirect("/catatan/lists","refresh");
			}else{
				$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk menyetujui Seminar proposal mahasiswa ini!"]);
				redirect("/dashboard/index","refresh");
			}
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk menyetujui Seminar proposal mahasiswa ini!"]);
			redirect("/dashboard/index","refresh");
		}
	}

	public function seminar(){
		$ID = $this->session->userdata("BimbinganID");
		$user = $this->_data["user"];

		if($this->is_allowed_show()){
			if($user->class=="Dosen"){
				$DosenPembimbing = $this->db->get_where("DosenPembimbing","BimbinganID='$ID' AND DosenID='$user->ID'")->row();
				$form["tgl_seminar"]= date("Y-m-d"); 
				$this->db->where('ID', $DosenPembimbing->ID);
				if(!$this->db->update("DosenPembimbing", $form)){
					$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
				}
				redirect("/catatan/lists","refresh");
			}else{
				$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk menyetujui Seminar hasil mahasiswa ini!"]);
				redirect("/dashboard/index","refresh");
			}
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk menyetujui Seminar hasil mahasiswa ini!"]);
			redirect("/dashboard/index","refresh");
		}
	}

	public function sidang(){
		$ID = $this->session->userdata("BimbinganID");
		$user = $this->_data["user"];

		if($this->is_allowed_show()){
			if($user->class=="Dosen"){
				$DosenPembimbing = $this->db->get_where("DosenPembimbing","BimbinganID='$ID' AND DosenID='$user->ID'")->row();
				$form["tgl_sidang"]= date("Y-m-d"); 
				$this->db->where('ID', $DosenPembimbing->ID);
				if(!$this->db->update("DosenPembimbing", $form)){
					$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
				}
				redirect("/catatan/lists","refresh");
			}else{
				$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk menyetujui Sidang mahasiswa ini!"]);
				redirect("/dashboard/index","refresh");
			}
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk menyetujui Sidang mahasiswa ini!"]);
			redirect("/dashboard/index","refresh");
		}
	}


	public function cetaksurat(){
		$user = $this->_data["user"];
		if($user->class=="Mahasiswa"){
			$Bimbingan = $this->db->get_where("Bimbingan","MahasiswaID='".$user->ID."'")->row();
			if($Bimbingan){
				$data["Dosen1"] = $this->db->select('*')->from("dosen")->join("DosenPembimbing","DosenPembimbing.DosenID = dosen.ID")->where("DosenPembimbing.BimbinganID=$Bimbingan->ID AND no_pembimbing=1")->get()->row();
				$data["Dosen2"] = $this->db->select('*')->from("dosen")->join("DosenPembimbing","DosenPembimbing.DosenID = dosen.ID")->where("DosenPembimbing.BimbinganID=$Bimbingan->ID AND no_pembimbing=2")->get()->row();
				$data["Bimbingan"] = $Bimbingan;
				$this->load->view("catatan/cetaksurat",$data);
			}else {
				$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk mencetak!"]);
				redirect("/dashboard/index","refresh");
			}
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk mencetak!"]);
			redirect("/dashboard/index","refresh");
		}
	}

	public function cetak_lembar_proposal(){
		$user = $this->_data["user"];
		if($user->class=="Mahasiswa"){
			$Bimbingan = $this->db->get_where("Bimbingan","MahasiswaID='".$user->ID."'")->row();
			$Dosen1 = $this->db->select('*')->from("dosen")->join("DosenPembimbing","DosenPembimbing.DosenID = dosen.ID")->where("DosenPembimbing.BimbinganID=$Bimbingan->ID AND no_pembimbing=1")->get()->row();
			$Dosen2 = $this->db->select('*')->from("dosen")->join("DosenPembimbing","DosenPembimbing.DosenID = dosen.ID")->where("DosenPembimbing.BimbinganID=$Bimbingan->ID AND no_pembimbing=2")->get()->row();
			if($Bimbingan && $Dosen1->tgl_proposal && $Dosen2->tgl_proposal){
				$data["Bimbingan"] = $Bimbingan;
				$data["Mahasiswa"] = $this->db->get_where("mahasiswa", "ID='".$Bimbingan->MahasiswaID."'")->row();
				$data["Dosen1"] = $Dosen1;
				$data["Dosen2"] = $Dosen2;
				$this->load->view("catatan/cetakproposal",$data);
			}else {
				$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk mencetak!"]);
				redirect("/dashboard/index","refresh");
			}
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk mencetak!"]);
			redirect("/dashboard/index","refresh");
		}		
	}
	public function cetak_lembar_seminar(){
		$user = $this->_data["user"];
		if($user->class=="Mahasiswa"){
			$Bimbingan = $this->db->get_where("Bimbingan","MahasiswaID='".$user->ID."'")->row();
			$Dosen1 = $this->db->select('*')->from("dosen")->join("DosenPembimbing","DosenPembimbing.DosenID = dosen.ID")->where("DosenPembimbing.BimbinganID=$Bimbingan->ID AND no_pembimbing=1")->get()->row();
			$Dosen2 = $this->db->select('*')->from("dosen")->join("DosenPembimbing","DosenPembimbing.DosenID = dosen.ID")->where("DosenPembimbing.BimbinganID=$Bimbingan->ID AND no_pembimbing=2")->get()->row();
			if($Bimbingan && $Dosen1->tgl_seminar && $Dosen2->tgl_seminar){
				$data["Bimbingan"] = $Bimbingan;
				$data["Mahasiswa"] = $this->db->get_where("mahasiswa", "ID='".$Bimbingan->MahasiswaID."'")->row();
				$data["Dosen1"] = $Dosen1;
				$data["Dosen2"] = $Dosen2;
				$this->load->view("catatan/cetakseminar",$data);
			}else {
				$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk mencetak!"]);
				redirect("/dashboard/index","refresh");
			}
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk mencetak!"]);
			redirect("/dashboard/index","refresh");
		}		
	}
	public function cetak_lembar_sidang(){
		$user = $this->_data["user"];
		if($user->class=="Mahasiswa"){
			$Bimbingan = $this->db->get_where("Bimbingan","MahasiswaID='".$user->ID."'")->row();
			$Dosen1 = $this->db->select('*')->from("dosen")->join("DosenPembimbing","DosenPembimbing.DosenID = dosen.ID")->where("DosenPembimbing.BimbinganID=$Bimbingan->ID AND no_pembimbing=1")->get()->row();
			$Dosen2 = $this->db->select('*')->from("dosen")->join("DosenPembimbing","DosenPembimbing.DosenID = dosen.ID")->where("DosenPembimbing.BimbinganID=$Bimbingan->ID AND no_pembimbing=2")->get()->row();
			if($Bimbingan && $Dosen1->tgl_sidang && $Dosen2->tgl_sidang){
				$data["Bimbingan"] = $Bimbingan;
				$data["Mahasiswa"] = $this->db->get_where("Mahasiswa", "ID='".$Bimbingan->MahasiswaID."'")->row();
				$data["Dosen1"] = $Dosen1;
				$data["Dosen2"] = $Dosen2;
				$this->load->view("catatan/cetaksidang",$data);
			}else {
				$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk mencetak!"]);
				redirect("/dashboard/index","refresh");
			}
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Anda tidak memiliki akses untuk mencetak!"]);
			redirect("/dashboard/index","refresh");
		}		
	}
}