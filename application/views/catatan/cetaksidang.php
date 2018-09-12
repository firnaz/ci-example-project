<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view("global/header");
?>
<div style="max-width:800px">
	<div class="col-md-10">
		<h3 class="text-center">Lembar Persetujuan Pembimbing</h3>
		<h3 class="text-center">Untuk Pendaftaran Ujian Skripsi</h3>
		<br><br>
		<div class="col-md-12">
			<div class="col-xs-4 col-md-4"><strong>Nama Mahasiswa</strong></div>
			<div class="col-xs-8 col-md-8"><?=$Mahasiswa->nama?></div>
		</div>
		<div class="col-md-12">
			<div class="col-xs-4 col-md-4"><strong>NIM</strong></div>
			<div class="col-xs-8 col-md-8"><?=$Mahasiswa->NIM?></div>
		</div>
		<div class="col-md-12">
			<div class="col-xs-4 col-md-4"><strong>Tahun Masuk</strong></div>
			<div class="col-xs-8 col-md-8"><?=$Mahasiswa->tahun_masuk?></div>
		</div>
		<div class="col-md-12">
			<div class="col-xs-4 col-md-4"><strong>Judul Skripsi</strong></div>
			<div class="col-xs-8 col-md-8"><?=$Bimbingan->judul_skripsi?></div>
		</div>
		<br><br><br><br><br>
		<div class="col-md-12">
			<div class="col-md-12">Menyatakan Mahasiswa tersebut diatas sudah selesai masa Bimbingan Skripsi, dan disetujui untuk pendaftaran Ujian Skripsi.</div>
		</div>
		<br><br>
		<div class="col-md-12">
			<div class="col-xs-6 col-md-6"></div>
			<?php 
				$s1 = strtotime($Dosen1->tgl_sidang);
				$s2 = strtotime($Dosen2->tgl_sidang);
				$tgl = $s1>$s2?date("d-m-Y",$s1):date("d-m-Y",$s2);
			?>
			<div class="col-xs-6 col-md-6">Jakarta, <?=$tgl?></div>
		</div>
		<br><br>
		<div class="col-md-12">
			<div class="col-xs-5 col-md-5">
				<p class="text-center">Dosen Pembimbing I</p>
				<br><br>
				<p class="text-center">( <?=$Dosen1->nama?> )<br>NIP. <?=$Dosen1->NIP?></p>
			</div>
			<div class="col-xs-5 col-md-5">
				<p class="text-center">Dosen Pembimbing II</p>
				<br><br>
				<p class="text-center">( <?=$Dosen2->nama?> )<br>NIP. <?=$Dosen2->NIP?></p>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	window.print();
	// window.close();
</script>
<?php $this->load->view("global/footer"); ?>
