<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends Base_Controller {
    public $_allowedUserClass = array('Mahasiswa','Dosen', 'User'); 

	public function filebimbingan($id,$file)
	{
		$id = urldecode($id);
		$file = urldecode($file);

		$filebimbingan= $this->db->get_where("FileBimbingan","ID='$id' AND filename='$file'")->row();

		if($filebimbingan && file_exists($filebimbingan->filepath)){
			header("content-length:".$filebimbingan->ukuran_file);
			header("accept-ranges:bytes");
    		header('Content-Disposition: attachment; filename="'.basename($filebimbingan->filename).'"');
	    	header('Content-Transfer-Encoding: binary');
	    	header("content-type:".$filebimbingan->tipe_file);
			flush();
			readfile($filebimbingan->filepath);
			exit;
		}else{
			echo "FIlE NOT FOUND!!";
		}
	}

	public function filesk($id,$file)
	{
		$id = urldecode($id);
		$file = urldecode($file);

		$filesk= $this->db->get_where("Bimbingan","ID='$id' AND filename='$file'")->row();

		if($filesk && file_exists($filesk->filepath)){
			header("content-length:".$filesk->ukuran_file);
			header("accept-ranges:bytes");
    		header('Content-Disposition: attachment; filename="'.basename($filesk->filename).'"');
	    	header('Content-Transfer-Encoding: binary');
	    	header("content-type:".$filesk->tipe_file);
			flush();
			readfile($filesk->filepath);
			exit;
		}else{
			echo "FIlE NOT FOUND!!";
		}
	}

}