<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function createPagination($offset, $countresult, $totalresults, $limit, $page){ 
	return [
    		"currentrecord"=>$countresult>0?$offset+1:0,
    		"lastrecord"=>$offset+$countresult,
    		"totalrecord" => $totalresults,
    		"limit"=>$limit,
    		"currentpage"=>$page+1,
    		"totalpage"=>ceil($totalresults/$limit)
    	];
}

function uploadLampiranCatatan($controller, $lampiran, $id_pertemuan){
	$form["filename"]    = $lampiran["name"];
	$form["tipe_file"]   = $lampiran["type"];
	$form["ukuran_file"] = $lampiran["size"];
	$form["PertemuanID"] = $id_pertemuan;
	$form["tgl_upload"] = date("Y-m-d");

	$config['upload_path']   = realpath(STORAGEPATH);
	$config['file_name']     = md5(date("YmdHis").$lampiran["name"]);
	$config['allowed_types'] = 'gif|jpg|png|doc|docx|pdf|xls|xlsx|ppt|pptx';
	$config['max_size']      = '10240';

	$controller->load->library('upload', $config);

	if ($controller->upload->do_upload("lampiran")){
		$uploaded         = $controller->upload->data();
		$form["filepath"] = "_FILES"."/".$uploaded["file_name"];
		$controller->db->insert("FileBimbingan",$form);
	}else{
		$controller->session->set_userdata("messages",["type"=>"danger", "text"=> $controller->upload->display_errors()]);
	}
}

function uploadFileSK($controller, $file){
	$info["filename"]    = $file["name"];
	$info["tipe_file"]   = $file["type"];
	$info["ukuran_file"] = $file["size"];

	$config['upload_path']   = realpath(STORAGEPATH);
	$config['file_name']     = md5(date("YmdHis").$file["name"]);
	$config['allowed_types'] = 'gif|jpg|png|doc|docx|pdf|xls|xlsx|ppt|pptx';
	$config['max_size']      = '10240';

	$controller->load->library('upload', $config);

	if ($controller->upload->do_upload("filesk")){
		$uploaded         = $controller->upload->data();
		$info["filepath"] = "_FILES"."/".$uploaded["file_name"];
		return $info;
	}else{
		$controller->session->set_userdata("messages",["type"=>"danger", "text"=> $controller->upload->display_errors()]);
		return false;
	}
}