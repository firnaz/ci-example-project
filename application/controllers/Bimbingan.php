<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bimbingan extends Base_Controller {
    public $_allowedUserClass = array('User','Dosen'); 

	public function index()
	{
		redirect("/bimbingan/lists");
	}

	public function lists()
	{
		$data["msg"] = $this->session->userdata("messages");
		$this->session->unset_userdata("messages");

		$page = $this->input->get("page");
		$page = $page>0?($page-1):0;

		$limit = 25;
		$offset = $limit*$page;

		$user = $this->_data["user"];

		if($user->class=="Dosen"){
			$query = $this->db->select("Bimbingan.*")->from("Bimbingan")->join("DosenPembimbing","DosenPembimbing.BimbinganID=Bimbingan.ID")->where("DosenID='$user->ID'");
	    	// $query = $this->db->select()->from("Bimbingan")->where("Dosen1ID='$user->ID' OR Dosen2ID='$user->ID'");
		}else{
	    	$query = $this->db->select()->from("Bimbingan");
		}

    	$results = $query->limit($offset, $limit)->get()->result();

    	foreach($results as $result){
    		$result->mahasiswa = $this->db->get_where("mahasiswa",["ID"=>$result->MahasiswaID])->row();
    		$result->dosen1 = $this->db->select('*')->from("dosen")->join("DosenPembimbing","DosenPembimbing.DosenID = dosen.ID")->where("DosenPembimbing.BimbinganID=$result->ID AND no_pembimbing=1")->get()->row();
    		$result->dosen2 = $this->db->select('*')->from("dosen")->join("DosenPembimbing","DosenPembimbing.DosenID = dosen.ID")->where("DosenPembimbing.BimbinganID=$result->ID AND no_pembimbing=2")->get()->row();
    	}

    	$data["results"] = $results;

    	$totalresults = $query->count_all_results();

    	$data["pagination"] = createPagination($offset, count($data["results"]), $totalresults, $limit, $page);

		$this->load->view("bimbingan/lists", $data);
	}

	public function cari_mahasiswa(){
		$nim = $this->input->post("nim");

    	$query = $this->db->select("mahasiswa.*")->from("mahasiswa")->join("Bimbingan","Bimbingan.MahasiswaID=mahasiswa.ID", "Left")->where("mahasiswa.NIM='$nim'")->get();
    	$result = $query->row();

    	if($result){
    		$d["mahasiswa"] = ["ID"=>$result->ID, "NIM"=>$result->NIM, "nama"=>$result->nama, "tahun_masuk"=>$result->tahun_masuk];
    		$d["success"] = true;
    	}else{
    		$d["success"] = false;
    	}

    	echo json_encode($d);
	}

	public function create()
	{
		$data["action"] = "add";

		$data["msg"] = $this->session->userdata("messages");
		$this->session->unset_userdata("messages");

		$data["form"] = $this->session->userdata("formBimbingan");
		$this->session->unset_userdata("formBimbingan");

		// $data["mahasiswa"] = $this->db->select("Mahasiswa.*")->from("Mahasiswa")->join("DosenPembimbing","DosenPembimbing.MahasiswaID=Mahasiswa.ID", "Left")->where("DosenPembimbing.ID")->get()->result();

		$data["Dosens"] = $this->db->select("dosen.*, (select count(*) from DosenPembimbing where DosenID=dosen.ID AND tgl_sidang is null) jumlah_bimbingan")->from("dosen")->where("(select count(*) from DosenPembimbing where DosenID=dosen.ID AND tgl_sidang is null) < ".$this->_settings["jumlah_bimbingan"])->get()->result();

		$this->load->view("bimbingan/forms",$data);
	}

	public function edit()
	{
		$ID = $this->input->get("id");

		$data["action"] = "update";

		$data["msg"] = $this->session->userdata("messages");
		$this->session->unset_userdata("messages");


		$data["form"] = $this->session->userdata("formBimbingan");
		$this->session->unset_userdata("formBimbingan");

		if(!count($data["form"])){
			$form = $this->db->get_where("Bimbingan",["ID"=>$ID])->row_array();
			$data["form"] = $form;
			$dosen1 = $this->db->get_where("DosenPembimbing",["BimbinganID"=>$ID,"no_pembimbing"=>1])->row_array();
			$dosen2 = $this->db->get_where("DosenPembimbing",["BimbinganID"=>$ID,"no_pembimbing"=>2])->row_array();
			$data["form"]["Dosen1ID"] = $dosen1["DosenID"];
			$data["form"]["Dosen2ID"] = $dosen2["DosenID"];
			$tanggal = explode("-",$form["tgl_sah"]);
			$data["form"]["tanggal"] = $tanggal[2]."-".$tanggal[1]."-".$tanggal[0];
		}else{
			$tanggal = explode("-",$data["form"]["tgl_sah"]);
			$data["form"]["tanggal"] = $tanggal[2]."-".$tanggal[1]."-".$tanggal[0];			
		}
		$data["form"]["mahasiswa"] = $this->db->get_where("mahasiswa","ID=".$data["form"]["MahasiswaID"])->row_array();
		$data["form"]["dosen1"] = $this->db->get_where("dosen","ID=".$dosen1["DosenID"])->row_array();
		$data["form"]["dosen2"] = $this->db->get_where("dosen","ID=".$dosen2["DosenID"])->row_array();

		$data["Dosens"] = $this->db->select("dosen.*, (select count(*) from DosenPembimbing where DosenID=dosen.ID AND tgl_sidang is null) jumlah_bimbingan")->from("dosen")->where("(select count(*) from DosenPembimbing where DosenID=dosen.ID AND tgl_sidang is null) < ".$this->_settings["jumlah_bimbingan"]." or dosen.ID in (".$dosen1["DosenID"].", ".$dosen2["DosenID"].")")->get()->result();

		$this->load->view("bimbingan/forms",$data);
	}


	public function add()
	{
		$form["ID"]            = "";
		$form["tgl_sah"]       = $this->input->post("tgl_sah");
		$form["tanggal"]       = $this->input->post("tanggal");
		$form["judul_skripsi"] = $this->input->post("judul");
		$form["MahasiswaID"]   = $this->input->post("MahasiswaID");
		$dosen["Dosen1ID"]      = $this->input->post("Dosen1ID");
		$dosen["Dosen2ID"]      = $this->input->post("Dosen2ID");

		if(empty($form["tgl_sah"]) || empty($form["judul_skripsi"]) || empty($form["MahasiswaID"]) || empty($dosen["Dosen1ID"])){
			$this->session->set_userdata("formBimbingan",array_merge($form,$dosen));
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Seluruh data harus diisi!"]);
			redirect("/bimbingan/create","refresh");			
		}elseif($dosen["Dosen1ID"]==$dosen["Dosen2ID"]){
			$this->session->set_userdata("formBimbingan",array_merge($form,$dosen));
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Dosen Pembimbing ke 1 dan Dosen Pembimbing ke 2 tidak boleh sama!"]);
			redirect("/bimbingan/create","refresh");			
		}

		unset($form["tanggal"],$form["ID"]);

		$filesk = $_FILES["filesk"];
		if($filesk["size"]>0){
			$upload = uploadFileSK($this, $filesk);
			if(!$upload){
				$this->session->set_userdata("formBimbingan",array_merge($form,$dosen));
				redirect("/bimbingan/create","refresh");
			}else{
				$form = array_merge($form, $upload);
			}
		}

		$tgl_sah = strtotime($form["tgl_sah"]);
		$form["tgl_berakhir"] = date("Y-m-d", strtotime("+180 days", $tgl_sah));

		if($this->db->insert("Bimbingan", $form)){
			$bimbingan_id = $this->db->insert_id();
			for ($i=1; $i<=2; $i++){
				$data = array(
			        'BimbinganID' => $bimbingan_id,
			        'DosenID' => $dosen["Dosen".$i."ID"],
			        'no_pembimbing' => $i
				);
				$this->db->insert('DosenPembimbing', $data);
			}
			$this->session->set_userdata("messages",["type"=>"info", "text"=> "Bimbingan berhasil ditambahan!"]);
			redirect("/bimbingan/lists","refresh");
		}else{
			$this->session->set_userdata("formDosen",array_merge($form,$dosen));
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
			redirect("/bimbingan/create","refresh");
		}
	}

	public function update(){
		$form["ID"]            = $this->input->post("ID");
		$form["tgl_sah"]       = $this->input->post("tgl_sah");
		$form["tanggal"]       = $this->input->post("tanggal");
		$form["judul_skripsi"] = $this->input->post("judul");
		$form["MahasiswaID"]   = $this->input->post("MahasiswaID");
		$dosen["Dosen1ID"]      = $this->input->post("Dosen1ID");
		$dosen["Dosen2ID"]      = $this->input->post("Dosen2ID");


		if(empty($form["tgl_sah"]) || empty($form["judul_skripsi"]) || empty($form["MahasiswaID"]) || empty($dosen["Dosen1ID"])){
			$this->session->set_userdata("formBimbingan",array_merge($form,$dosen));
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Seluruh data harus diisi!"]);
			redirect("/bimbingan/edit","refresh");			
		}elseif($dosen["Dosen1ID"]==$dosen["Dosen2ID"]){
			$this->session->set_userdata("formDosen",array_merge($form,$dosen));
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Dosen Pembimbing ke 1 dan Dosen Pembimbing ke 2 tidak boleh sama!"]);
			redirect("/bimbingan/edit","refresh");			
		}
		unset($form["tanggal"]);

		$filesk = $_FILES["filesk"];
		if($filesk["size"]>0){
			$upload = uploadFileSK($this, $filesk);
			if(!$upload){
				$this->session->set_userdata("formBimbingan",array_merge($form,$dosen));
				redirect("/bimbingan/edit","refresh");
			}else{
				$form = array_merge($form, $upload);
			}
		}

		$tgl_sah = strtotime($form["tgl_sah"]);

		$form["tgl_berakhir"] = date("Y-m-d", strtotime("+180 days", $tgl_sah));

		$this->db->where('ID', $form["ID"]);
		if($this->db->update("Bimbingan", $form)){
			$this->session->set_userdata("messages",["type"=>"info", "text"=> "Bimbingan berhasil diubah!"]);
			redirect("/bimbingan/lists","refresh");
		}else{
			$this->session->set_userdata("formDosen",array_merge($form,$dosen));
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
			redirect("/bimbingan/edit","refresh");
		}
	}

	public function delete(){
		$ID = $this->input->get("id");

		if($this->db->delete("Bimbingan", ["ID"=>$ID])){
			$this->db->delete("DosenPembimbing", ["BimbinganID"=>$ID]);
			$this->session->set_userdata("messages",["type"=>"info", "text"=> "Bimbingan berhasil dihapus!"]);
			redirect("/bimbingan/lists","refresh");
		}else{
			$this->session->set_userdata("messages",["type"=>"danger", "text"=> "Ada masalah pada server!"]);
			redirect("/bimbingan/lists","refresh");
		}
	}
}
