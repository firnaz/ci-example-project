<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view("global/header");
?>
<div id="wrapper">
	<?php $this->load->view("global/navigation"); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Pedoman Skripsi</h1>

                    <p>
                    	Alur penulisan skripsi mahasiswa dapat dijelaskan sebagai berikut:
                    	<ol>
							<li>Mahasiswa telah memenuhi persyaratan untuk mengontrak skripsi sesuai buku pedoman akademik.</li>
							<li>Mahasiswa menghadap koordinator kelompok keilmuan (research group/cluster)untuk mengajukan judul proposal skripsi.</li>
							<li>Penentuan pembimbing disesuaikan aturan pedoman akademik Universitas. Selain itu, koordinator memperhatikan keseimbangan jumlah mahasiswa pada setiap pembimbing (adil).</li>
							<li>Dosen pembimbing skripsi disahkan dengan menggunakan Surat Keputusan (SK) dari dekan yang diusulkan oleh ketua jurusan dengan kordinasi dengan kelompok keilmuan, dengan masa berlaku 6 bulan dan bisa diperpanjang selama 6 bulan sekiranya dengan alasan sakit. Setelah waktu tersebut diterbitkan SK baru.</li>
							<li>Mahasiswa menyusun proposal penelitian sebagai hasil (output) dalam mata kuliah Riset TIK di bawah bimbingan dosen pengampu mata kuliah tersebut. Pada saat yang sama, mahasiswa bisa berkonsultasi dengan para calon pembimbing sesuai kelompok keilmuan masing-masing.</li>
							<li>Mahasiswa menyerahkan proposal nya 2 minggu sebelum perkulihan Mata Kuliah Skripsi dimulai. </li>
							<li>Setelah proposal disetujui dan ditandatangani dosen pembimbing, mahasiswa mendaftarkan diri kepada koordinator kelompok keilmuan untuk diproses lebih lanjut.</li>
							<li>Proses pembimbingan penyusunan skripsi sampai diijinkan untuk ikut ujian minimal telah melakukan 8 kali dari setiap pembimbing, kecuali ada rekomendasi dari pembimbing dan koordinator.</li>
							<li>Setelah skripsi dipandang memadai dengan ditandatangani oleh pembimbing, mahasiswa diijinkan mendaftarkan diri untuk mengikuti ujian sidang sarjana.</li>
							<li>Pendaftaran ujian sidang sarjana, dilakukan setelah kelengkapan administrasi dipenuhi dalam kurun waktu minimal dua minggu sebelum ujian sidang dilaksanakan.</li>
							<li>Apabila ada mahasiswa yang tidak lulus dalam ujian sidang , maka mahasiswa tersebut diwajibkan ikut ujian sidang berikutnya.</li>
							<li>Mahasiswa diwajibkan untuk menyusun artikel hasil penelitian. Dengan bantuan dosen pembimbing, artikel tersebut diajukan untuk dimuat pada jurnal ilmiah.</li>
                    	</ol>
                    </p>

                    <p>Pedoman skripsi selengkapnya dapat di download di <a href="<?=$this->_settings["pedoman_skripsi"];?>">sini</a>.</p>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("global/footer"); ?>